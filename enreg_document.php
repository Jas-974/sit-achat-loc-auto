<?php


if (isset($_FILES['files'])) {

    $nom = $_FILES['files']['name'];
    $tmp = $_FILES['files']['tmp_name'];

    $dossier = "uploads/";
// boucle pour traité plusieur fichier
   foreach ($_FILES['files']['tmp_name'] as $index => $tmp_name) {

        if (!empty($tmp_name)) {

            $nom = $_FILES['files']['name'][$index];

            move_uploaded_file($tmp_name, $dossier . $nom);

        

            echo "Fichier enregistré : " . htmlspecialchars($nom) . "<br>";
        }
    }


} else {
    echo "Aucun fichier reçu";
}

?>