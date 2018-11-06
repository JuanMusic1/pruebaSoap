<?php

/**
 * Permite responder en modo rest
 *
 * @param String $status : estado de la respuesta	
 * @param String $status_message : mensaje del estado
 * @param String $data : información
 *
 * @return String $dominio : dominio actual
 */
function response($status, $status_message, $data){
    header("HTTP/1.1 ".$status);
    $response['status']=$status;
    $response['status_message']=$status_message;
    $response['data']=$data;
    $json_response = json_encode($response);
    echo $json_response;
}