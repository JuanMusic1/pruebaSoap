<?php

    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET['cantidad'])){
        
        $cantidad   = $_GET['cantidad'];
        $Query      = new Query();
	    $frios      = $Query->getNumerosFrios($cantidad);
        $frios      = json_decode($frios);
        
	    if(empty($frios)){
		    response(200,"Record not found", NULL);
	    }else{
		    response(200,"Record Found", $frios);
	    }
	
    }else{
        response(400,"Invalid Request",NULL);
    }