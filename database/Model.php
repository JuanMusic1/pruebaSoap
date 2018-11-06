<?php

class Model {

    public $connection = null;

    //Constructor
    public function __construct() {
        $this->__connect();
    }

    //Connect
    private function __connect() {
        $host 		= 'localhost';
        $user 		= 'usuarioruleta';
        $password 	= 'eia2018*';
        $database 	= 'ruleta';

        $this->connection = new mysqli($host,$user,$password,$database);
        
        if($this->connection->connect_error){
            die("Falló la conexión: ". $connection->connect_error);
        }

    }

    //Magic method clone is empty to prevent duplication of connection
    private function __clone(){}

    //Close connection
    public function __close() {
        $this->connection = null;
    }

    //Get connection
    public function __getInstance() {
        if(self::$connection==null){
            self::$connection = new Model();
        }
        return self::$connection;
    }

}

