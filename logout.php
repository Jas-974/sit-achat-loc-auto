<?php
session_start();

// Vider les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Redirection vers la page de connexion
header("Location: /dev_web_locachat/index_cnxn_creacompte.php");
header("Location: index_cnxn_creacompte.php");
exit;