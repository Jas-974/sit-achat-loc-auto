<?php
session_start();
require "config.php";
// se connecte a la base puis éxécute la requete de suprression
if(!empty($_POST['vehicules_loc'])){
$id_vehicule = $_POST['vehicules_loc'];
foreach ($id_vehicule as $id_v) {
    $req = $pdo->prepare("DELETE FROM vehicule WHERE id = ?");
    $req->execute([$id_v]); 
}
}
header("location: admin_ajout_achat.php");
exit;
?>
