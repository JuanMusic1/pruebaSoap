<?php

    //Require
    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET["id"])){
        $id     = $_GET["id"];
        $data   = apiDocenas($id);
        response(200, "Valid request", $data);
    }else{
        response(400, "Invalid Request", NULL);
    }

    function apiDocenas($id){
        
        $Query          = new Query();
        $data           = $Query->getFichas($id);
        $ganador        = $data['ganador'];
        $cantidadPago   = 0;

        foreach ($data as $key => $value) {
            if($value != 0){
                $cantidadApostada = $value;
                switch($key){
                    case "1st12":
                        if($ganador>=1 && $ganador<=12){
                            $cantidadPago = 3 * $cantidadApostada;
                        }
                        break;
                    case "2nd12":
                        if($ganador>=13 && $ganador<=24){
                            $cantidadPago = 3 * $cantidadApostada;
                        }
                        break;
                    case "3rd12":
                        if($ganador>=25 && $ganador<=36){
                            $cantidadPago = 3 * $cantidadApostada;
                        }
                        break;
                }
            }
        }

        $valores = array("cantidadPago" => $cantidadPago, "cantidadApostada" => $cantidadApostada);
        return $valores;
    
    }
