<?php


/*****************************
 *
 * RouterOS PHP API class v1.7
 * Author: Denis Basta
 * Contributors:
 *    Nick Barnes
 *    Ben Menking (ben [at] infotechsc [dot] com)
 *    Jeremy Jefferson (http://jeremyj.com)
 *    Cristian Deluxe (djcristiandeluxe [at] gmail [dot] com)
 *    Mikhail Moskalev (mmv.rus [at] gmail [dot] com)
 * 	  Sohag Hosen (sohag1426 [at] gmail [dot] com)
 * http://www.mikrotik.com
 * http://wiki.mikrotik.com/wiki/API_PHP_class
 *
 ******************************/

namespace RouterOS\Sohag;

use Exception,
    \Iterator,
    \Traversable,
    \IteratorAggregate;

use function array_keys;
use function array_shift;
use function chr;
use function count;
use function is_array;
use function md5;
use function pack;
use function preg_match_all;
use function sleep;
use function trim;


class RouterosAPI

{

    /**
     * Host to connect
     *
     * @var string
     */
    protected $host = '';


    /**
     * User to connect
     *
     * @var string
     */
    protected $user = '';



    /**
     * Pass to connect
     *
     * @var string
     */
    protected $pass = '';



    /**
     * Port to connect to (default 8729 for ssl)
     *
     * @var int
     */
    protected $port = 8728;


    /**
     * Connect using SSL (must enable api-ssl in IP/Services)
     *
     * @var boolean
     */
    protected $ssl = false;


    /**
     * Connection attempt timeout and data read timeout
     *
     * @var int
     */
    protected $timeout = 2;


    /**
     * Connection attempt count
     *
     * @var int
     */
    protected $attempts = 2;


    /**
     * Delay between connection attempts in seconds
     *
     * @var int
     */
    protected $delay = 2;


    /**
     * Show debug information
     *
     * @var boolean
     */
    protected $debug = false;


    /**
     * Connection state
     *
     * @var boolean
     */
    private $connected = false;



    /**
     * Variable for storing socket resource
     *
     * @var object
     */
    protected $socket;


    /**
     * Variable for storing connection error number, if any
     *
     * @var int
     */
    public $error_no;


    /**
     * Variable for storing connection error text, if any
     *
     * @var string
     */
    public $error_str;


    /**
     * Variable for storing response after sending login command
     *
     * @var string
     */
    public $login_respone;


    /**
     * Variable for storing legacy login respone
     *
     * @var string
     */
    public $legacy_login_respone;


    /**
     * Constructor
     *
     * @param array $config
     */


    public function __construct(array $config)
    {
        $default = [
            'host' => '',
            'user' => '',
            'pass' => '',
            'port' => 8728,
            'ssl' => false,
            'timeout' => 5,
            'attempts' => 2,
            'delay' => 2,
            'debug' => false,
        ];

        $properties = array_merge($default, $config);

        if (!strlen($properties['host'])) {
            throw new Exception('Router not found');
        }

        if (!strlen($properties['user'])) {
            throw new Exception('RouterOs API User not found');
        }

        if (!strlen($properties['pass'])) {
            throw new Exception('Access Denied');
        }

        $this->host = $properties['host'];
        $this->user = $properties['user'];
        $this->pass = $properties['pass'];
        $this->port = $properties['port'];
        $this->ssl = $properties['ssl'];
        $this->timeout = $properties['timeout'];
        $this->attempts = $properties['attempts'];
        $this->delay = $properties['delay'];
        $this->debug = $properties['debug'];
    }



    /**
     * Check, can be var used in foreach
     * @param array $var
     * @return boolean
     */
    public function isIterable($var)
    {
        return $var !== null
            && (is_array($var)
                || $var instanceof Traversable
                || $var instanceof Iterator
                || $var instanceof IteratorAggregate);
    }


    /**
     * Print text for debug purposes
     * @param string  $text Text to print
     * @return void
     */
    public function debug($text)
    {
        if ($this->debug) {
            echo $text . "\n";
        }
    }


