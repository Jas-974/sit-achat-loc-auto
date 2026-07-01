<?php

function recupValeurChampsLocation(array $post): array
{

    // Récupération de la valeur du champ dans une variable
   if (isset($post["marque"])) {
        $marque = trim($post["marque"]);
    } else {
        $marque = "";
    }

    if (isset($post["modele"])) {
        $modele = trim($post["modele"]);
    } else {
        $modele = "";
    }
    if (isset($post["annee"])) {
        $annee = trim($post["annee"]);
    } else {
        $annee = "";
    }

    if (isset($post["boite"])) {
        $boite = trim($post["boite"]);
    } else {
        $boite = "";
    }

    if (isset($post["puissance"])) {
        $puissance = trim($post["puissance"]);
    } else {
        $puissance = "";
    }


    if (isset($post["carburant"])) {
        $carburant = trim($post["carburant"]);
    } else {
        $carburant = "";
    }
    if (isset($post["couleur"])) {
        $couleur = trim($post["couleur"]);
    } else {
        $couleur = "";
    }
    if (isset($post["type_offre"])) {
        $type_offre = trim($post["type_offre"]);
    } else {
        $type_offre = "";
    }

    if (isset($post["statut"])) {
        $statut = trim($post["statut"]);
    } else {
        $statut = "";
    }

    if (isset($post["description"])) {
        $description = trim($post["description"]);
    } else {
        $description = "";
    }

    if (isset($post["caution"])) {
        $caution = trim($post["caution"]);
    } else {
        $caution = "";
    }

    if (isset($post["prix_loc_jour"])) {
        $prix_loc_jour = trim($post["prix_loc_jour"]);
    } else {
        $prix_loc_jour = "";
    }
    if (isset($post["forfait_par_mois"])) {
        $forfait_par_mois = trim($post["forfait_par_mois"]);
    } else {
        $forfait_par_mois = "";
    }
    return [
        "marque" => $marque,
        "modele" => $modele,
        "annee" => $annee,
        "boite" => $boite,
        "puissance" => $puissance,
        "carburant" => $carburant,
        "couleur" => $couleur,
        "type_offre" => $type_offre,
        "statut" => $statut,
        "description" => $description,
        "caution" => $caution,
        "prix_loc_jour" => $prix_loc_jour,
        "forfait_par_mois" => $forfait_par_mois,
    ];
}
    function verifChampsVide(array $infoVehicule): bool
    {
        return(
         $infoVehicule["marque"] === "" || 
 $infoVehicule["modele"] === "" || 
 $infoVehicule["annee"] === "" || 
 $infoVehicule["boite"] === "" || 
 $infoVehicule["puissance"] === "" ||
 $infoVehicule["carburant"] === "" ||  
 $infoVehicule["couleur"] === "" || 
 $infoVehicule["type_offre"] === "" || 
 $infoVehicule["statut"] === "" || 
 $infoVehicule["description"] === "" ||     
 $infoVehicule["caution"] === "" || 
 $infoVehicule["prix_loc_jour"] === "" || 
 $infoVehicule["forfait_par_mois"] === ""
);
}


function insertionVehiculeLocation(PDO $pdo, array $infoVehicule): bool
{
$insertionBD = "INSERT INTO vehicule
(
marque,
modele,
annee,
boite,
puissance,
carburant,
couleur,
type_offre,
statut,
description,
caution,
prix_loc_jour,
forfait_par_mois
)
VALUES
(
:marque,
:modele,
:annee,
:boite,
:puissance,
:carburant,
:couleur,
:type_offre,
:statut,
:description,
:caution,
:prix_loc_jour,
:forfait_par_mois

)";
 $stmt = $pdo->prepare($insertionBD);
        //execute le code 
        
        return $stmt->execute([
                ":marque" =>  $infoVehicule["marque"],
                ":modele" =>  $infoVehicule["modele"],
                ":annee" =>  $infoVehicule["annee"],
                ":boite" =>  $infoVehicule["boite"],
                ":puissance" =>  $infoVehicule["puissance"],
                ":carburant" =>  $infoVehicule["carburant"],
                ":couleur" =>  $infoVehicule["couleur"],
                ":type_offre" =>  $infoVehicule["type_offre"],
                ":statut" =>  $infoVehicule["statut"],
                ":description" =>  $infoVehicule["description"],
                ":caution" =>  $infoVehicule["caution"],
                ":prix_loc_jour" =>  $infoVehicule["prix_loc_jour"],
                ":forfait_par_mois" =>  $infoVehicule["forfait_par_mois"]
            ]);

}
