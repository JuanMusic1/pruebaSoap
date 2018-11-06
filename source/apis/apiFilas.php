<?php

    //Require
    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET["id"])){
        $id     = $_GET["id"];
        $data   = apiFilas($id);
        response(200, "Valid request", $data);
    }else{
        response(400, "Invalid Request", NULL);
    }

    function apiFilas($id){

        $Query          = new Query();
        $data           = $Query->getFichas($id);
        $ganador        = $data['ganador'];
        $cantidadPago   = 0;

        foreach ($data as $key => $value) {
            if($value != 0){
                $cantidadApostada = $value;
                switch($key){
                    case "2to1_1":
                    $acumulador=$ganador;
                    while($acumulador <= 34){
                        if($acumulador == 34){
                            $cantidadPago = 3 * $cantidadApostada;
                        }
                        $acumulador=$acumulador+3;
                    }
                    break;
                case "2to1_2":
                    $acumulador = $ganador;
                    while($acumulador <= 35){
                        if($acumulador == 35){
                            $cantidadPago = 3 * $cantidadApostada;
                        }
                        $acumulador = $acumulador + 3;
                    }
                    break;
                case "2to1_3":
                    $acumulador=$ganador;
                    while($acumulador <= 36){
                        if($acumulador == 36){
                            $cantidadPago = 3 * $cantidadApostada;
                        }
                        $acumulador=$acumulador+3;
                    }
                    break;
                }
            }
        }

        $valores = array("cantidadPago" => $cantidadPago, "cantidadApostada" => $cantidadApostada);
        return $valores;
    
    }
