<?php
    require_once("database/DatabaseActions.php");
    class Registry{
        private $status;
        private $doorId;
        
        public function __construct($status, $doorId){
            $this->status = $status;
            $this->doorId = $doorId;
        }

        public function getStatus(){
            return $this->status;
        }

        public function commit(){
            $database = new DatabaseActions($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
            
            if($database->insertRegistry($this->status, $this->doorId))return true; else return false;;
        }
    }