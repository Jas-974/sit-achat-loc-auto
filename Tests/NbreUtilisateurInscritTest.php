<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreUtilisateurInscritTest extends TestCase
{

    private PDO $pdo;
    public function testNbreUtilisateurInscrit()
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
(1, 'TEST001', 'MrTess1', 'John1', 'mrjohn1@orange.fr', 'mrtess1', 'john', 'client'),
(2, 'TEST002', 'MrTess2', 'John2', 'mrjohn2@orange.fr', 'mrtess2', 'john', 'client'),
(3, 'TEST003', 'MrTess3', 'John3', 'mrjohn3@orange.fr', 'mrtess3', 'john', 'client'),
(4, 'TEST004', 'MrTess4', 'John4', 'mrjohn4@orange.fr', 'mrtess4', 'john', 'client')

");

        $res = NbreUtilisateurInscrit($this->pdo);
        $this->assertEquals(4, $res);
    }
}
