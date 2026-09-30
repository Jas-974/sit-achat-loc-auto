<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class selectInfoCommandForDashboardTest extends TestCase
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





 //insertion données de test
    $this->pdo->exec("
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(4, 'TEST005', 'Monsieur', 'Detest', 'detest@orange.fr', 'detest', 'test', 'client')
");

$this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (1,'peugeot', '208', 'location', 'disponible', NULL)");


        $this->pdo->exec("
INSERT INTO table_commandes (id, user_id, car_id, order_type, documents, adate)
VALUES
(10, 4, 1, 'location', 'doc.pdf', '2026-06-08')
");

$this->pdo->exec("
INSERT INTO table_statu_command
(commande_id, numero_command, user_id, nom, prenom, email, type_offre, status_command, code_status_command)
VALUES
(10, 'CMD9875', 4, 'Monsieur', 'Detest', 'detest@test.fr', 'location', 'Réservation en cours', '1')
");



    }

    public function testaffichageCommandDashboard()
    {

        $res_info_command = selectInfoCommandForDashboard($this->pdo);

        $this->assertCount(1, $res_info_command);

        $this->assertEquals('Monsieur', $res_info_command[0]['nom']);
        $this->assertEquals('Detest', $res_info_command[0]['prenom']);
        $this->assertEquals('CMD9875', $res_info_command[0]['numero_command']);
        $this->assertEquals('location', $res_info_command[0]['order_type']);
    }
}
