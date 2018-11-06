<?php
    //Require
    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    //Config
    ini_set("soap.wsdl_cache_enabled","0");

    function Generar($cantidadApostada, $cantidadPago, $id){
        $Query = new Query();
        //$Query->restarBilletera($id, $cantidadApostada);
        $Query->sumarBilletera($id, $cantidadPago);
        $Query->setHistorialBilletera($id, 0, $cantidadApostada);
        $Query->setHistorialBilletera($id, 1, $cantidadPago);
    }

    //Send function
    $server = new SoapServer(getUrlBase()."source/wsdl/actualizarBilletera.wsdl");
    $server->addFunction('Generar');
    $server->handle();
?>
