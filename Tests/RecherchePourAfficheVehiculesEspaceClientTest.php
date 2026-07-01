<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_espace_client.php';

class RecherchePourAfficheVehiculesEspaceClientTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $_GET = [];
 


        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("

CREATE TABLE vehicule (
id INTEGER PRIMARY KEy,
titre TEXT,
locachat TEXT,
marque TEXT,
modele TEXT)
");

 $this->pdo->exec("
INSERT INTO vehicule (id, titre, locachat, marque, modele) VALUES
(1,'Peugeot 208', 'location', 'Peugeot', '208'),
(2,'Renault Clio', 'achat','Renault','Clio')
");
    }

public function testAffichVehicule()
{

$_GET["champ_recherche"] = "Peugeot";

$vignette_vehicule  = RecherchePourAfficheVehiculesEspaceClient($this->pdo);
 $this->assertCount(1, $vignette_vehicule);
$this->assertEquals('Peugeot', $vignette_vehicule[0]["marque"]);
$this->assertEquals('208', $vignette_vehicule[0]["modele"]);
$this->assertEquals('location', $vignette_vehicule[0]["locachat"]);
}
 }
?>