<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreTotalCommandeTest extends TestCase
{

    private PDO $pdo;

    public function testNbreTotalCommande()
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
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(4, 'TEST002', 'MrTess', 'John', 'mrjohn@orange.fr', 'mrtess', 'john', 'client')
");

        $this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (16,'peugeot', '208', 'location', 'disponible', NULL)");


        $this->pdo->exec("
INSERT INTO table_commandes (id, user_id, car_id, order_type, documents, adate)
VALUES
(1, 4, 16, 'location','uploads/document1.pdf', '2026-10-01 10:00:00'),
(2, 4, 16, 'location','uploads/document2.pdf', '2026-10-02 10:00:00'),
(3, 4, 16, 'achat','uploads/document3.pdf', '2026-10-03 10:00:00')
");

        $res = NbreTotalCommande($this->pdo);
        $this->assertEquals(3, $res);
    }
}
