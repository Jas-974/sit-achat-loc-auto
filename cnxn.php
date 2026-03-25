<?php

require "config.php";
session_start();




//if ($_SERVER["REQUEST_METHOD"] !== "POST") {
//  header("Location: index.php");
 // exit;
//}


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


if (isset($_GET["message"]) && $_GET["message"] === "connexion_obligatoire") {
    echo "<p>Veuillez vous connecter pour accéder à votre espace client.</p>";
}


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
$_SESSION["email"] = $user["email"];
// je revien a la page d'accueil
header("Location: index_espace_client.php?login=1");
exit;