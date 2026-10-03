<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_espace_client.php';

class RecherchePourAfficheVehiculesEspaceClientTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $_GET = [];


        $port = getenv('DB_TEST_PORT') ?: '3307';
        $user = getenv('DB_TEST_USER') ?: 'root';
        $password = getenv('DB_TEST_PASSWORD') ?: '';

        $this->pdo = new PDO("mysql:host=127.0.0.1;port=$port;dbname=locachat_test;charset=utf8mb4", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        //néttoyage des tables
      
        $this->pdo->exec("DELETE FROM table_statu_command");
        $this->pdo->exec("DELETE FROM documents_upload");
        $this->pdo->exec("DELETE FROM table_commandes");
        $this->pdo->exec("DELETE FROM vehicule");
        $this->pdo->exec("DELETE FROM users");



        $this->pdo->exec("
INSERT INTO vehicule (id, titre, locachat, marque, modele, type_offre) VALUES
(1,'Peugeot 208', 'location', 'Peugeot', '208', 'location'),
(2,'Renault Clio', 'achat','Renault','Clio', 'achat')
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
