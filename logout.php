<?php
session_start();

// Vider les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Redirection vers la page de connexion
header("Location: index_cnxn_creacompte.php");
exit;