    /**
     * Encode Length
     *
     * @param string  $length
     * @return void
     */
    public function encodeLength($length)
    {
        if ($length < 0x80) {
            $length = chr($length);
        } elseif ($length < 0x4000) {
            $length |= 0x8000;
            $length = chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length < 0x200000) {
            $length |= 0xC00000;
            $length = chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length < 0x10000000) {
            $length |= 0xE0000000;
            $length = chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        } elseif ($length >= 0x10000000) {
            $length = chr(0xF0) . chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
        }

        return $length;
    }


    /**
     * Login to RouterOS
     *
     * @param string  $ip       Hostname (IP or domain) of the RouterOS server
     * @param string  $login    The RouterOS username
     * @param string  $password The RouterOS password
     * @return boolean If we are connected or not
     */
    public function connect($ip, $login, $password)
    {
        if (!strlen($ip)) {
            return 0;
        }

        if (!strlen($login)) {
            return 0;
        }

        if (!strlen($password)) {
            return 0;
        }

        //Do not Reconnect if already connected
        if (is_resource($this->socket)) {
            $this->connected = true;
            return 1;
        }

        //try login
        for ($ATTEMPT = 1; $ATTEMPT <= $this->attempts; $ATTEMPT++) {
            $this->connected = false;
            $PROTOCOL = ($this->ssl ? 'ssl://' : '');
            $context = stream_context_create(array('ssl' => array('ciphers' => 'ADH:ALL', 'verify_peer' => false, 'verify_peer_name' => false)));
            $this->debug('Connection attempt #' . $ATTEMPT . ' to ' . $PROTOCOL . $ip . ':' . $this->port . '...');
            $this->socket = @stream_socket_client($PROTOCOL . $ip . ':' . $this->port, $this->error_no, $this->error_str, $this->timeout, STREAM_CLIENT_CONNECT, $context);
            if ($this->socket) {
                socket_set_timeout($this->socket, $this->timeout);
                $this->write('/login', false);
                $this->write('=name=' . $login, false);
                $this->write('=password=' . $password);
                $RESPONSE = $this->read(false);
                $this->login_respone = $RESPONSE;
                if (isset($RESPONSE[1])) {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $RESPONSE[1], $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret' && strlen($MATCHES[0][1]) == 32) {
                            $this->write('/login', false);
                            $this->write('=name=' . $login, false);
                            $this->write('=response=00' . md5(chr(0) . $password . pack('H*', $MATCHES[0][1])));
                            $RESPONSE = $this->read(false);
                            $this->legacy_login_respone = $RESPONSE;
                            if (isset($RESPONSE[0]) && $RESPONSE[0] === '!done') {
                                $this->connected = true;
                                break;
                            }
                        }
                    }
                } else {
                    if (isset($RESPONSE[0]) && $RESPONSE[0] === '!done') {
                        $this->connected = true;
                        break;
                    }
                }
                fclose($this->socket);
            }
            sleep($this->delay);
        }
        if ($this->connected) {
            $this->debug('Connected...');
        } else {
            $this->debug('Error...');
        }
        return $this->connected;
    }


    /**
     * Disconnect from RouterOS
     *
     * @return void
     */
    public function disconnect()
    {
        // let's make sure this socket is still valid.  it may have been closed by something else
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
        $this->connected = false;
        $this->debug('Disconnected...');
    }


    /**
     * This method was created by memory save reasons, it convert response
     * from RouterOS to readable array in safe way.
     *
     * @param array $raw Array RAW response from server
     *
     * @return mixed
     *
     * Based on RouterOSResponseArray solution by @arily
     *
     * @link    https://github.com/arily/RouterOSResponseArray
     * @since   1.0.0
     */
    private function rosario(array $raw): array
    {
        // This RAW should't be an error
        $positions = array_keys($raw, '!re');
        $count     = count($raw);
        $result    = [];

        if (isset($positions[1])) {

            foreach ($positions as $key => $position) {
                // Get length of future block
                $length = isset($positions[$key + 1])
                    ? $positions[$key + 1] - $position + 1
                    : $count - $position;

                // Convert array to simple items
                $item = [];
                for ($i = 1; $i < $length; $i++) {
                    $item[] = array_shift($raw);
                }

                // Save as result
                $result[] = $this->parseResponse($item)[0];
            }
        } else {
            $result = $this->parseResponse($raw);
        }

        return $result;
    }


    /**
     * Parse response from Router OS
     *
     * @param array $response Response data
     *
     * @return array Array with parsed data
     */
    public function parseResponse(array $response): array
    {
        $result = [];
        $i      = -1;
        $lines  = count($response);
        foreach ($response as $key => $value) {
            switch ($value) {
                case '!re':
                    $i++;
                    break;
                case '!fatal':
                    $result = $response;
                    break 2;
                case '!trap':
                case '!done':
                    // Check for =ret=, .tag and any other following messages
                    for ($j = $key + 1; $j <= $lines; $j++) {
                        // If we have lines after current one
                        if (isset($response[$j])) {
                            $this->preParseResponse($response[$j], $result, $matches);
                        }
                    }
                    break 2;
                default:
                    $this->preParseResponse($value, $result, $matches, $i);
                    break;
            }
        }
        return $result;
    }


    /**
     * Response helper
     *
     * @param string     $value    Value which should be parsed
     * @param array      $result   Array with parsed response
     * @param null|array $matches  Matched words
     * @param string|int $iterator Type of iterations or number of item
     */
    private function preParseResponse(string $value, array &$result, ?array &$matches, $iterator = 'after'): void
    {
        $this->pregResponse($value, $matches);
        if (isset($matches[1][0], $matches[2][0])) {
            $result[$iterator][$matches[1][0]] = $matches[2][0];
        }
    }



    /**
     * Parse result from RouterOS by regular expression
     *
     * @param string     $value
     * @param null|array $matches
     */
    private function pregResponse(string $value, ?array &$matches): void
    {
        preg_match_all('/^[=|.](.*)=(.*)/', $value, $matches);
    }



    /* Old method

    public function parseResponse($response)
    {
        if (is_array($response)) {
            $PARSED      = array();
            $CURRENT     = null;
            $singlevalue = null;
            foreach ($response as $x) {
                if (in_array($x, array('!fatal', '!re', '!trap'))) {
                    if ($x == '!re') {
                        $CURRENT = &$PARSED[];
                    } else {
                        $CURRENT = &$PARSED[$x][];
                    }
                } elseif ($x != '!done') {
                    $MATCHES = array();
                    if (preg_match_all('/[^=]+/i', $x, $MATCHES)) {
                        if ($MATCHES[0][0] == 'ret') {
                            $singlevalue = $MATCHES[0][1];
                        }
                        $CURRENT[$MATCHES[0][0]] = (isset($MATCHES[0][1]) ? $MATCHES[0][1] : '');
                    }
                }
            }

            if (empty($PARSED) && !is_null($singlevalue)) {
                $PARSED = $singlevalue;
            }

            return $PARSED;
        } else {
            return array();
        }
    }

*/




    /**
     * Read data from Router OS
     * @param boolean $parse (optional) Parse the data? default: true
     * @return array                  Array with parsed or unparsed data
     */
    public function read($parse = true)
    {
        $RESPONSE     = array();
        $receiveddone = false;
        while (true) {
            // Read the first byte of input which gives us some or all of the length
            // of the remaining reply.
            $BYTE   = ord(fread($this->socket, 1));
            $LENGTH = 0;
            // If the first bit is set then we need to remove the first four bits, shift left 8
            // and then read another byte in.
            // We repeat this for the second and third bits.
            // If the fourth bit is set, we need to remove anything left in the first byte
            // and then read in yet another byte.
            if ($BYTE & 128) {
                if (($BYTE & 192) == 128) {
                    $LENGTH = (($BYTE & 63) << 8) + ord(fread($this->socket, 1));
                } else {
                    if (($BYTE & 224) == 192) {
                        $LENGTH = (($BYTE & 31) << 8) + ord(fread($this->socket, 1));
                        $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                    } else {
                        if (($BYTE & 240) == 224) {
                            $LENGTH = (($BYTE & 15) << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                        } else {
                            $LENGTH = ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                            $LENGTH = ($LENGTH << 8) + ord(fread($this->socket, 1));
                        }
                    }
                }
            } else {
                $LENGTH = $BYTE;
            }

            $_ = "";

            // If we have got more characters to read, read them in.
            if ($LENGTH > 0) {
                $_      = "";
                $retlen = 0;
                while ($retlen < $LENGTH) {
                    $toread = $LENGTH - $retlen;
                    $_ .= fread($this->socket, $toread);
                    $retlen = strlen($_);
                }
                $RESPONSE[] = $_;
                $this->debug('>>> [' . $retlen . '/' . $LENGTH . '] bytes read.');
            }

            // If we get a !done, make a note of it.
            if ($_ == "!done") {
                $receiveddone = true;
            }

            $STATUS = socket_get_status($this->socket);
            if ($LENGTH > 0) {
                $this->debug('>>> [' . $LENGTH . ', ' . $STATUS['unread_bytes'] . ']' . $_);
            }

            if ((!$this->connected && !$STATUS['unread_bytes']) || ($this->connected && !$STATUS['unread_bytes'] && $receiveddone)) {
                break;
            }
        }

        if ($parse) {
            $RESPONSE = $this->rosario($RESPONSE);
        }

        return $RESPONSE;
    }


    /**
     * Write (send) data to Router OS
     * If we set it to boolean true, the funcion will send the comand and finish
     * If we set it to boolean false, the funcion will send the comand and wait for next command
     * Default: true
     *
     * @param string  $command A string with the command to send
     * @param mixed   $param2  (optional) If we set an integer, the command will send this data as a "tag"
     * @return boolean                Return false if no command especified
     */
    public function write($command, $param2 = true)
    {
        if ($command) {
            $data = explode("\n", $command);
            foreach ($data as $com) {
                $com = trim($com);
                fwrite($this->socket, $this->encodeLength(strlen($com)) . $com);
                $this->debug('<<< [' . strlen($com) . '] ' . $com);
            }

            if (gettype($param2) == 'integer') {
                fwrite($this->socket, $this->encodeLength(strlen('.tag=' . $param2)) . '.tag=' . $param2 . chr(0));
                $this->debug('<<< [' . strlen('.tag=' . $param2) . '] .tag=' . $param2);
            } elseif (gettype($param2) == 'boolean') {
                fwrite($this->socket, ($param2 ? chr(0) : ''));
            }

            return true;
        } else {
            return false;
        }
    }


    /**
     * Write (send) data to Router OS
     * @param string  $com A string with the command to send
     * @param array   $arr (optional) An array with arguments or queries
     * @return array                  Array with parsed
     */
    public function comm($com, $arr = array())
    {
        $count = count($arr);
        $this->write($com, !$arr);
        $i = 0;
        if ($this->isIterable($arr)) {
            foreach ($arr as $k => $v) {
                switch ($k[0]) {
                    case "?":
                        $el = "$k=$v";
                        break;
                    case "~":
                        $el = "$k~$v";
                        break;
                    default:
                        $el = "=$k=$v";
                        break;
                }

                $last = ($i++ == $count - 1);
                $this->write($el, $last);
            }
        }

        return $this->read();
    }




    /**
     * Mikrotik filter operations
     *
     * @var array
     */
    public $filter_operations = ['|', '&'];




    /**
     * Mikrotik Menus
     *
     * @var array
     */

    public $mkt_menus = [
        'interface'  => 'Interface',
        'vlan'          => 'VLAN',
        'ip_address' => 'IP Address',
        'queue_type' => 'Queue Type',
        'queue'         => 'Queue',
        'dynamic_arp' => 'Dynamic ARP',
        'static_arp' => 'Static ARP',
        'ip_pool'     => 'IP Pool',
        'ppp_secret' => 'ppp secret',
        'ppp_profile' => 'ppp profile',
        'hotspot_user' => 'hotspot user',
        'hotspot_user_profile' => 'hotspot user profile',
        'radius' => 'Radius',
        'system_identity' => 'System Identity',
        'walled_garden_ip' => 'walled-garden ip',
        'hotspot_active' => 'Hotspot Active',
        'ip_hotspot_profile' => 'IP Hotspot Profile',
        'ip_firewall_nat' => 'IP Firewall NAT',
        'ip_hotspot' => 'IP Hotspot',
        'ip_dhcp_server' => 'IP DHCP Server',
        'pppoe_server_server' => 'pppoe-server server',
        'ip_firewall_filter' => 'IP Firewall Filter',
        'ipv6_pool' => 'ipv6 pool',
        'user' => 'user',
        'ppp_active' => 'ppp active',
    ];




    /**
     * Mikrotik Menus base command
     *
     * @var array
     */
    public $mkt_menu_base_command = [
        'interface' => '/interface/',
        'vlan' => '/interface/vlan/',
        'ip_address' => '/ip/address/',
        'queue_type' => '/queue/type/',
        'queue'    => '/queue/simple/',
        'dynamic_arp' => '/ip/arp/',
        'static_arp' => '/ip/arp/',
        'ip_pool' => '/ip/pool/',
        'ppp_secret' => '/ppp/secret/',
        'ppp_profile' => '/ppp/profile/',
        'hotspot_user' => '/ip/hotspot/user/',
        'hotspot_user_profile' => '/ip/hotspot/user/profile/',
        'radius' => '/radius/',
        'system_identity' => '/system/identity/',
        'walled_garden_ip' => '/ip/hotspot/walled-garden/ip/',
        'hotspot_active' => '/ip/hotspot/active/',
        'ip_hotspot_profile' => '/ip/hotspot/profile/',
        'ip_firewall_nat' => '/ip/firewall/nat/',
        'ip_hotspot' => '/ip/hotspot/',
        'ip_dhcp_server' => '/ip/dhcp-server/',
        'pppoe_server_server' => '/interface/pppoe-server/server/',
        'ip_firewall_filter' => '/ip/firewall/filter/',
        'ipv6_pool' => '/ipv6/pool/',
        'user' => '/user/',
        'ppp_active' => '/ppp/active/',
    ];





    /**
     * Default Mikrotik Menus Query
     *
     * @var array
     */
    public $mkt_menu_query = [
        'interface' => ["type" => 'ether'],
        'vlan' => [],
        'ip_address' => ["dynamic" => 'no'],
        'queue_type' => ["kind" => 'pcq', 'default' => 'no'],
        'queue'        => ["dynamic" => 'no'],
        'dynamic_arp' => ["dynamic" => 'yes'],
        'static_arp' => ["dynamic" => 'no'],
        'ip_pool' => [],
        'ppp_secret' => [],
        'ppp_profile' => [],
        'hotspot_user' => [],
        'hotspot_user_profile' => [],
        'radius' => [],
        'system_identity' => [],
        'walled_garden_ip' => [],
        'hotspot_active' => [],
        'ip_hotspot_profile' => [],
        'ip_firewall_nat' => [],
        'ip_hotspot' => ['disabled' => 'no'],
        'ip_dhcp_server' => [],
        'pppoe_server_server' => [],
        'ip_firewall_filter' => [],
        'ipv6_pool' => [],
        'user' => [],
        'ppp_active' => [],
    ];




    /**
     * Default Mikrotik Menus Query operation
     *
     * @var array
     */
    public $mkt_menu_query_operation = [
        'interface' => '',
        'vlan' => '',
        'ip_address' => '',
        'queue_type' => '&',
        'queue'        => '',
        'dynamic_arp' => '',
        'static_arp' => '',
        'ip_pool' => '',
        'ppp_secret' => '',
        'ppp_profile' => '',
        'hotspot_user' => '',
        'hotspot_user_profile' => '',
        'radius' => '',
        'system_identity' => '',
        'walled_garden_ip' => '',
        'hotspot_active' => '',
        'ip_hotspot_profile' => '',
        'ip_firewall_nat' => '',
        'ip_hotspot' => '',
        'ip_dhcp_server' => '',
        'pppoe_server_server' => '',
        'ip_firewall_filter' => '',
        'ipv6_pool' => '',
        'user' => '',
        'ppp_active' => '',
    ];





    /**
     * Mikrotik Menu property list
     *
     * @var array
     */
    public $mkt_menu_property_list = [
        "interface"  => ['name', 'default-name', 'type', 'mac-address', 'comment'],
        "vlan"       => ['name', 'interface', 'vlan-id', 'mac-address', 'comment'],
        'ip_address' => ['address', 'interface', 'network', 'comment'],
        "queue_type" => ['name', 'kind', 'pcq-rate', 'pcq-classifier'],
        "queue"         => ['name', 'target', 'queue', 'max-limit', 'comment'],
        "dynamic_arp" => ['address', 'interface', 'mac-address', 'comment'],
        "static_arp" => ['address', 'interface', 'mac-address', 'comment'],
        "ip_pool"     => ['name', 'ranges'],
        "ppp_secret" => ['name', 'password', 'remote-address', 'profile', 'comment', 'disabled'],
        "ppp_profile" => ['name', 'local-address', 'remote-address', 'remote-ipv6-prefix-pool'],
        'hotspot_user' => ['name', 'password', 'profile', 'comment', 'disabled'],
        'hotspot_user_profile' => ['name', 'address-pool'],
        'radius' => ['accounting-port', 'address', 'authentication-port', 'secret', 'service'],
        'system_identity' => ['name'],
        'walled_garden_ip' => ['action', 'comment', 'dst-address'],
        'hotspot_active' => ['user', 'address', 'mac-address'],
        'ip_hotspot_profile' => ['name', 'hotspot-address', 'dns-name', 'login-by', 'http-cookie-lifetime', 'split-user-domain', 'use-radius', 'radius-accounting', 'radius-interim-update', 'nas-port-type'],
        'ip_firewall_nat' => ['chain', 'action', 'comment'],
        'ip_hotspot' => ['name', 'profile', 'interface', 'address-pool'],
        'ip_dhcp_server' => ['name', 'interface', 'lease-time', 'address-pool', 'lease-script'],
        'pppoe_server_server' => ['authentication', 'one-session-per-host', 'default-profile'],
        'ip_firewall_filter' => ['chain', 'protocol', 'action', 'comment'],
        'ipv6_pool' => ['name', 'prefix', 'prefix-length'],
        'user' => ['name', 'group'],
        'ppp_active' => ['name', 'caller-id', 'address', 'uptime'],
    ];




    /**
     * Check if the menu has been implemented
     *
     * @param string $menu
     * @return boolean
     *
     */
    public function in_menu(string $menu)
    {
        $menus = array_keys($this->mkt_menus);

        return in_array($menu, $menus);
    }



    /**
     * Get Mikrotik Rows
     *
     * @access public
     * @param string $menu
     * @param associative array $query (optional)
     * @param string $query_operation (optional)
     *
     * @return array
     */

    public function getMktRows($menu, $query = [], $query_operation = '')
    {
        // check menu entry
        if (!$this->in_menu($menu)) return [];

        //command
        $command = $this->mkt_menu_base_command[$menu] . 'print';

        //property_list
        $property_list = $this->mkt_menu_property_list[$menu];

        //query & query operation
        if (count($query) == false) {

            $query = $this->mkt_menu_query[$menu];

            $query_operation = $this->mkt_menu_query_operation[$menu];
        }


        if ($this->connect($this->host, $this->user, $this->pass)) {

            $this->write($command, false);

            //set filter
            if (count($query)) {

                foreach ($query as $property_name => $property_value) {

                    $query_word = '?';

                    if (strlen($property_value)) {

                        $query_word .= $property_name . '=' . $property_value;
                    } else {

                        $query_word .= $property_name;
                    }

                    //write query
                    $this->write($query_word, false);
                }
            }

            //filter operation
            if (strlen($query_operation)) {

                //write query
                $this->write('?#' . $query_operation, false);
            }

            //property_list
            $proplist = '=.proplist=.id';

            if (count($property_list)) {

                $proplist .= ',' . implode(',', $property_list);
            }

            $this->write($proplist);

            //read
            $array = $this->read();

            return $array;
        } else {

            return [];
        }
    }





    /**
     * Add mikrotik row
     *
     * @access public
     * @param string $menu
     * @param two dimensional array $rows
     *
     */

    public function addMktRows($menu, $rows = [])
    {
        // check menu entry
        if (!$this->in_menu($menu)) return 0;

        //command
        $command = $this->mkt_menu_base_command[$menu] . 'add';

        //rows must be an array
        if (!is_array($rows)) return 0;

        // must have data
        if (count($rows) == 0) return 0;

        if ($this->connect($this->host, $this->user, $this->pass)) {

            while ($row = array_shift($rows)) {

                if ($this->connect($this->host, $this->user, $this->pass)) {

                    $duplicate = $this->getMktRows($menu, $row, '');

                    if (count($duplicate)) {

                        continue;
                    }

                    $this->comm($command, $row);
                }
            }

            return 1;
        } else {

            return 0;
        }
    }






    /**
     * Remove mikrotik rows
     *
     * @access public
     * @param string $menu
     * @param array $rows two dimensional
     *
     */
    public function removeMktRows(string $menu,  array $rows)
    {
        // check menu entry
        if (!$this->in_menu($menu)) return 0;

        //command
        $command = $this->mkt_menu_base_command[$menu] . 'remove';

        //if no row nothing to process
        if (count($rows) == 0) return 0;

        if ($this->connect($this->host, $this->user, $this->pass)) {

            while ($row = array_shift($rows)) {
                if ($this->connect($this->host, $this->user, $this->pass)) {
                    if (array_key_exists(".id", $row)) {
                        $this->write($command, false);
                        $this->write("=.id=" . $row[".id"]);
                        $this->read();
                    }
                }
            }

            return 1;
        } else {

            return 0;
        }
    }


    /**
     * Remove mikrotik rows
     *
     * @access public
     * @param string $menu
     * @param array $rows two dimensional
     *
     */
    public function unsetMktRows(string $menu,  array $rows, string $value_name)
    {
        // check menu entry
        if (!$this->in_menu($menu)) return 0;

        //command
        $command = $this->mkt_menu_base_command[$menu] . 'unset';

        //if no row nothing to process
        if (count($rows) == 0) return 0;

        if ($this->connect($this->host, $this->user, $this->pass)) {

            while ($row = array_shift($rows)) {
                if ($this->connect($this->host, $this->user, $this->pass)) {
                    if (array_key_exists(".id", $row)) {
                        $this->write($command, false);
                        $this->write("=.id=" . $row[".id"], false);
                        $this->write("=value-name=" . $value_name);
                        $this->read();
                    }
                }
            }

            return 1;
        } else {

            return 0;
        }
    }






    /**
     * Edit mikrotik row
     * @access public
     * @param string $menu
     * @param  array $row
     * @param array $new_data
     */
    public function editMktRow($menu, $row = [], $new_data = [])
    {
        // check menu entry
        if (!$this->in_menu($menu)) return 0;

        //check row
        if (count($row) == 0) {
            return [];
        }

        if (array_key_exists(".id", $row) == false) {
            return [];
        }

        //command
        $command = $this->mkt_menu_base_command[$menu] . 'set';

        // set id to edit
        $new_data[".id"] = $row[".id"];

        if ($this->connect($this->host, $this->user, $this->pass)) {

            return $this->comm($command, $new_data);
        } else {

            return [];
        }
    }


    /**
     * TTY wirte to Mikrotik
     * @access public
     * @param string $menu
     * @param  array $row
     * @param array $new_data
     */

    public function ttyWirte($command, $row = [])
    {

        //row must be an array
        if (!is_array($row)) return 0;

        // must have data
        if (count($row) == 0) return 0;

        if ($this->connect($this->host, $this->user, $this->pass)) {

            return $this->comm($command, $row);
        } else {

            return [];
        }
    }



    /**
     * Standard destructor
     *
     * @return void
     */
    public function __destruct()
    {
        $this->disconnect();
    }
}
