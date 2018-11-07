<?php
ini_set("soap.wsdl_cache_enabled","0");

header("Content-Type:application/json");
require_once("../../database/Query.php");
require_once("../libraries/url.php");
require_once("../libraries/utils.php");

function Generar($id)
{	
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

    $valores['cantidadApostada'] = $cantidadApostada;
    $valores['cantidadPago'] = $cantidadPago;
    $valores=json_encode($valores);
    return $valores;
    
}
$server=new SoapServer(getUrlBase()."source/wsdl/numero.wsdl");
$server->addFunction('Generar');
$server->handle();
?>