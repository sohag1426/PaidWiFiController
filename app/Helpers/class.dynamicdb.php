<?php

/**
 * Version: 3.0
 * Last UPDATE: 13-09-2020
 * DESIGNED FOR INSERT, SELECT, UPDATE, DELETE DBMS Operations and other core functions.
 * DESIGNED BY MD. SOHAG HOSEN
 * sohag1426@gmail.com
 *
 * @package default
 */

namespace Sohag;

use \PDO;

class DynamicDB
{

    /**
     * Location of overloading data
     */
    private $data = array();


    /**
     * Property overloading || Dynamic property
     * Run when writing data to inaccessible (protected or private) or non-existing properties.
     *
     * @access public
     * @param string  $name
     * @param mixed   $value
     */
    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }


    /**
     * Property overloading || Dynamic property
     * Run when reading data from inaccessible (protected or private) or non-existing properties.
     *
     * @access public
     * @param string  $name
     * @return mixed
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }


    /**
     * Property overloading || Dynamic property
     * Triggered by calling isset() or empty() on inaccessible (protected or private) or non-existing properties.
     *
     * @access public
     * @param string  $name
     * @return bool
     */
    public function __isset(string $name)
    {
        return isset($this->data[$name]);
    }


    /**
     * Property overloading || Dynamic property
     * Invoked when unset() is used on inaccessible (protected or private) or non-existing properties.
     *
     * @access public
     * @param string  $name
     */
    public function __unset(string $name)
    {
        unset($this->data[$name]);
    }


    ########     Dynamic DB Starts Here    #####

    /**
     * Location for all database connection configuration.
     */

    public $connection_configs;


    /**
     * Set Default Database Connection configuration.
     */
    public function __construct()
    {

        $configs = [
            "default" => [
                "name" => "default",
                "host" => config('seederdb.host'),
                "database" => config('seederdb.database'),
                "user" => config('seederdb.username'),
                "password" => config('seederdb.password'),
                "port" => config('seederdb.port'),
                "char" => "utf8",
            ],

            "infodb" => [
                "name" => "infodb",
                "host" => config('seederdb.host'),
                "database" => "information_schema",
                "user" => config('seederdb.username'),
                "password" => config('seederdb.password'),
                "port" => config('seederdb.port'),
                "char" => "utf8",
            ],

        ];

        $this->connection_configs = $configs;
    }


    /**
     * Add New Database Connection Configuration
     */

    public function addConnectionConfig(string $name, array $config)
    {
        $connections = $this->connection_configs;

        $connections[$name] = $config;

        $this->connection_configs = $connections;
    }


    /**
     *
     * @param string  $name (optional)
     * @return array
     */
    public function getConnectionConfig(string $name = ""): array
    {
        $connections = $this->connection_configs;

        if (array_key_exists($name, $connections)) {
            return $connections[$name];
        }

        return $connections["default"];
    }


    /**
     * Location for all PDO.
     */
    public $pdos = array();


    /**
     * Return the active PDO connection ($pdo).
     *
     * @param string  $connection_name (optional)
     * @return object
     */
    public function connect(string $connection_name = ""): PDO
    {
        //get connection info
        $config = $this->getConnectionConfig($connection_name);

        //return the existing connection
        if (array_key_exists($config["name"], $this->pdos)) {

            if ($this->pdos[$config["name"]] !== null) {

                return $this->pdos[$config["name"]];
            }
        }

        //save new connection
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'] . ';port=' . $config['port'] . ';charset=' . $config['char'];
        $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true);
        $pdo = new PDO($dsn, $config['user'], $config['password'], $opt);
        $this->pdos[$config["name"]] = $pdo;

        //return new connection
        return $pdo;
    }



    /**
     * getQueryStatement
     *
     * @package default
     * @param string  $table
     * @param string  $command
     * @param array   $columns
     * @param string  $whereStatement (optional)
     * @return string
     */
    public function getQueryStatement(string $table, string $command, array $columns, string $whereStatement = ''): string
    {
        //command
        $command = strtoupper(trim($command));
        //filterStatement
        if (strlen($whereStatement)) {
            if (substr(strtoupper(trim($whereStatement)), 0, 5) !== 'WHERE') {
                $filterStatement = 'WHERE ' . $whereStatement;
            } else {
                $filterStatement = $whereStatement;
            }
        }
        //setStatement
        if ($command == 'INSERT' || $command == 'UPDATE') {
            $setArray = [];
            foreach ($columns as $column) {
                $setArray[] = $column . '=:' . $column;
            }
            $setStatement = implode(', ', $setArray);
        }
        //insert query
        if ($command == 'INSERT') {
            $query = $command . ' INTO ' . $table . ' SET ' . $setStatement;
        }
        //select query
        if ($command == 'SELECT') {
            $select = implode(', ', $columns);
            if (strlen($whereStatement)) {
                $query = $command . ' ' . $select . ' FROM ' . $table . ' ' . $filterStatement;
            } else {
                $query = $command . ' ' . $select . ' FROM ' . $table;
            }
        }
        //update query
        if ($command == 'UPDATE') {
            $query = $command . ' ' . $table . ' SET ' . $setStatement . ' ' . $filterStatement;
        }
        //delete query
        if ($command == 'DELETE') {
            $query = $command . ' FROM ' . $table . ' ' . $filterStatement;
        }

        return $query;
    }



    /**
     *
     * @param string  $command
     * @param array   $setData
     * @param array   $wherePlaceholderValues
     * @return array
     */
    public function getPlaceholderValues(string $command, array $setData, array $wherePlaceholderValues): array
    {
        //command
        $command = strtoupper(trim($command));
        //setPlaceholderValues
        $setPlaceholderValues = [];
        if (count($setData)) {
            foreach ($setData as $key => $value) {
                $setPlaceholderValues[':' . $key] = $value;
            }
        }
        //placeholderValues
        if ($command == 'INSERT') {
            $placeholderValues = $setPlaceholderValues;
        }
        if ($command == 'UPDATE') {
            $placeholderValues = array_merge($setPlaceholderValues, $wherePlaceholderValues);
        }
        if ($command == 'SELECT' || $command == 'DELETE') {
            $placeholderValues = $wherePlaceholderValues;
        }

        return $placeholderValues;
    }



    /**
     *
     * @param string  $command
     * @param string  $queryStatement
     * @param array   $placeholderValues
     * @return array
     */
    public function runQuery(string $command, string $queryStatement, array $placeholderValues, string $connection_name = '')
    {
        $result = 0;
        //command
        $command = strtoupper(trim($command));
        //get_connection
        $pdo = $this->connect($connection_name);
        //prepare
        $PDOStatement = $pdo->prepare($queryStatement);

        if (is_object($PDOStatement)) {

            //bindValue
            if (count($placeholderValues) > 0) {
                foreach ($placeholderValues as $k => $v) {
                    if (!strlen($v)) {
                        $PDOStatement->bindValue($k, $v, PDO::PARAM_NULL);
                    } else {
                        $PDOStatement->bindValue($k, $v);
                    }
                }
            }

            //execute
            $PDOStatement->execute();

            //result
            if ($command == 'INSERT') {
                $result = $pdo->lastInsertId();
            }

            if ($command == 'SELECT') {
                $result = $PDOStatement->fetchAll();
            }

            if ($command == 'DELETE' || $command == 'UPDATE') {
                $result = $PDOStatement->rowCount();
            }
        }

        return $result;
    }



    /**
     * get information of a table
     *
     * @access public
     * @param string  $table
     * @return array
     */
    public function getTableInfo(string $table)
    {
        if (strlen($table)) {
            //get table_schema
            $connection = $this->getConnectionConfig();
            $table_schema = $connection['database'];
            //queryStatement
            $whereStatement = 'WHERE TABLE_SCHEMA=:TABLE_SCHEMA AND TABLE_NAME=:TABLE_NAME';
            $wherePlaceholderValues = [":TABLE_SCHEMA" => $table_schema, ":TABLE_NAME" => $table];
            $columns = ['COLUMN_NAME', 'IS_NULLABLE', 'DATA_TYPE', 'CHARACTER_MAXIMUM_LENGTH', 'COLUMN_COMMENT', 'COLUMN_DEFAULT'];
            $queryStatement = $this->getQueryStatement('COLUMNS', 'SELECT', $columns, $whereStatement);
            //execute query
            $pdo = $this->connect('infodb');;
            $PDOStatement = $pdo->prepare($queryStatement);
            $PDOStatement->execute((array)$wherePlaceholderValues);
            $rows = $PDOStatement->fetchAll();
            $info = [];
            while ($row = array_shift($rows)) {
                if ($row['COLUMN_NAME'] != 'id') {
                    $data = [];
                    $data = ["is_nullable" => $row['IS_NULLABLE'], "data_type" => $row['DATA_TYPE'], "max_length" => $row['CHARACTER_MAXIMUM_LENGTH'], "comment" => $row['COLUMN_COMMENT'], "default_value" => $row['COLUMN_DEFAULT']];
                    $info[$row['COLUMN_NAME']] = $data;
                }
            }
            return $info;
        } else {
            return false;
        }
    }




    /**
     * get column names of a table
     *
     * @access public
     * @param string  $table (optional)
     * @return array
     */
    public function getColumnNames(string $table)
    {
        if (strlen($table)) {
            $info = $this->getTableInfo($table);
            return array_keys($info);
        } else {
            return false;
        }
    }



    /**
     *
     * @param string  $table
     * @param array   $where (associative array || array of array)
     * @return object
     */
    public function processWhere(string $table, array $where)
    {
        $filter = new \stdClass;
        $filter->statement = '';
        $filter->placeholderValues = [];

        if (count($where) == 0) {
            return $filter;
        }

        //unset empty
        foreach ($where as $key => $value) {
            if (is_array($value)) {
                if (count($value)) {
                    continue;
                } else {
                    unset($where[$key]);
                }
            } else {
                if (strlen($value)) {
                    continue;
                } else {
                    unset($where[$key]);
                }
            }
        }

        //get table columns
        $columns = $this->getColumnNames($table);
        //include id excluded in getTableInfo
        if (!in_array('id', $columns)) {
            $columns[] = 'id';
        }

        //ini_set
        $statement = 'WHERE ';
        $placeholderValues = [];
        $firstIteration = 1;

        foreach ($where as $key => $value) {
            if (is_array($value) && count($value) == 3) {
                //check column in table
                if (!in_array($value[0], $columns)) {
                    continue;
                }
                $operator = strtoupper($value[1]);

                switch ($operator) {
                    case '>':
                    case '>=':
                    case '<':
                    case '<>':
                    case '!=':
                    case '<=':
                    case '=':
                        if ($firstIteration) {
                            $statement .= $value[0] . $operator . ':where_' . $value[0];
                            $placeholderValues[':where_' . $value[0]] = $value[2];
                            $firstIteration = 0;
                        } else {
                            $statement .= ' AND ' . $value[0] . $operator . ':where_' . $value[0];
                            $placeholderValues[':where_' . $value[0]] = $value[2];
                        }
                        break;
                    case 'BETWEEN':
                    case 'NOT BETWEEN':
                        if (count($value[2]) == 2) {
                            if ($firstIteration) {
                                $statement .= $value[0] . ' ' . $operator . ' ' . ':from_' . $value[0] . ' AND ' . ':to_' . $value[0];
                                $placeholderValues[':from_' . $value[0]] = $value[2][0];
                                $placeholderValues[':to_' . $value[0]] = $value[2][1];
                                $firstIteration = 0;
                            } else {
                                $statement .= ' AND ' . $value[0] . ' ' . $operator . ' ' . ':from_' . $value[0] . ' AND ' . ':to_' . $value[0];
                                $placeholderValues[':from_' . $value[0]] = $value[2][0];
                                $placeholderValues[':to_' . $value[0]] = $value[2][1];
                            }
                        } else {
                            $this->print_errors(['Invalid $where argument']);
                            return 0;
                        }
                        break;
                    case 'IN':
                    case 'NOT IN':
                        if (!is_array($value[2])) {
                            $this->print_errors(['Invalid $where argument']);
                            return 0;
                        }
                        if ($firstIteration) {
                            $statement .= $value[0] . ' ' . $operator . ' ' . ':where_' . $value[0];
                            $placeholderValues[':where_' . $value[0]] = '("' . implode('","', $value[2]) . '")';
                            $firstIteration = 0;
                        } else {
                            $statement .= ' AND ' . $value[0] . ' ' . $operator . ' ' . ':where_' . $value[0];
                            $placeholderValues[':where_' . $value[0]] = '("' . implode('","', $value[2]) . '")';
                        }
                        break;
                    case 'IS':
                    case 'IS NOT':
                    case 'LIKE':
                    case 'NOT LIKE':
                        if ($firstIteration) {
                            $statement .= $value[0] . ' ' . $operator . ' ' . ':where_' . $value[0];
                            $placeholderValues[':where_' . $value[0]] = $value[2];
                            $firstIteration = 0;
                        } else {
                            $statement .= ' AND ' . $value[0] . ' ' . $operator . ' ' . ':where_' . $value[0];
                            $placeholderValues[':where_' . $value[0]] = $value[2];
                        }
                        break;
                    default:
                        $this->print_errors(['operator in $where argument not found']);
                        return 0;
                }
            } else {
                //check column in table
                if (!in_array($key, $columns)) {
                    continue;
                }
                if ($firstIteration) {
                    $statement .= $key . '=:where_' . $key;
                    $placeholderValues[':where_' . $key] = $value;
                    $firstIteration = 0;
                } else {
                    $statement .= ' AND ' . $key . '=:where_' . $key;
                    $placeholderValues[':where_' . $key] = $value;
                }
            }
        }
        //endforeach
        $filter->statement = $statement;
        $filter->placeholderValues = $placeholderValues;
        return $filter;
    }




    /**
     * Get Table Rows
     *
     * @param string  $table
     * @param array   $where (optional)
     * @return array
     */
    public function getRows(string $table, array $where = [], array $order_by = [], string $connection_name = '')
    {
        $filter = $this->processWhere($table, $where);
        if (count($where)) {
            $queryStatement = 'SELECT * FROM `' . $table . '` ' . $filter->statement;
        } else {
            $queryStatement = 'SELECT * FROM `' . $table . '`';
        }
        //order_by
        if (count($order_by)) {
            $order = [];
            foreach ($order_by as $key => $value) {
                $order[] = $key . ' ' . $value;
            }
            $queryStatement .= ' ORDER BY ' . implode(',', $order);
        }
        $pdo = $this->connect($connection_name);
        $statement = $pdo->prepare($queryStatement);
        if (count($filter->placeholderValues) > 0) {
            $statement->execute($filter->placeholderValues);
        } else {
            $statement->execute();
        }
        return $statement->fetchAll();
    }




    /**
     * Get Table Row
     *
     * @param string  $table (optional)
     * @param array   $where
     * @return array
     */
    public function getRow(string $table, array $where, string $connection_name = '')
    {
        $filter = $this->processWhere($table, $where);
        $queryStatement = 'SELECT * FROM `' . $table . '` ' . $filter->statement;
        $pdo = $this->connect($connection_name);
        $statement = $pdo->prepare($queryStatement);
        $statement->execute($filter->placeholderValues);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }




    /**
     *
     * @param array   $rows          (optional)
     * @param string  $sorted_column (optional)
     * @param int     $asc           (optional)
     * @return array
     */
    public function sortRows($rows = [], $sorted_column = '', $asc = 1)
    {
        $sorted_rows = [];
        if (count($rows)) {
            while ($row = array_shift($rows)) {
                $sorted_rows[$row[$sorted_column]] = $row;
            }
            if ($asc) {
                ksort($sorted_rows);
            } else {
                krsort($sorted_rows);
            }
        }
        return $sorted_rows;
    }




    /**
     *
     * @access public
     * @param string  $table
     * @param array   $where
     * @return int
     */
    public function countRow(string $table, array $where, string $connection_name = '')
    {
        $filter = $this->processWhere($table, $where);
        if (count($where)) {
            $queryStatement = 'SELECT COUNT(*) FROM `' . $table . '` ' . $filter->statement;
        } else {
            $queryStatement = 'SELECT COUNT(*) FROM `' . $table . '`';
        }
        $pdo = $this->connect($connection_name);
        $statement = $pdo->prepare($queryStatement);
        if (count($filter->placeholderValues)) {
            $statement->execute($filter->placeholderValues);
        } else {
            $statement->execute();
        }
        $fetch = $statement->fetch(PDO::FETCH_NUM);
        return $fetch['0'];
    }



    /**
     *
     * @access public
     * @param string  $column
     * @param string  $table
     * @param array   $where
     * @return int
     */
    public function sumColumn(string $column, string $table, array $where, string $connection_name = '')
    {
        $filter = $this->processWhere($table, $where);
        if (count($where)) {
            $queryStatement = 'SELECT SUM(`' . $column . '`) FROM `' . $table . '` ' . $filter->statement;
        } else {
            $queryStatement = 'SELECT SUM(`' . $column . '`) FROM `' . $table . '`';
        }
        $pdo = $this->connect($connection_name);
        $statement = $pdo->prepare($queryStatement);
        if (count($filter->placeholderValues)) {
            $statement->execute($filter->placeholderValues);
        } else {
            $statement->execute();
        }
        $fetch = $statement->fetch(PDO::FETCH_NUM);
        return $fetch['0'];
    }




    /**
     *
     * @access public
     * @param string  $table
     * @param array   $columns
     * @param array   $where
     * @return array
     */
    public function select(string $table, array $columns, array $where)
    {
        $filter = $this->processWhere($table, $where);
        $queryStatement = $this->getQueryStatement($table, 'SELECT', $columns, $filter->statement);
        return $this->runQuery('SELECT', $queryStatement,  $filter->placeholderValues);
    }


    /**
     *
     * @access public
     * @param string  $table
     * @param array   $where
     * @return array of id
     */
    public function getKeys(string $table, array $where)
    {
        $filter = $this->processWhere($table, $where);
        $queryStatement = $this->getQueryStatement($table, 'SELECT', ['id'], $filter->statement);
        $rows = $this->runQuery('SELECT', $queryStatement,  $filter->placeholderValues);
        $keys = [];
        while ($row = array_shift($rows)) {
            $keys = $row['id'];
        }
        return $keys;
    }




    /**
     *
     * @access public
     * @param mixed   $data
     * @return mixed
     */
    public function testInput($data)
    {
        if (is_array($data) == false) {
            $data = trim($data);
            $data = stripslashes($data);
            //$data = htmlspecialchars($data);
            return $data;
        } else {
            return $data;
        }
    }



    /**
     *
     * @access public
     * @param string $table
     * @param array $post_data
     * @return mixed
     */
    public function checkPostData(string $table, array $post_data)
    {
        $errors = [];

        //check function input
        if (!strlen($table)) $errors[] = 'TABLE name is required';
        if (!is_array($post_data)) $errors[] = 'POST Data is not an array';
        if (count($errors)) {
            $this->print_errors($errors);
            return 0;
        }

        //get table info
        $info = $this->getTableInfo($table);
        $fields = array_keys($info);


        //unset garbage
        foreach ($post_data as $key => $value) {
            if (in_array($key, $fields)) {
                continue;
            } else {
                unset($post_data[$key]);
            }
        }


        //testInput & format value
        foreach ($post_data as $key => $value) {
            $post_data[$key] = $this->testInput($value);
            $type = $info[$key]['data_type'];
            switch ($type) {
                case 'date':
                    $post_data[$key] = date_format(date_create($value), config('app.date_format'));
                    break;
                case 'datetime':
                    $post_data[$key] = date_format(date_create($value), config('app.date_time_format'));
                    break;
                case 'time':
                    $post_data[$key] = date_format(date_create($value), config('app.time_format'));
                    break;
            }
        }


        //check varchar length
        foreach ($post_data as $key => $value) {
            if (($info[$key]['data_type']) == 'varchar') {
                if (strlen($value) > ($info[$key]['max_length'])) {
                    $errors[] = 'Error: value of ' . $key . ' in table ' . $table . ' exceeds maximum length';
                }
            }
        }


        //check is_nullable
        foreach ($post_data as $key => $value) {
            if (($info[$key]['is_nullable'] == 'NO') && !strlen($post_data[$key])) {
                $errors[] = $key . ' in table ' . $table . ' can not be empty';
            }
        }


        //print error
        if (count($errors)) {
            $this->print_errors($errors);
            return 0;
        }

        return $post_data;
    }



    /**
     *
     * @param string  $table
     * @param array   $post_data    (optional)
     * @param array   $session_data (optional)
     * @param boolen  $log          (optional)
     * @return int
     */
    public function insert(string $table, array $post_data, array $session_data = [], string $connection_name = '')
    {
        $errors = [];
        //session_data
        if (count($session_data) == 0) {
            $session_data['id'] = 0;
            $session_data['category'] = 'system';
        }

        //Add common Missing value to $post_data
        $post_data['year'] = isset($post_data['year']) ? $post_data['year'] : date(config('app.year_format'));
        $post_data['month'] = isset($post_data['month']) ? $post_data['month'] : date(config('app.month_format'));
        $post_data['week'] = isset($post_data['week']) ? $post_data['week'] : date(config('app.week_format'));
        $post_data['creation_date'] = date(config('app.month_format'));
        $post_data['creation_time'] = date(config('app.time_format'));
        $post_data['creation_by'] = $session_data['category'];
        $post_data['creator_id'] = $session_data['id'];

        //check post data
        $post_data = $this->checkPostData($table, $post_data);
        if (!is_array($post_data)) {
            $errors[] = 'The request cannot be processed';
            $this->print_errors($errors);
            return 0;
        }

        $columns = array_keys($post_data);
        $queryStatement = $this->getQueryStatement($table, 'INSERT', $columns, '');
        $placeholderValues = $this->getPlaceholderValues('INSERT', $post_data, []);
        //nothing to add
        if (count($placeholderValues) == 0) return 0;
        $id = $this->runQuery('INSERT', $queryStatement, $placeholderValues, $connection_name);
        return $id;
    }


    /**
     *
     * @param string  $table
     * @param array   $post_data
     * @param array   $where
     * @param array   $session_data (optional)
     * @param bool    $log          (optional)
     * @return mixed
     */
    public function saveEdit(string $table, array $post_data, array $where, array $session_data = [], string $connection_name = '')
    {
        $errors = [];

        //session_data
        if (count($session_data) == 0) {
            $session_data['id'] = 0;
            $session_data['category'] = 'system';
        }

        //Add common Missing value to $post_data
        $post_data['update_date'] = date(config('app.date_format'));
        $post_data['update_time'] = date(config('app.time_format'));
        $post_data['update_by'] = $session_data['category'];
        $post_data['updater_id'] = $session_data['id'];

        //check post data
        $post_data = $this->checkPostData($table, $post_data);
        if (!is_array($post_data)) {
            $errors[] = 'The request cannot be processed';
            $this->print_errors($errors);
            return 0;
        }

        $filter = $this->processWhere($table, $where);
        if (count($filter->placeholderValues) == 0) {
            $this->print_errors(['Can not select with one to update.']);
            return 0;
        }
        $queryStatement = $this->getQueryStatement($table, 'UPDATE', array_keys($post_data), $filter->statement);
        $placeholderValues = $this->getPlaceholderValues('UPDATE', $post_data, $filter->placeholderValues);
        return $this->runQuery('UPDATE', $queryStatement, $placeholderValues, $connection_name);
    }




    /**
     *
     * @param string  $table
     * @param array   $where
     * @param array   $session_data (optional)
     * @param bool    $log          (optional)
     * @return mixed
     */
    public function destroy(string $table, array $where, array $session_data = [], string $connection_name = '')
    {
        //session_data
        if (count($session_data) == 0) {
            $session_data['id'] = 0;
            $session_data['category'] = 'system';
        }
        $filter = $this->processWhere($table, $where);
        if (count($filter->placeholderValues) == 0) {
            $this->print_errors(['Can not select with one to delete.']);
            return 0;
        }
        $queryStatement = $this->getQueryStatement($table, 'DELETE', [], $filter->statement);
        return $this->runQuery('DELETE', $queryStatement, $filter->placeholderValues, $connection_name);
    }



    /**
     * TRUNCATE TABLE
     *
     * @access public
     * @param string $table
     * @return void
     */
    public function truncate(string $table, string $connection_name = '')
    {
        $pdo = $this->connect($connection_name);
        $query = 'TRUNCATE TABLE ' . $table;
        //prepare
        $statement = $pdo->prepare($query);

        if (is_object($statement)) {
            $statement->execute();
        }
    }




    /**
     *  rawSql
     *
     * @access public
     * @param string  $command
     * @param array   $placeholders_values (optional)
     * @return void
     */
    public function rawSql(string $command, array $placeholders_values = [], string $connection_name = '')
    {
        $pdo = $this->connect($connection_name);
        $statement = $pdo->prepare($command);
        if (is_object($statement)) {
            //execute
            if (count($placeholders_values) > 0) {
                $statement->execute((array)$placeholders_values);
            } else {
                $statement->execute();
            }
            return $statement->fetchAll();
        }
    }



    /**
     *
     * @param string  $attribute (optional)
     * @param string  $db_name   (optional)
     * @return array
     */
    public function getTables(string $attribute = '', string $db_name = '')
    {
        //get table_schema
        if (strlen($db_name)) {
            $table_schema = $db_name;
        } else {
            $connection = $this->getConnectionConfig();
            $table_schema = $connection['database'];
        }
        //filter_string & filter_value
        if (strlen($attribute)) {
            $whereStatement = 'WHERE TABLE_SCHEMA=:TABLE_SCHEMA AND COLUMN_NAME=:COLUMN_NAME';
            $placeholderValues = [":TABLE_SCHEMA" => $table_schema, ":COLUMN_NAME" => $attribute];
        } else {
            $whereStatement = 'WHERE TABLE_SCHEMA=:TABLE_SCHEMA';
            $placeholderValues = [":TABLE_SCHEMA" => $table_schema];
        }
        $queryStatement = $this->getQueryStatement('COLUMNS', 'SELECT', ['TABLE_NAME'], $whereStatement);
        //execute query
        $pdo = $this->connect('infodb');
        $statement = $pdo->prepare($queryStatement);
        $statement->execute((array)$placeholderValues);
        $rows = $statement->fetchAll();
        $tables = [];
        while ($row = array_shift($rows)) {
            $tables[] = $row['TABLE_NAME'];
        }
        return array_unique($tables);
    }



    /**
     *
     * @ access public
     * @param array   $errors (optional)
     * @return null
     */
    public function print_errors($errors = [])
    {
        foreach ($errors as $error) {
            $alert  = '';
            $alert .= '<div class="alert alert-danger">';
            $alert .= $error;
            $alert .= '</div>';
            echo $alert;
        }
    }
}
