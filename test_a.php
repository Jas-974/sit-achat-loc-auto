<?php
require "config.php";
require "gPostValue.php";


// Requète est POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

$marque = gPostValue("marque");
$modele = gPostValue("modele");
$annee = gPostValue("annee");
$kilometrage = gPostValue("kilometrage");
$boite = gPostValue("boite");
$puissance = gPostValue("puissance");
$carburant = gPostValue("carburant");
$couleur = gPostValue("couleur");
$type_offre = gPostValue("type_offre");
$statut = gPostValue("statut");
$description = gPostValue("description");
$apport = gPostValue("apport");
$loyer_mois = gPostValue("loyer_mois");

    // On vérifie si tous les champs sont vides
    if (
        $marque === "" || $modele === "" || $annee === "" || $kilometrage === "" || $boite === "" || $puissance === "" ||
        $carburant === "" ||  $couleur === "" || $type_offre === "" || $statut === "" || $description === "" ||
        $apport === ""  || $loyer_mois === ""
    ) {



        // vérification des valeurs des variables
        echo htmlspecialchars($marque);
        echo htmlspecialchars($modele);
        echo htmlspecialchars($annee);
        echo htmlspecialchars($kilometrage);
        echo htmlspecialchars($boite);
        echo htmlspecialchars($puissance);
        echo htmlspecialchars($carburant);
        echo htmlspecialchars($couleur);
        echo htmlspecialchars($type_offre);
        echo htmlspecialchars($statut);
        echo htmlspecialchars($description);
        echo htmlspecialchars($apport);
        echo htmlspecialchars($loyer_mois);
        die("Tous les champs doivent ètres saisies");
    }



    // Insertion en base
    $insertionBD = "INSERT INTO vehicule
            (marque, modele, annee, kilometrage, boite, puissance, carburant, couleur, type_offre, statut, description, apport, loyer_mois)
            VALUES
            (:marque, :modele, :annee, :kilometrage, :boite, :puissance, :carburant, :couleur, :type_offre, :statut, :description, :apport, :loyer_mois)";

    $stmt = $pdo->prepare($insertionBD);
    //execute le code 
    try {
        $stmt->execute([
            ":marque" => $marque,
            ":modele" => $modele,
            ":annee" => $annee,
            ":kilometrage" => $kilometrage,
            ":boite" => $boite,
            ":puissance" => $puissance,
            ":carburant" => $carburant,
            ":couleur" => $couleur,
            ":type_offre" => $type_offre,
            ":statut" => $statut,
            ":description" => $description,
            ":apport" => $apport,
            ":loyer_mois" => $loyer_mois

        ]);



   // redirection
        header("Location: test.php?success=1");
        exit;
    
    } catch (PDOException $e) {
        // Cas classique : doublon email/pseudo/permis_b (UNIQUE)
        echo "Erreur : " . $e->getMessage();
    }
}
?>