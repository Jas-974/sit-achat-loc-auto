<?php

require "config.php";
session_start();

<<<<<<< HEAD



//if ($_SERVER["REQUEST_METHOD"] !== "POST") {
//  header("Location: index.php");
 // exit;
//}
=======
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: cnxn.php");
  exit;
}
>>>>>>> feature/page_catalogue_globale


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
  die("Veuillez remplir tous les champs.");
}


<<<<<<< HEAD
if (isset($_GET["message"]) && $_GET["message"] === "connexion_obligatoire") {
    echo "<p>Veuillez vous connecter pour accéder à votre espace client.</p>";
}


=======
>>>>>>> feature/page_catalogue_globale
//Chercher l'utilisateur par email OU pseudo
$sql = "SELECT id, pseudo, email, pwd_hash
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

//Connexion à la session OK
$_SESSION["user_id"] = $user["id"];
$_SESSION["pseudo"] = $user["pseudo"];
<<<<<<< HEAD
$_SESSION["email"] = $user["email"];
// je revien a la page d'accueil
header("Location: espace_client_news.php?login=1");
=======
// je revien a la page d'accueil
header("Location: index.php?login=1");
>>>>>>> feature/page_catalogue_globale
exit;