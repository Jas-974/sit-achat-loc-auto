<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonctions_index.php';

class ConnexionBDTest extends TestCase
{
    // test de la connexion à la base de donnée
public function testConnexionBD()

{

$host ="localhost;port=3307";
$dbname ="bd_locachat";
$username ="root";
$password = "";



$pdo = ConnexBD($host, $dbname, $username, $password);

$this->assertInstanceOf(PDO::class, $pdo);
}

}
?>