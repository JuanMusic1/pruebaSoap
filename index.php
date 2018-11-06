<?php

//Requiere libraries
require_once("source/libraries/url.php");

session_start();
if (!isset($_SESSION['id'])) {

    $id             = rand(11111,55555);
    $_SESSION['id'] = $id;
    
    //Conectar con la BD
    require_once("database/Model.php");
    
    //Crear el objeto que representa la conexion
    $bd = new Model();
    $insert = "INSERT INTO usuario (`id`, `billetera`) VALUES ('$id', '50000')";
    $bd->connection->query($insert);
    $insert = "INSERT INTO fichas (`usuario_id`,`target`, `value`) VALUES
    ('$id','ganador',0),('$id','0',0),('$id','1',0),('$id','2',0),('$id','3',0),('$id','4',0),('$id','5',0),('$id','6',0),('$id','7',0),('$id','8',0),('$id','9',0),('$id','10',0),
    ('$id','11',0),('$id','12',0),('$id','13',0),('$id','14',0),('$id','15',0),('$id','16',0),('$id','17',0),('$id','18',0),('$id','19',0),('$id','20',0),('$id','21',0),
    ('$id','22',0),('$id','23',0),('$id','24',0),('$id','25',0),('$id','26',0),('$id','27',0),('$id','28',0),('$id','29',0),('$id','30',0),('$id','31',0),('$id','32',0),
    ('$id','33',0),('$id','34',0),('$id','35',0),('$id','36',0),('$id','37',0),('$id','1st12',0),('$id','2nd12',0),('$id','3rd12',0),('$id','2to1_1',0),('$id','2to1_2',0),
    ('$id','2to1_3',0),('$id','1to18',0),('$id','par',0),('$id','red',0),('$id','black',0),('$id','impar',0),('$id','19to36',0)";
    $bd->connection->query($insert);

}

//Call header microservice
require("source/layout/head.php"); 

//Call microservices
require("source/layout/layout.php"); 

//Call footer microservice
require("source/layout/footer.php"); 
