<?php

    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET['id'])){
        
        $id         = $_GET['id'];
        $Query      = new Query();
	    $monedero   = $Query->getMonedero($id);
        $monedero   = json_decode($monedero);
        
	    if(empty($monedero)){
		    response(200,"Record not found", NULL);
	    }else{
		    response(200,"Record Found", $monedero);
	    }
	
    }else{
        response(400,"Invalid Request",NULL);
    }