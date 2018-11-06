<?php
$client=new SoapClient('http://localhost/source/server/setFilas.php?wsdl',['trace'=>1,'cache_wsdl'=>WSDL_CACHE_NONE]);
$id = $_GET["id"];

$resp=$client->Generar($id);
$resp=json_decode($resp);
echo $resp->cantidadPago;
echo $resp->cantidadApostada;

// echo $resp->id;
// echo $resp->aleatorio;
