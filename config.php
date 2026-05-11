<?php
// connexion au serveur et à la base de donnée
//déclaration de variable
$host = "localhost";
$dbname = "bd_locachat";   
$user = "root";
$pass = "";
$dsn = "mysql:host=$host;dbname=$dbname";

<<<<<<< HEAD


=======
>>>>>>> feature/page_catalogue_globale
// utilisation de pdo pour se connecter à la base de donnée
try {
    // le DSN, le DataSourceName
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // gestion de l'exception
} catch (PDOException $PDOException) {
    die("Erreur connexion BDD : " . $PDOException->getMessage());
<<<<<<< HEAD
=======
    // écriture des erreur dans un fichier log
    file_put_contents('dblogs.log', $PDOException->getMessage().PHP_EOL, FILE_APPEND);
>>>>>>> feature/page_catalogue_globale
}
// Fin du script déconnexion automtatique