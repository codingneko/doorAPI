<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
header("Content-Type: text/json");
require_once("globals.php");
require_once("model/Door.php");
require_once("model/Registry.php");

if(isset($_GET["action"])){
    if($_GET["action"] == "addDoor"){
        if(isset($_GET["name"])){
            if(isset($_GET["password"])){
                if($_GET["password"] == $GLOBALS['password']){
                    $door = new Door("Cody's Door");
                    $door->commit();
                    echo '{"result": true}';
                }else{
                    echo '{"result": "wrong credentials"}';
                }
            }else{
                echo '{"result": "password missing"}';
            }
        }else{
            echo '{"result": "name missing"}';
        }
    }else if($_GET["action"] == "add"){
        if(isset($_GET["status"])){
            if(isset($_GET["doorId"])){
                $registry = new Registry($_GET["status"], $_GET["doorId"]);
                $registry->commit();
                echo '{"result": true}';
            }else{
                echo '{"result": "doorId missing"}';
            }
        }else{
            echo '{"result": "status missing"}';
        }
    }else{
        echo '{"result": "unrecognized action"}';
    }
}else if(isset($_GET["count"])){
    $database = new DatabaseActions($GLOBALS['server'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
    $registries = $database->getRegistries($_GET["count"]);

    echo json_encode($registries);
}else{
    echo '{"result": "action missing"}';
}
