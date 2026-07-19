<?php

function RecupIdVehicule(array $get):?int
{
if (!isset($get["id"])) {
return null;
}
return (int) $get["id"];
}

function RecupVehculeIdLocation(PDO $pdo, ?int $idvehicule): ?array
{

if ($idvehicule === null) {
return null;
}
// Extraction des véhicules pour affichages
$req = "SELECT id, marque, modele, statut FROM vehicule WHERE type_offre ='location' and id = :id";
$stat = $pdo->prepare($req);
$stat->execute(["id" => $idvehicule]);
$vehicules_location = $stat->fetch(PDO::FETCH_ASSOC);


if ($vehicules_location === false){

return null;
}
return $vehicules_location;
}

// fonction de recuperation de l'ID du vehicule à l'achat
function RecupVehculeIdAchat(PDO $pdo, ?int $idvehicule): ?array
{

if ($idvehicule === null) {
return null;
}
// Extraction des véhicules pour affichages
$req = "SELECT id, marque, modele, statut FROM vehicule WHERE type_offre ='achat' and id = :id";
$stat = $pdo->prepare($req);
$stat->execute(["id" => $idvehicule]);
$vehicules_location = $stat->fetch(PDO::FETCH_ASSOC);


if ($vehicules_location === false){

return null;
}
return $vehicules_location;
}
function MajVehiculeLocAchat(PDO $pdo, int $idvehicule, string $prix, string $loyer_mois, string $apport, 
string $type_offre): bool 
{
    $req = "UPDATE vehicule  SET prix =:prix,
    loyer_mois = :loyer_mois,
    apport= :apport,
    type_offre = :type_offre,
    prix_loc_jour = 0,
    forfait_par_mois = 0,
    caution = 0
WHERE id = :id";

$stat = $pdo->prepare($req);
return $stat->execute([
    "prix" => $prix,
    "loyer_mois" => $loyer_mois,
    "apport" => $apport,
    "type_offre" => $type_offre,
    "id" => $idvehicule
]);
}


function MajVehiculeAchatLoc(PDO $pdo, int $idvehicule, string $prix_loc_jour, string $forfait_par_mois, string $caution): bool 
{
    $req = "UPDATE vehicule  
    SET 
    prix_loc_jour = :prix_loc_jour,
    forfait_par_mois = :forfait_par_mois,
    caution = :caution,
    type_offre = 'location',
    prix = 0,
    statut =  'disponible',
    status_command = NULL,
    loyer_mois = 0,
    apport= 0
WHERE id = :id";

$stat = $pdo->prepare($req);
return $stat->execute([
"prix_loc_jour" => $prix_loc_jour,
    "forfait_par_mois" => $forfait_par_mois,
    "caution" => $caution,
    "id" => $idvehicule
]);
}




?>