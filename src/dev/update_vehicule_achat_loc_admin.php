<?php
session_start();
require "config.php";
require "fonction_gestion_vehiculelocachat_admin.php";


//fonction qui va faire la mise à jour de la table vehicule lors de la bascule location vers vente
// Requète est POST
$idvehicule =isset($_POST["id"]) ? (int) $_POST["id"] : 0;
$prix_loc_jour = $_POST["prix_loc_jour"] ?? "";
$forfait_par_mois= $_POST["forfait_par_mois"] ?? "";
$caution= $_POST["caution"] ?? "";
$type_offre= $_POST["type_offre"] ?? "";



$res_req = MajVehiculeAchatLoc(
    $pdo,
    $idvehicule,
    $prix_loc_jour,
    $forfait_par_mois,
  $caution

);

if ($res_req === true){
header("Location: LocVsAchat.php");
exit;
}

?>