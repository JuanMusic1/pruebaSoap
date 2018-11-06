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

    foreach ($data as $key => $value) {
        if($value != 0){
            $cantidadApostada = $value;
            switch($key){
                case "1to18":
                    if($ganador>=1 && $ganador<=18){
                        $cantidadPago = 2 * $cantidadApostada;
                    }
                    break;
                case "19to36":
                    if($ganador>=19 && $ganador<=36){
                        $cantidadPago = 2 * $cantidadApostada;
                    }
                    break;
            }
        }
    }

    $valores['cantidadApostada'] = $cantidadApostada;
    $valores['cantidadPago'] = $cantidadPago;
    $valores=json_encode($valores);
    return $valores;
    
}
$server=new SoapServer(getUrlBase()."source/wsdl/mitad.wsdl");
$server->addFunction('Generar');
$server->handle();
?>