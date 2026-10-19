<?php
session_start();
require "config.php";
require_once "fonction_annul_commande.php";



// vérification que l'utilisateur est connecté
if (isset($_SESSION['user_id']) && isset($_POST['numero_command'])) {

$user_id = (int) $_SESSION["user_id"];
$numero_command = $_POST['numero_command'];

//appel de la fonction annul commande
$annul_commande = annulerCommande($pdo, $user_id, $numero_command);

if (!$annul_commande) {
 header("Location: espace_client_news.php?erreur=annulation");
 exit;


}

 header("Location: espace_client_news.php");
 exit;
}
// si information absente
 header("Location: espace_client_news.php?erreur=annulation");
 exit;
