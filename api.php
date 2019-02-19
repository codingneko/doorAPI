<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
header("Content-Type: text/json");
require_once("globals.php");
require_once("model/Door.php");
require_once("model/Registry.php");

if(isset($_GET["action"])){
    if($_GET["action"] == "addDoor" && !is_null($_GET["name"])){
        if($_GET["password"] == $GLOBALS['password']){
            $door = new Door("Cody's Door");
            $door->commit();
            echo '{"result": true}';
        }
    }else if($_GET["action"] == "add" && !is_null($_GET["status"]) && !is_null($_GET["doorId"])){
        $registry = new Registry($_GET["status"], $_GET["doorId"]);
        $registry->commit();
        echo '{"result": true}';
    }
}else if(!is_null($_GET["count"])){
    $database = new DatabaseActions($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
    $registries = $database->getRegistries($_GET["count"]);

    echo json_encode($registries);
}