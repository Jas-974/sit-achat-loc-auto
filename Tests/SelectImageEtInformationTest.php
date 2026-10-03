<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonctions_index.php';

class SelectImageEtInformationTest extends TestCase

{
    private PDO $pdo;

    protected function setUp(): void
    {
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


        //insertion des données de test dans la table
        $this->pdo->exec("
INSERT INTO vehicule (id, image, marque, modele, type_offre, statut, status_command)
VALUES
(1,'image_1', 'Renault','R5','achat','disponible', NULL),
(2,'image_2', 'BMW','X1','location','disponible', NULL),
(3,'image_3', 'Peugeot','207','location','disponible', NULL)
");
    }

    public function testRetournInfoVehicule()
    {
        $infovehicule = SelectImageEtInformation($this->pdo);
        $this->assertIsArray($infovehicule);
        $this->assertCount(3, $infovehicule);
        $this->assertEquals('Peugeot', $infovehicule[2]['marque']);
        $this->assertEquals('Renault', $infovehicule[0]['marque']);
        $this->assertEquals('location', $infovehicule[1]['type_offre']);
    }
}

?>
