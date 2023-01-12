<?php 
$host = "localhost";
$user = "root";
$password = "";
$db = "ClinicManagementDB";
//TO DO 

session_start();


$_SESSION["websiteURL"] = $host;
$_SESSION["databaseURL"] = $host;
$_SESSION["databaseUsername"] = $user;
$_SESSION["databasePassword"] = $password;
$_SESSION["databaseDBName"] = $db;

include_once('./classes/class-autoload.inc.php');



?>