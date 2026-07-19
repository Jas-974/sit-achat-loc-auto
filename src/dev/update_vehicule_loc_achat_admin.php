<?php
session_start();
require "config.php";
require "fonction_gestion_vehiculelocachat_admin.php";


//fonction qui va faire la mise à jour de la table vehicule lors de la bascule location vers vente
// Requète est POST
$idvehicule =isset($_POST["id"]) ? (int) $_POST["id"] : 0;
$prix = $_POST["prix"] ?? "";
$loyer_mois= $_POST["loyer_mois"] ?? "";
$apport= $_POST["apport"] ?? "";
$type_offre= $_POST["locachat"] ?? "";


$res_req = MajVehiculeLocAchat(
    $pdo,
    $idvehicule,
    $prix,
    $loyer_mois,
  $apport,
  $type_offre

);

if ($res_req === true){
header("Location: LocVsAchat.php");
exit;
}

?>