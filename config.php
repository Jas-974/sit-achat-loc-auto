<?php
// connexion au serveur et à la base de donnée
//déclaration de variable
$host = "sql305.infinityfree.com";
$dbname = "if0_41302948_bd_locachat";   
$user = "if0_41302948";
$pass = "B7jc5nTtIiq";
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";



// utilisation de pdo pour se connecter à la base de donnée
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // gestion de l'exception
} catch (PDOException $PDOException) {
    die("Erreur connexion BDD : " . $PDOException->getMessage());
}
