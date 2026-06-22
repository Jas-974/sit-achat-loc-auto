<?php
session_start();
require "config.php";
require "fonction_ supression_VehiculeLoc.php"
// se connecte a la base et éxécute la requete de suprression
if(!empty($_POST['vehicules_loc'])){
supressionVehiculeLoc($pdo, $_POST['vehicule_loc']);
header("location: test.php");
exit;
?>