<?php
require "config.php";
require_once "fonction_cnxn.php";
session_start();


if (isset($_POST["email"])){
$identifiant = $_POST["email"];

}
else{

$identifiant ="";
}
if (isset($_POST["pwd"])){
$pwd = $_POST["pwd"];
}
else{

$pwd ="";
}

$res_cnxn = ConnexUser($pdo, $identifiant, $pwd);
if (!$res_cnxn["success"]) {
echo $res_cnxn["message"];
exit;
}
header("Location: " . $res_cnxn["redirect"]);
