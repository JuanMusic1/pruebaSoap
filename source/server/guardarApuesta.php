<?php   

    session_start();

    //Require libraries
    require_once("../libraries/url.php");

    require_once("../../database/Model.php");
    
    //Get data
    $bd     = new Model();
    $data   = $_POST['kriss'];
    $target = $data['target'];
    $plata  = $data['plata'];
    $id     = $_SESSION['id'];

    //Check billetera actual
    $select 	= "SELECT billetera FROM usuario WHERE id = '".$id."'";
    $result 	= $bd->connection->query($select);
    $dinero  	= mysqli_fetch_all($result, MYSQLI_ASSOC);
    $cantidad 	= $dinero[0]['billetera'];
    
    //Validate
    if($cantidad - $plata >= 0){
        //Suma apostada
        $update = "UPDATE usuario SET billetera = billetera - $plata WHERE id = '".$id."'";
        $bd->connection->query($update);
        //Save data
        $update = "UPDATE fichas SET value = value + $plata WHERE target = '".$target."' AND usuario_id = '".$id."'";
        $bd->connection->query($update);
        echo "true";
    }else{
        echo "false";
    }
