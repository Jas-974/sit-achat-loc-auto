<?php
require "config.php";
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> feature/page_detail_vehicule

// Fonction pour généré le numéro client
function genererNumeroClient()
{

    $lettres = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 2);
    $chiffres = rand(1000, 9999);

    return $lettres . $chiffres;
}

<<<<<<< HEAD
=======
>>>>>>> feature/page_catalogue_globale
=======
>>>>>>> feature/page_cnxn_crea_compte
=======
>>>>>>> feature/page_detail_vehicule
// si la methode http utilisé  de la requète est POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupération de la valeur du champ dans une variable, on enlève les espaces avec "trim"
    if (isset($_POST["nom"])) {
        $nom = trim($_POST["nom"]);
    } else {
        $nom = "";
    }

    if (isset($_POST["prenom"])) {
        $prenom = trim($_POST["prenom"]);
    } else {
        $prenom = "";
    }
    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
    } else {
        $email = "";
    }

    if (isset($_POST["telephone"])) {
        $telephone = trim($_POST["telephone"]);
    } else {
        $telephone = "";
    }

    if (isset($_POST["date_naissance"])) {
        $date_naissance = trim($_POST["date_naissance"]);
    } else {
        $date_naissance = "";
    }

    if (isset($_POST["permis_b"])) {
        $permis_b = trim($_POST["permis_b"]);
    } else {
        $permis_b = "";
    }
    if (isset($_POST["adresse"])) {
        $adresse = trim($_POST["adresse"]);
    } else {
        $adresse = "";
    }
    if (isset($_POST["code_postal"])) {
        $code_postal = trim($_POST["code_postal"]);
    } else {
        $code_postal = "";
    }

    if (isset($_POST["pseudo"])) {
        $pseudo = trim($_POST["pseudo"]);
    } else {
        $pseudo = "";
    }

    if (isset($_POST["pwd"])) {
        $pwd = trim($_POST["pwd"]);
    } else {
        $pwd = "";
    }

    if (isset($_POST["confirmation_pwd"])) {
        $confirmation_pwd = trim($_POST["confirmation_pwd"]);
    } else {
        $confirmation_pwd = "";
    }


    // On vérifie si tous les champs sont vides
    if (
        $nom === "" || $prenom === "" || $date_naissance === "" || $email === "" ||
        $telephone === "" || $permis_b === "" || $adresse === "" || $code_postal === "" ||
        $pseudo === "" || $pwd === "" || $confirmation_pwd === ""
    ) {



        // vérification des valeurs des variables
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> feature/page_detail_vehicule
        echo htmlspecialchars($nom);
        echo htmlspecialchars($prenom);
        echo htmlspecialchars($date_naissance);
        echo htmlspecialchars($email);
        echo htmlspecialchars($telephone);
        echo htmlspecialchars($permis_b);
        echo htmlspecialchars($adresse);
        echo htmlspecialchars($code_postal);
        echo htmlspecialchars($pseudo);
        echo htmlspecialchars($pwd);
        echo htmlspecialchars($confirmation_pwd);
<<<<<<< HEAD
=======
=======
>>>>>>> feature/page_cnxn_crea_compte
        echo $nom;
        echo $prenom;
        echo $date_naissance;
        echo $email;
        echo $telephone;
        echo $permis_b;
        echo $adresse;
        echo $code_postal;
        echo $pseudo;
        echo $pwd;
        echo $confirmation_pwd;
<<<<<<< HEAD
>>>>>>> feature/page_catalogue_globale
=======
>>>>>>> feature/page_cnxn_crea_compte
=======
>>>>>>> feature/page_detail_vehicule
        die("Tous les champs doivent ètres saisies");
    }

    if ($pwd !== $confirmation_pwd) {
        die("Les mots de passe ne correspondent pas.");
    }


    // pour le hashage du mot de pass
    $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> feature/page_detail_vehicule
    // génération du numéro client
    $numero_client = genererNumeroClient();


    // Insertion en base (SANS hash)
    $insertionBD = "INSERT INTO users
            (numero_client,nom, prenom, date_naissance, email, telephone, permis_b, adresse, code_postal, pseudo, pwd_hash)
            VALUES
            (:numero_client, :nom, :prenom, :date_naissance, :email, :telephone, :permis_b, :adresse, :code_postal, :pseudo, :pwd_hash)";

    $stmt = $pdo->prepare($insertionBD);
    //execute le code 
    try {
        $stmt->execute([
            ":numero_client" => $numero_client,
<<<<<<< HEAD
=======
=======
>>>>>>> feature/page_cnxn_crea_compte

    // Insertion en base (SANS hash)
    $insertionBD = "INSERT INTO users
            (nom, prenom, date_naissance, email, telephone, permis_b, adresse, code_postal, pseudo, pwd_hash)
            VALUES
            (:nom, :prenom, :date_naissance, :email, :telephone, :permis_b, :adresse, :code_postal, :pseudo, :pwd_hash)";

    $stmt = $pdo->prepare($insertionBD);

    try {
        $stmt->execute([
<<<<<<< HEAD
>>>>>>> feature/page_catalogue_globale
=======
>>>>>>> feature/page_cnxn_crea_compte
=======
>>>>>>> feature/page_detail_vehicule
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":date_naissance" => $date_naissance,
            ":email" => $email,
            ":telephone" => $telephone,
            ":permis_b" => $permis_b,
            ":adresse" => $adresse,
            ":code_postal" => $code_postal,
            ":pseudo" => $pseudo,
            ":pwd_hash" => $pwd_hash
        ]);
        // redirection vers la page d'accueil
        header("Location: index.php?success=1");
        exit;

        //echo "Compte créé et enregistré en base !";
    } catch (PDOException $e) {
<<<<<<< HEAD
=======
        // Cas classique : doublon email/pseudo/permis_b (UNIQUE)
>>>>>>> feature/page_detail_vehicule
        echo "Erreur : " . $e->getMessage();
    }
}
