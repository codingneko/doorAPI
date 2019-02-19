<?php
    require_once("database/Database.php");

    class DatabaseActions extends Database{
        /**
         * @param string $host SQL server address.
         * @param string $user SQL server username.
         * @param string $password SQL server password.
         * @param string $dbName SQL database to connect to.
         */
        public function __construct($host, $user, $password, $dbName){
            parent::__construct($host, $user, $password, $dbName);
        }

        /**
         * Inserts a new registry into the database.
         * @param boolean $status true means the door is open, false means it's closed.
         * 
         * @return boolean
         */
        public function insertRegistry($status, $doorId){
            $statement = parent::prepare("INSERT INTO registry (status, doorId) VALUES (:doorStatus, :doorId)");

            $statement->bindParam(':doorStatus', $status);
            $statement->bindParam(':doorId', $doorId);
            
            if($statement->execute())return true; else return false;
        }

        /**
         * Inserts a new door into the database.
         * @param string $doorName name of the door to be inserted.
         * 
         * @return boolean
         */
        public function insertDoor($doorName){
            $statement = $this->prepare("INSERT INTO doors (doorName) VALUES (:doorName)");
            $statement->bindParam(':doorName', $doorName);
            if($statement->execute())return true; else return false;
        }

        public function getRegistries($amount){
            $stmt = $this->prepare("SELECT * FROM registry ORDER BY id DESC LIMIT $amount"); 
            $stmt->execute();

            // set the resulting array to associative
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        }
    }