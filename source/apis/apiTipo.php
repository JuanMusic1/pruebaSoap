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
                    case "par":
                        if($ganador % 2 == 0){
                            $cantidadPago = 2 * $cantidadApostada;
                        }
                        break;
                    case "impar":
                        if($ganador % 2 != 0){
                            $cantidadPago = 2 * $cantidadApostada;
                        }
                        break;
                }
            }
        }

        $valores = array("cantidadPago" => $cantidadPago, "cantidadApostada" => $cantidadApostada);
        return $valores;
    
    }
