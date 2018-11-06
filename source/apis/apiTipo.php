<?php

    //Require
    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET["id"])){
        $id     = $_GET["id"];
        $data   = apiTipo($id);
        response(200, "Valid request", $data);
    }else{
        response(400, "Invalid Request", NULL);
    }

    function apiTipo($id){

        $Query          = new Query();
        $data           = $Query->getFichas($id);
        $ganador        = $data['ganador'];
        $cantidadPago   = 0;

        foreach ($data as $key => $value) {
            if($value != 0){
                $cantidadApostada = $value;
                switch($key){
                    case "1to18":
                        if($ganador>=1 && $ganador<=18){
                            $cantidadPago = 2 * $cantidadApostada;
                        }
                        break;
                    case "19to36":
                        if($ganador>=19 && $ganador<=36){
                            $cantidadPago = 2 * $cantidadApostada;
                        }
                        break;
                }
            }
        }

        $valores = array("cantidadPago" => $cantidadPago, "cantidadApostada" => $cantidadApostada);
        return $valores;
    
    }
