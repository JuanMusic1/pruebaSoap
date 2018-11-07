<?php

    //Requires
    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    ini_set("soap.wsdl_cache_enabled","0");

    //Work With data
    function setMonedero($id){
        $Query      = new Query();
	    $monedero   = $Query->getMonedero($id);
        //$monedero   = json_decode($monedero);
        return $monedero;
    }


    $server = new SoapServer("http://localhost/source/wsdl/monedero.wsdl");
    $server -> addFunction('setMonedero');
    $server -> handle();

?>
