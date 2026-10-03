<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_suppression_VehiculeLoc.php';

class suppressionVehiculeTest extends TestCase
{
    private PDO $pdo;
    private array $vehicule;

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


    
    $this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (1,'Renault', 'clio', 'location', 'disponible', NULL),
         (2,'Peugeot', '208', 'location', 'disponible', NULL)");

    }
    public function testSupprUnVehicule(): void
    {
        $this->assertTrue(
            supressionVehiculeLoc($this->pdo, [1])
        );
        //compte le nombre de ligne dans la table
        $res_suppVehicule = $this->pdo->query('SELECT COUNT(*) FROM vehicule')->fetchColumn();

        $this->assertEquals(1, $res_suppVehicule);
    }

    public function testSupprDeuxVehicule(): void
    {
        $this->assertTrue(
            supressionVehiculeLoc($this->pdo, [1, 2])
        );
        //compte le nombre de ligne dans la table
        $res_suppVehicule = $this->pdo->query('SELECT COUNT(*) FROM vehicule')->fetchColumn();

        $this->assertEquals(0, $res_suppVehicule);
    }
}
?>