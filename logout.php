<?php
session_start();

// Vider les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Redirection vers la page de connexion
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
header("Location: /index_cnxn_creacompte.php");
=======
header("Location: /dev_web_locachat/index_cnxn_creacompte.php");
>>>>>>> feature/page_catalogue_globale
=======
header("Location: /dev_web_locachat/index_cnxn_creacompte.php");
>>>>>>> feature/page_cnxn_crea_compte
=======
header("Location: index_cnxn_creacompte.php");
>>>>>>> feature/page_commande_voiture_location
exit;