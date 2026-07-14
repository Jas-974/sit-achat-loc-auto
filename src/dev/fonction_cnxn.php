<?php

//fonction de connexion 
function ConnexUser(PDO $pdo, string $identifiant, string $pwd): array
{

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
    return ["success" => false, "message" => "Veuillez remplir tous les champs"];

}


if (isset($_GET["message"]) && $_GET["message"] === "connexion_obligatoire") {
    echo "<p>Veuillez vous connecter pour accéder à votre espace client.</p>";
}


//Chercher l'utilisateur par email OU pseudo
$sql = "SELECT id, pseudo, email, pwd_hash, role
        FROM users
        WHERE email = :email OR pseudo = :pseudo
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([":email" => $identifiant, ":pseudo" => $identifiant] );
$user = $stmt->fetch(PDO::FETCH_ASSOC);


    
//je vérifie l'identifiant
if (!$user) {
 return ["success" => false, "message" => "identifiants incorrects"];
}



//Vérification du mot de pass haché
if (!password_verify($pwd, $user["pwd_hash"])) {
  return ["success" => false, "message" => "identifiants incorrects"];
}

//Connexion à la session OK
$_SESSION["user_id"] = $user["id"];
$_SESSION["pseudo"] = $user["pseudo"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];

 //return true;

 if ($user["role"] === "admin") {
  // si c'est l'admin on ouvre la page admin
     return ["success" => true, "redirect" => "dashboard_admin.php"];
} else {
  // si non je revien a la page d'accueil
    return ["success" => true, "redirect" => "index.php"];
   
}
}