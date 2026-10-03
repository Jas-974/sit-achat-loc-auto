<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreCommandeTest extends TestCase
{

private PDO $pdo;
    public function testNbreCommande()
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
INSERT INTO table_statu_command(numero_command, nom, prenom, email, type_offre, status_command, code_status_command)
VALUES
('CMD001', 'Test1', 'User1', 'email.test1@test.fr', 'achat', 'validée', 2),
('CMD002', 'Test2', 'User2', 'email.test2@test.fr', 'location', 'validée', 2),
('CMD003', 'Test3', 'User3', 'email.test3@test.fr', 'achat', 'validée', 1)
");

        $res = NbreCommande($this->pdo, 2);
        $this->assertEquals(2, $res);
    }
}
?>
