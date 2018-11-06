<?php

    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET['cantidad'])){
        
        $cantidad   = $_GET['cantidad'];
        $Query      = new Query();
	    $historial  = $Query->getHistorial($cantidad);
        $historial  = json_decode($historial);
        
	    if(empty($historial)){
		    response(200,"Record not found", NULL);
	    }else{
		    response(200,"Record Found", $historial);
	    }
	
    }else{
        response(400,"Invalid Request",NULL);
    }