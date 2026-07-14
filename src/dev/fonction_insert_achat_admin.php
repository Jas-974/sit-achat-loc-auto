
<?php

require_once __DIR__ . "/log.php";


function recupDonneeFormVehiculeAchat(): array
{
// Requète est POST
if  ($_SERVER["REQUEST_METHOD"] === "POST") {
    return [
"marque" => gPostValue("marque"),
"modele" => gPostValue("modele"),
"annee" => gPostValue("annee"),
"kilometrage" => gPostValue("kilometrage"),
"boite" => gPostValue("boite"),
"puissance" => gPostValue("puissance"),
"carburant" => gPostValue("carburant"),
"couleur" => gPostValue("couleur"),
"type_offre" => gPostValue("type_offre"),
"prix" => gPostValue("prix"),
"statut" => gPostValue("statut"),
"description" => gPostValue("description"),
"apport" => gPostValue("apport"),
"loyer_mois" => gPostValue("loyer_mois"),
];
}
return [];
}

function verifChampVide(array $champF): bool
    // On vérifie si tous les champs sont vides
{
    return (
       $champF["marque"] === "" || 
        $champF["modele"] === "" || 
        $champF["annee"] === "" ||
        $champF["kilometrage"] === "" || 
        $champF["boite"] === "" || 
        $champF["puissance"] === "" ||
        $champF["carburant"] === "" ||  
        $champF["couleur"] === "" || 
        $champF["type_offre"] === "" || 
        $champF["prix"] === "" || 
        $champF["statut"] === "" || 
        $champF["description"] === "" ||
        $champF["apport"] === ""  || 
        $champF["loyer_mois"] === ""
    );
}

function  afficheDonneeFormVehicule (array $info_vehicule): void
{
        // vérification des valeurs des variables
        echo htmlspecialchars($info_vehicule["marque"]);
        echo htmlspecialchars($info_vehicule["modele"]);
        echo htmlspecialchars($info_vehicule["annee"]);
        echo htmlspecialchars($info_vehicule["kilometrage"]);
        echo htmlspecialchars($info_vehicule["boite"]);
        echo htmlspecialchars($info_vehicule["puissance"]);
        echo htmlspecialchars($info_vehicule["carburant"]);
        echo htmlspecialchars($info_vehicule["couleur"]);
        echo htmlspecialchars($info_vehicule["type_offre"]);
        echo htmlspecialchars($info_vehicule["prix"]);
        echo htmlspecialchars($info_vehicule["statut"]);
        echo htmlspecialchars($info_vehicule["description"]);
        echo htmlspecialchars($info_vehicule["apport"]);
        echo htmlspecialchars($info_vehicule["loyer_mois"]);

    }


function insertVehicule(PDO $pdo, array $info_vehicule): bool
{
    // Insertion en base
    $insertionBD = "INSERT INTO vehicule
            (marque, modele, annee, kilometrage, boite, puissance, carburant, couleur, type_offre, prix ,statut, description, apport, loyer_mois)
            VALUES
            (:marque, :modele, :annee, :kilometrage, :boite, :puissance, :carburant, :couleur, :type_offre, :prix, :statut, :description, :apport, :loyer_mois)";

    $stmt = $pdo->prepare($insertionBD);
    //execute le code 
    
    $result_insertion =  $stmt->execute([
            ":marque" => $info_vehicule["marque"],
            ":modele" => $info_vehicule["modele"],
            ":annee" => $info_vehicule["annee"],
            ":kilometrage" => $info_vehicule["kilometrage"],
            ":boite" => $info_vehicule["boite"],
            ":puissance" => $info_vehicule["puissance"],
            ":carburant" => $info_vehicule["carburant"],
            ":couleur" => $info_vehicule["couleur"],
            ":type_offre" => $info_vehicule["type_offre"],
             ":prix" => $info_vehicule["prix"],
            ":statut" => $info_vehicule["statut"],
            ":description" => $info_vehicule["description"],
            ":apport" => $info_vehicule["apport"],
            ":loyer_mois" => $info_vehicule["loyer_mois"]

        ]);

        if ($result_insertion)
            {
$idVehicule = $pdo->lastInsertId();

 //gestion des logs commande achat créer 
   GestionLog("INFO", "Véhicule achat créée - vehicule_id = $idVehicule" . " - marque" . $info_vehicule["marque"] . " - modele" . $info_vehicule["modele"]);

            }
   return $result_insertion;

}

            

?>