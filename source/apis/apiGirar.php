<?php

    header("Content-Type:application/json");
    require_once("../../database/Query.php");
    require_once("../libraries/url.php");
    require_once("../libraries/utils.php");

    if(!empty($_GET['id'])){

        //Colores
		$redNumbers = [1,3,5,9,7,12,14,16,18,21,19,23,27,25,30,32,34,36];

		//Calculate winner
		$rand = rand(0,37);	
		if($rand == 0 || $rand == 37){
			$color = "green";
			$tipo  = "zero";
		}else{
			//Color
			if (in_array($rand, $redNumbers)) {
				$color = "red";
			}else{
				$color = "black";
			}
			//Tipo
			if($rand % 2 == 0){
				$tipo	= "par";
			}else{
				$tipo	= "impar";
			}
		}
        
        $id	= $_GET['id'];
        $Query  = new Query();
        
        //Save data
        $Query->setHistorialApuesta($rand, $color, $tipo);
        $Query->setGanadorOnFichas($rand, $id);
        $Query->updateCalientes($rand);
        
	    response(200,"Record Found", $rand);
	
    }else{
        response(400,"Invalid Request", NULL);
    }
