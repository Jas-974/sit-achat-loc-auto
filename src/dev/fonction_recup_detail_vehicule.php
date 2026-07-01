<?php
// récupere les informations caractéristique de la voiture
function RecupInformationVehicule($pdo): array
{

//$id = 1;
if (!isset($_GET['id'])) {

return [
"success" => false,
"message" => "ID manquant"
];
}

$id = (int) $_GET['id'];


// reqête de recupération des informations dans la base de donnée
$sql = "SELECT id, marque, modele, prix, annee, kilometrage, boite, carburant, type_offre, prix_loc_jour, statut, image, forfait_par_mois
FROM vehicule 
WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$donnee_vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donnee_vehicule) {

return [
"success" => false,
"message" => "Véhicule introuvable"
];
}

return [
"success" => true,
"donnee_vehicule" => $donnee_vehicule
];
}

?>
