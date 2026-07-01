<?php
session_start();
require "config.php";
// se connecte a la base et éxécute la requete de suprression
if(!empty($_POST['vehicules_achat'])){
$id_vehicule = $_POST['vehicules_achat'];
foreach ($id_vehicule as $id_v) {
    $req = $pdo->prepare("DELETE FROM vehicule WHERE id = ?");
    $req->execute([$id_v]); 
}
}
header("location: test.php");
exit;
?>