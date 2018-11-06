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
                case "red":
                    $rojos = array(1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36);
                    if(in_array($ganador,$rojos)){
                        $cantidadPago = 2 * $cantidadApostada;
                    }
                    break;
                case "black":
                    $negros = array(2,4,6,8,10,11,13,15,17,20,22,24,26,28,29,31,33,35);
                    if(in_array($ganador,$negros)){
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
$server=new SoapServer(getUrlBase()."source/wsdl/color.wsdl");
$server->addFunction('Generar');
$server->handle();
?>
