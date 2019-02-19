<?php
    /**
     * Extendable Database class that uses PDO to connect to a specified SQL server and send queries. 
     * 
     * @property string $host server address
     * @property string $user server username
     * @property string $password server password
     * @property string $dbName database name
     * @property PDO $PDO database object
     * 
     * @author codingneko
     */
    class Database{
        protected $host;
        protected $user;
        protected $password;
        protected $dbName;
        protected $conn;

        /**
         * @param string $host SQL server address.
         * @param string $user SQL server username.
         * @param string $password SQL server password.
         * @param string $dbName SQL database to connect to.
         */
        public function __construct($host, $user, $password, $dbName){
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->dbName = $dbName;
            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->password);
                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }

        public function prepare($SQL){
            return $this->conn->prepare($SQL);
        }


        /**
         * Sends a SQL query directly to the server.
         * NOT RECOMMENDED, HIGH RISK OF VULNERABILITY, USE PREPARE INSTEAD.
         * 
         * @param string $SQL SQL to be sent to the server
         * @return boolean
         */
        public function insert($SQL){
            if($this->conn->exec($SQL) != 0) return true; else return false;
        }
    }