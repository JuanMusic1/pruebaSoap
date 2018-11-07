<?php

    //Require
    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");
    
    if(!empty($_GET["cantidadPago"]) && !empty($_GET["cantidadApostada"]) && !empty($_GET["id"])){
        $id                 = $_GET['id'];
        $cantidadPago       = $_GET["cantidadPago"];
        $cantidadApostada   = $_GET["cantidadApostada"];
        apiBilletera($cantidadApostada, $cantidadPago, $id);
    }else{
        response(400, "Invalid Request");
    }

    
    function apiBilletera($cantidadApostada, $cantidadPago, $id){
        $Query = new Query();
        //$Query->restarBilletera($id, $cantidadApostada);
        $Query->sumarBilletera($id, $cantidadPago);
        $Query->setHistorialBilletera($id, 0, $cantidadApostada);
        $Query->setHistorialBilletera($id, 1, $cantidadPago);
    }