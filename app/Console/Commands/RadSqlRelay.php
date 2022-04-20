<?php

namespace App\Console\Commands;

use App\Models\radacct;
use App\Models\pgsql_customer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RadSqlRelay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rad:sql_relay {debug=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SQL Log to SQL Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $debug = $this->argument('debug');

        $timestamp = Carbon::now()->timestamp;

        // db connection
        $password = config('database.connections.central.password');

        // Start Accounting-Request
        if (file_exists('/var/log/freeradius/acct_start_raw.sql')) {

            $acct_start_file = '/var/log/freeradius/acct_start_' . $timestamp . '.sql';

            // copy and truncate accounting start log
            shell_exec("cp -f /var/log/freeradius/acct_start_raw.sql $acct_start_file");
            shell_exec('echo -n "" > /var/log/freeradius/acct_start_raw.sql');

            // start processing
            shell_exec("mysql --user=ispbillingone --password=$password --database=ispbillingone  < $acct_start_file");
            shell_exec("rm $acct_start_file");
        }

        // Interim-Update Accounting-Request
        if (file_exists('/var/log/freeradius/acct_interim_update_raw.sql')) {

            $interim_update_file = '/var/log/freeradius/intrim_update_' . $timestamp . '.sql';

            // copy and truncate acct_interim_update log
            shell_exec("cp -f /var/log/freeradius/acct_interim_update_raw.sql $interim_update_file");
            shell_exec('echo -n "" > /var/log/freeradius/acct_interim_update_raw.sql');

            // compress request
            $lines = file($interim_update_file);
            $trimed_lines = [];
            foreach ($lines as $line) {
                $array = explode('WHERE', $line);
                $array_2 = explode('AND', $array[1]);
                $array_3 = explode('=', $array_2[0]);
                $username = trim($array_3[1]);
                $trimed_lines[$username] = $line;
            }

            // process trimed_lines
            foreach ($trimed_lines as $username => $trimed_line) {

                $username = Str::replace("'", "", $username);

                $update_string = Str::between($trimed_line, 'SET', 'WHERE');

                $update_statement_array = explode(',', $update_string);

                $updates = [];

                foreach ($update_statement_array as $update_statement) {
                    $key_value_array =  explode("=", $update_statement);
                    if (count($key_value_array) == 2) {
                        $updates[trim($key_value_array['0'])] = trim($key_value_array['1']);
                    }
                }

                $keys_found = array_keys($updates);

                $expected_keys = [
                    'acctsessionid',
                    'acctuniqueid',
                    'nasipaddress',
                    'callingstationid',
                    'framedipaddress',
                    'nasidentifier',
                    'acctupdatetime',
                    'acctsessiontime',
                    'acctinputoctets',
                    'acctoutputoctets'
                ];

                $key_diff = array_diff($expected_keys, $keys_found);

                if (count($key_diff)) {
                    if ($debug) {
                        $this->info('Not Updating: ' . $username);
                        print_r($key_diff);
                    }
                    continue;
                }

                $sql_update = [
                    'acctsessionid' => Str::replace("'", "", $updates['acctsessionid']),
                    'acctuniqueid' => Str::replace("'", "", $updates['acctuniqueid']),
                    'nasipaddress' => Str::replace("'", "", $updates['nasipaddress']),
                    'callingstationid' => Str::replace("'", "", $updates['callingstationid']),
                    'framedipaddress' => Str::replace("'", "", $updates['framedipaddress']),
                    'nasidentifier' => Str::replace("'", "", $updates['nasidentifier']),
                    'acctupdatetime' => DB::raw($updates['acctupdatetime']),
                    'acctsessiontime' => $updates['acctsessiontime'],
                    'acctinputoctets' => DB::raw(Str::replace("'", "", $updates['acctinputoctets'])),
                    'acctoutputoctets' => DB::raw(Str::replace("'", "", $updates['acctoutputoctets'])),
                ];

                $affected = radacct::where('username', $username)
                    ->whereNull('acctstoptime')
                    ->update([
                        'nasidentifier' => $sql_update['nasidentifier'],
                        'acctupdatetime' => $sql_update['acctupdatetime'],
                        'acctsessiontime' => $sql_update['acctsessiontime'],
                        'acctinputoctets' => $sql_update['acctinputoctets'],
                        'acctoutputoctets' => $sql_update['acctoutputoctets'],
                    ]);

                if ($affected == 0) {

                    $customer = pgsql_customer::where('username', $username)->first();

                    if ($customer) {
                        $radacct = new radacct();
                        $radacct->mgid = $customer->mgid;
                        $radacct->operator_id = $customer->operator_id;
                        $radacct->acctsessionid = $sql_update['acctsessionid'];
                        $radacct->acctuniqueid = $sql_update['acctuniqueid'];
                        $radacct->username = $customer->username;
                        $radacct->nasipaddress = $sql_update['nasipaddress'];
                        $radacct->callingstationid = $sql_update['callingstationid'];
                        $radacct->acctterminatecause = "null";
                        $radacct->framedipaddress = $sql_update['framedipaddress'];
                        $radacct->nasidentifier = $sql_update['nasidentifier'];
                        $radacct->acctstarttime = Carbon::now();
                        $radacct->acctupdatetime = Carbon::now();
                        $radacct->acctsessiontime = $sql_update['acctsessiontime'];
                        $radacct->acctinputoctets = $sql_update['acctinputoctets'];
                        $radacct->acctoutputoctets = $sql_update['acctoutputoctets'];
                        $radacct->save();

                        if ($debug) {
                            $this->info('New radacct row created. Customer ID: ' . $customer->id . " mgid : " . $customer->mgid);
                        }
                    }
                }
            }

            shell_exec("rm $interim_update_file");
        }

        // Stop Accounting-Request
        if (file_exists('/var/log/freeradius/acct_stop_raw.sql')) {

            $acct_stop_file = '/var/log/freeradius/acct_stop_' . $timestamp . '.sql';

            // copy and truncate accounting Stop log
            shell_exec("cp -f /var/log/freeradius/acct_stop_raw.sql $acct_stop_file");
            shell_exec('echo -n "" > /var/log/freeradius/acct_stop_raw.sql');

            // start processing
            shell_exec("mysql --user=ispbillingone --password=$password --database=ispbillingone  < $acct_stop_file");
            shell_exec("rm $acct_stop_file");
        }

        return 0;
    }
}
