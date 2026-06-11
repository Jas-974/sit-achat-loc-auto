<?php
require "config.php";

// Appel à la fonction pour généré le numéro client genererNumeroClient()
require_once 'fonction_creacompte.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
$resultat_post = CreerUnCompte($pdo);

if (!$resultat_post["success"]){

echo $resultat_post["message"];
exit;
}

// redirection vers la page d'accueil
        header("Location: " . $resultat_post["redirect"]);
        exit;
}
