<?php
class DBH extends MySQL
{
    protected static $_UniqueInstance ;
    
    public static function getInstance($args='')
    {
        if (self::$_UniqueInstance == null)
        {
            self::$_UniqueInstance = new self($args) ;
        }
        return self::$_UniqueInstance ;
    }
    
    function __construct($args='')
    {
        $db = ($args['db'])? $args['db'] : _DB ;
        $user = ($args['user'])? $args['user'] : _DB_USER ;
        $pass = ($args['pass'])? $args['pass'] : _DB_PASS ;
        parent::__construct($db, $user, $pass, $hostname='localhost', $port=3306) ;
    }

    
    // Gets a single row from $from where $where is true
    function Select($cols='*', $from, $where='', $orderBy='', $limit='', $like=false, $operand='AND'){
        // Catch Exceptions
        if(trim($from) == ''){
            return false;
        }

        $query = "SELECT {$cols} FROM `{$from}` WHERE ";

        if(is_array($where) && $where != ''){
            // Prepare Variables
            $where = $this->SecureData($where);

            foreach($where as $key=>$value){
                if($like){
                    //$query .= '`' . $key . '` LIKE "%' . $value . '%" ' . $operand . ' ';
                    $query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
                }else{
                    //$query .= '`' . $key . '` = "' . $value . '" ' . $operand . ' ';
                    $query .= "`{$key}` = '{$value}' {$operand} ";
                }
            }

            $query = substr($query, 0, -(strlen($operand)+2));

        }else{
            $query = substr($query, 0, -6);
        }

        if($orderBy != ''){
            $query .= ' ORDER BY ' . $orderBy;
        }

        if($limit != ''){
            $query .= ' LIMIT ' . $limit;
        }

        return $this->ExecuteSQL($query);
    }

    // Adds a record to the database based on the array key names
    function makeInsertSql($vars, $table, $exclude = ''){

        // Catch Exclusions
        if($exclude == ''){
            $exclude = array();
        }

        array_push($exclude, 'MAX_FILE_SIZE'); // Automatically exclude this one

        // Prepare Variables
        $vars = $this->SecureData($vars);

        $query = "INSERT INTO `{$table}` SET ";
        foreach($vars as $key=>$value){
            if(in_array($key, $exclude)){
                continue;
            }
            //$query .= '`' . $key . '` = "' . $value . '", ';
            $query .= "`{$key}` = '{$value}', ";
        }

        $query = substr($query, 0, -2);
        
        return $query ;
        
        //return $this->ExecuteSQL($query);
    }
    
    // Deletes a record from the database
    function makeDeleteSql($table, $where='', $limit='', $like=false){
        $query = "DELETE FROM `{$table}` WHERE ";
        if(is_array($where) && $where != ''){
            // Prepare Variables
            $where = $this->SecureData($where);

            foreach($where as $key=>$value){
                if($like){
                    //$query .= '`' . $key . '` LIKE "%' . $value . '%" AND ';
                    $query .= "`{$key}` LIKE '%{$value}%' AND ";
                }else{
                    //$query .= '`' . $key . '` = "' . $value . '" AND ';
                    $query .= "`{$key}` = '{$value}' AND ";
                }
            }

            $query = substr($query, 0, -5);
        }

        if($limit != ''){
            $query .= ' LIMIT ' . $limit;
        }

        return $query ;
        
        //return $this->ExecuteSQL($query);
    }

    // Gets a single row from $from where $where is true
    function makeSelectSql($cols='*', $from, $where='', $orderBy='', $limit='', $like=false, $operand='AND'){
        // Catch Exceptions
        if(trim($from) == ''){
            return false;
        }

        $query = "SELECT {$cols} FROM `{$from}` WHERE ";

        if(is_array($where) && $where != ''){
            // Prepare Variables
            $where = $this->SecureData($where);

            foreach($where as $key=>$value){
                if($like){
                    //$query .= '`' . $key . '` LIKE "%' . $value . '%" ' . $operand . ' ';
                    $query .= "`{$key}` LIKE '%{$value}%' {$operand} ";
                }else{
                    //$query .= '`' . $key . '` = "' . $value . '" ' . $operand . ' ';
                    $query .= "`{$key}` = '{$value}' {$operand} ";
                }
            }

            $query = substr($query, 0, -(strlen($operand)+2));

        }else{
            $query = substr($query, 0, -6);
        }

        if($orderBy != ''){
            $query .= ' ORDER BY ' . $orderBy;
        }

        if($limit != ''){
            $query .= ' LIMIT ' . $limit;
        }
        
        return $query ;
        
        //return $this->ExecuteSQL($query);
    }
    
    // Updates a record in the database based on WHERE
    function makeUpdateSql($table, $set, $where, $exclude = ''){
        // Catch Exceptions
        if(trim($table) == '' || !is_array($set) || !is_array($where)){
            return false;
        }
        if($exclude == ''){
            $exclude = array();
        }

        array_push($exclude, 'MAX_FILE_SIZE'); // Automatically exclude this one

        $set         = $this->SecureData($set);
        $where     = $this->SecureData($where);

        // SET

        $query = "UPDATE `{$table}` SET ";

        foreach($set as $key=>$value){
            if(in_array($key, $exclude)){
                continue;
            }
            $query .= "`{$key}` = '{$value}', ";
        }

        $query = substr($query, 0, -2);

        // WHERE

        $query .= ' WHERE ';

        foreach($where as $key=>$value){
            $query .= "`{$key}` = '{$value}' AND ";
        }

        $query = substr($query, 0, -5);

        return $query ;
        
        //return $this->ExecuteSQL($query);
    }

    
}


?>