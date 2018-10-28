<?php
    class db{
        //Properties
        private $dbhost = "localhost";
        private $dbuser = "PWilkending";
        private $dbpass = "WilkendingDB!";
        private $dbname = "dbwebapi";

        //Connect
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $dbConnection = new PDO($mysql_connect_str,$this->dbuser,$this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Very important for returning queries as json
            $dbConnection->exec("SET CHARACTER SET utf8");
            return $dbConnection;
        }
    }
?>