<?php

require "config.php";
session_start();

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> feature/page_detail_vehicule



//if ($_SERVER["REQUEST_METHOD"] !== "POST") {
//  header("Location: index.php");
 // exit;
//}
<<<<<<< HEAD
=======
=======
>>>>>>> feature/page_cnxn_crea_compte
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: cnxn.php");
  exit;
}
<<<<<<< HEAD
>>>>>>> feature/page_catalogue_globale
=======
>>>>>>> feature/page_cnxn_crea_compte
=======
>>>>>>> feature/page_detail_vehicule


 if (isset($_POST["email"])) {
        $identifiant = trim($_POST["email"]);
    } else {
        $identifiant = "";
    }
if (isset($_POST["pwd"])) {
        $pwd = trim($_POST["pwd"]);
    } else {
        $pwd = "";
    }

 // vérification si les champs sont vides   
if ($identifiant === "" || $pwd === "") {
<<<<<<< HEAD
  //pour test PHPUnit
  //die("Veuillez remplir tous les champs.");
}
<<<<<<< HEAD


<<<<<<< HEAD
<<<<<<< HEAD
=======
// vérifie si l'utilisateur est dirigé vers la page avce le bon message
>>>>>>> feature/page_commande_voiture_location
=======
  die("Veuillez remplir tous les champs.");
}


>>>>>>> feature/page_detail_vehicule
if (isset($_GET["message"]) && $_GET["message"] === "connexion_obligatoire") {
    echo "<p>Veuillez vous connecter pour accéder à votre espace client.</p>";
}


<<<<<<< HEAD
=======
>>>>>>> feature/page_catalogue_globale
=======
>>>>>>> feature/page_cnxn_crea_compte
//Chercher l'utilisateur par email OU pseudo
$sql = "SELECT id, pseudo, email, pwd_hash, role
=======
//Chercher l'utilisateur par email OU pseudo
$sql = "SELECT id, pseudo, email, pwd_hash
>>>>>>> feature/page_detail_vehicule
        FROM users
        WHERE email = :id OR pseudo = :id
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $identifiant]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
//je vérifie l'identifiant
if (!$user) {
  die("Identifiants incorrects.");
}

//Vérification du mot de pass haché
if (!password_verify($pwd, $user["pwd_hash"])) {
  die("Identifiants incorrects.");
}

<<<<<<< HEAD



//Connexion à la session OK
$_SESSION["user_id"] = $user["id"];
$_SESSION["pseudo"] = $user["pseudo"];
<<<<<<< HEAD
<<<<<<< HEAD
$_SESSION["email"] = $user["email"];
<<<<<<< HEAD
// je revien a la page d'accueil
header("Location: espace_client_news.php?login=1");
=======
// je revien a la page d'accueil
header("Location: index.php?login=1");
>>>>>>> feature/page_catalogue_globale
=======
// je revien a la page d'accueil
header("Location: index.php?login=1");
>>>>>>> feature/page_cnxn_crea_compte
exit;
=======
$_SESSION["role"] = $user["role"];

if ($user["role"] === "admin") {
  // si c'est l'admin on ouvre la page admin
    header("Location: dashboard_admin.php");
    exit;
} else {
  // si non je revien a la page d'accueil
    header("Location: espace_client_news.php?login=1");
    exit;
}
>>>>>>> feature/page_commande_voiture_location
=======
//Connexion à la session OK
$_SESSION["user_id"] = $user["id"];
$_SESSION["pseudo"] = $user["pseudo"];
$_SESSION["email"] = $user["email"];
// je revien a la page d'accueil
header("Location: index_espace_client.php?login=1");
exit;
>>>>>>> feature/page_detail_vehicule
