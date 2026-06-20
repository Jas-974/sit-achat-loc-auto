<?php
require "config.php";
require "fonction_insert_location_admin.php";


// Requète est POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $infoVehicule = recupValeurChampsLocation($_POST);

    // On vérifie si tous les champs sont vides
    if (verifChampsVide($infoVehicule)) {
        $msgErreur = "Tous les champs doivent ètre saisis";
    } else {

        try {
            insertionVehiculeLocation($pdo,$infoVehicule);
           
            // redirection
            header("Location: admin_ajout_location.php?success=1");
            exit;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
