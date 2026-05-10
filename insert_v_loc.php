<?php
require "config.php";


// Requète est POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupération de la valeur du champ dans une variable
    if (isset($_POST["marque"])) {
        $marque = trim($_POST["marque"]);
    } else {
        $marque = "";
    }

    if (isset($_POST["modele"])) {
        $modele = trim($_POST["modele"]);
    } else {
        $modele = "";
    }
    if (isset($_POST["annee"])) {
        $annee = trim($_POST["annee"]);
    } else {
        $annee = "";
    }

    if (isset($_POST["boite"])) {
        $boite = trim($_POST["boite"]);
    } else {
        $boite = "";
    }

    if (isset($_POST["puissance"])) {
        $puissance = trim($_POST["puissance"]);
    } else {
        $puissance = "";
    }


    if (isset($_POST["carburant"])) {
        $carburant = trim($_POST["carburant"]);
    } else {
        $carburant = "";
    }
    if (isset($_POST["couleur"])) {
        $couleur = trim($_POST["couleur"]);
    } else {
        $couleur = "";
    }
    if (isset($_POST["type_offre"])) {
        $type_offre = trim($_POST["type_offre"]);
    } else {
        $type_offre = "";
    }

    if (isset($_POST["statut"])) {
        $statut = trim($_POST["statut"]);
    } else {
        $statut = "";
    }

    if (isset($_POST["description"])) {
        $description = trim($_POST["description"]);
    } else {
        $description = "";
    }

    if (isset($_POST["caution"])) {
        $caution = trim($_POST["caution"]);
    } else {
        $caution = "";
    }

    if (isset($_POST["prix_loc_jour"])) {
        $prix_loc_jour = trim($_POST["prix_loc_jour"]);
    } else {
        $prix_loc_jour = "";
    }
    if (isset($_POST["forfait_par_mois"])) {
        $forfait_par_mois = trim($_POST["forfait_par_mois"]);
    } else {
        $forfait_par_mois = "";
    }


    // On vérifie si tous les champs sont vides
    if (
        $marque === "" || $modele === "" || $annee === "" || $boite === "" || $puissance === "" ||
        $carburant === "" ||  $couleur === "" || $type_offre === "" || $statut === "" || $description === "" ||
        $caution === "" || $prix_loc_jour === "" || $forfait_par_mois === ""
    ) {



        // vérification des valeurs des variables
        echo htmlspecialchars($marque);
        echo htmlspecialchars($modele);
        echo htmlspecialchars($annee);
        echo htmlspecialchars($boite);
        echo htmlspecialchars($puissance);
        echo htmlspecialchars($carburant);
        echo htmlspecialchars($couleur);
        echo htmlspecialchars($type_offre);
        echo htmlspecialchars($statut);
        echo htmlspecialchars($description);
        echo htmlspecialchars($caution);
        echo htmlspecialchars($prix_loc_jour);
        echo htmlspecialchars($forfait_par_mois);
        die("Tous les champs doivent ètres saisies");
    }



    // Insertion en base
    $insertionBD = "INSERT INTO vehicule
            (marque, modele, annee, boite, puissance, carburant, couleur, type_offre, statut, description, caution, prix_loc_jour, forfait_par_mois)
            VALUES
            (:marque, :modele, :annee, :boite, :puissance, :carburant, :couleur, :type_offre, :statut, :description, :caution, :prix_loc_jour, :forfait_par_mois)";

    $stmt = $pdo->prepare($insertionBD);
    //execute le code 
    try {
        $stmt->execute([
            ":marque" => $marque,
            ":modele" => $modele,
            ":annee" => $annee,
            ":boite" => $boite,
            ":puissance" => $puissance,
            ":carburant" => $carburant,
            ":couleur" => $couleur,
            ":type_offre" => $type_offre,
            ":statut" => $statut,
            ":description" => $description,
            ":caution" => $caution,
            ":prix_loc_jour" => $prix_loc_jour,
            ":forfait_par_mois" => $forfait_par_mois

        ]);
        // redirection
        header("Location: admin_ajout_location.php?success=1");
        exit;
    } catch (PDOException $e) {
        // Cas classique : doublon email/pseudo/permis_b (UNIQUE)
        echo "Erreur : " . $e->getMessage();
    }
}
?>