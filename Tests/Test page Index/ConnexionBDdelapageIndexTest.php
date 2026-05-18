<?php

use PHPUnit\Framework\TestCase;
class ConnexionBDdelapageIndexTest extends TestCase {

// test pour connexion OK
public function testConnexBdIndexOK(){
//paramètre de connexion valide
$host = "localhost";
$dbname = "bd_locachat";
$username = "root";
$password = "";

//appel à la fonction
$pdo = ConnexBD($host, $dbname, $username, $password);
$this-> assertInstanceOf(PDO::class, $pdo);
}
// test pour connexion NOK
public function testConnexBdIndexNOK(){
//paramètre de connexion non valide
$host = "localhost";
$dbname = "bd_locachatxxx";
$username = "root";
$password = "";


$this->expectException(Exception::class);
$this->expectExceptionMessage('Erreur connexion BDD');

//Appel à la fonction
ConnexBD($host, $dbname, $username, $password);


}
}
