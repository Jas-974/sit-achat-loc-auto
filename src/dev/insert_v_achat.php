<?php
require "config.php";
require "gPostvalue.php";
require "fonction_insert_achat_admin.php";

// Requète est POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {


$info_vehicule = recupDonneeFormVehiculeAchat();

    // On vérifie si tous les champs sont vides
    if (verifChampVide($info_vehicule)) {

        echo "Tous les champs doivent ètres saisies";
        return;
    }

    try {
        insertVehicule($pdo, $info_vehicule);
   // redirection

    echo "Insertion réussie";
    return;
       // header("Location: test.php?success=1");
        //return;
    
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>