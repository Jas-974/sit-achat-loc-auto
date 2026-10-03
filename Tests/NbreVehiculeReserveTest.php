<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreVehiculeReserveTest extends TestCase
{
    private PDO $pdo;

    public function testNbreVehiculeReserve()
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




        $this->pdo->exec("
INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
(1,'peugeot', '208', 'achat', 'disponible', NULL),
        (2,'renault', 'clio', 'location', 'reserve', NULL),
        (3,'BMW', 'X1', 'location', 'reserve', NULL)
");

        $res = NbreVehiculeReserve($this->pdo, "reserve");
        $this->assertEquals(2, $res);
    }
}
