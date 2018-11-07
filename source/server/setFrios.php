<?php

    //Require libraries
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");

    //Config
    ini_set("soap.wsdl_cache_enabled","0");
    
    //Work with data
    function setFrios($cantidad){
        
        $Query      = new Query();
        $calientes  = $Query->getNumerosFrios($cantidad);
        return $calientes;
        
    }
    //Send function
    $server = new SoapServer("http://localhost/source/wsdl/frios.wsdl");
    $server->addFunction('setFrios');
    $server->handle();

