<?php
    
    //Require
    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET["id"])){
        $id     = $_GET["id"];
        $data   = apiNumero($id);
        response(200, "Valid request", $data);
    }else{
        response(400, "Invalid Request", NULL);
    }


    function apiNumero($id){

        $Query          = new Query();
        $data           = $Query->getFichas($id);
        $ganador        = $data['ganador'];
        $cantidadPago   = 0;

        for($i=0; $i<=37; $i++){
            $cantidadApostada = $data[$i];
            if($data[$i] != 0 and $i == $ganador){
                $cantidadPago = 36 * $cantidadApostada;
            }
        }

        $valores = array("cantidadPago" => $cantidadPago, "cantidadApostada" => $cantidadApostada);
        return $valores;
    
    }
