<?php

    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET['id'])){
        
    }else{
        response(400,"Invalid Request",NULL);
    }

    function Generar($id){
        $Query      = new Query();
	    $monedero   = $Query->getMonedero($id);
        $monedero   = json_decode($monedero);
        return $monedero;
    }
    $server = new SoapServer(getUrlBase()."source/wsdl/monedero.wsdl");
    $server->addFunction('Generar');
    $server->handle();



?>