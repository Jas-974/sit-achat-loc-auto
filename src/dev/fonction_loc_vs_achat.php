<?php

function ExtractVehiculeAchat(PDO $pdo): array
{
// Extraction des véhicules pour affichages
$req = "SELECT id, marque, modele, statut FROM vehicule WHERE type_offre ='achat'";
$stat = $pdo->query($req);
return $stat->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php
function ExtractVehiculeLocation(PDO $pdo): array
{
// Extraction des véhicules pour affichages
$req = "SELECT id, marque, modele, statut FROM vehicule WHERE type_offre ='location'";
$stat = $pdo->query($req);
return $stat->fetchAll(PDO::FETCH_ASSOC);
}
?>