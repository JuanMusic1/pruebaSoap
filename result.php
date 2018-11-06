<?php

//Require libraries
require_once("source/libraries/url.php");

session_start();

//Call header microservice
require("source/layout/head.php"); 

//Call microservices
require("source/layout/ruleta.php"); 

//Call footer microservice
require("source/layout/footer.php"); 
