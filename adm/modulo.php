<?php

//error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);

  ini_set('display_errors', 1); 
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL ^ E_NOTICE);

$DBHost="localhost";
$DBUser="roberta2_gp";
$DBPass="gpC4R3";
$DB="roberta2_gp";  

$con = mysqli_connect($DBHost,$DBUser,$DBPass);

mysqli_select_db($con, $DB);  
mysqli_query($con, 'SET sql_mode = ""');
mysqli_query($con, "SET NAMES 'utf8'");
mysqli_query($con, 'SET character_set_connection=utf8');
mysqli_query($con, 'SET character_set_client=utf8');
mysqli_query($con, 'SET character_set_results=utf8');


?>