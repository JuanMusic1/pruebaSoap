<?php

    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    //Config
    ini_set("soap.wsdl_cache_enabled","0");

    function Generar($cantidad){
      $Query      = new Query();
      $historial  = $Query->getHistorial($cantidad);
      return $historial;
    }

    //Send function
    $server = new SoapServer(getUrlBase()."source/wsdl/historial.wsdl");
    $server->addFunction('Generar');
    $server->handle();

?>
