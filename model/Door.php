<?php
    require_once("database/DatabaseActions.php");
    class Door{
        private $name;

        public function __construct($name){
            $this->name = $name;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }

        /**
         * Sends the door into the database and returns true if it was successful or false if it failed in doing so.
         * 
         * @return boolean
         */
        public function commit(){
            $database = new DatabaseActions($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);

            if($database->insertDoor($this->name)) return true; else return false;
        }
    }