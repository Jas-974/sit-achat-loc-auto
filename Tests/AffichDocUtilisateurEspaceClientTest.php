<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_espace_client.php';

class AffichDocUtilisateurEspaceClientTest extends TestCase
{

private PDO $pdo;

    public function testAffichDocUtilisateurEspaceClient(): void
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

        //insertion données de test
        $this->pdo->exec("
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(4, 'TEST007', 'Mrtes', 'John', 'mrjohn@orange.fr', 'mrtess', 'john', 'client'),
(5, 'TEST008', 'Mrtes', 'John', 'mrjohne@orange.fr', 'mrtesse', 'john', 'client')
");

$this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (1,'peugeot', '208', 'location', 'disponible', NULL)");



        $this->pdo->exec("
        INSERT INTO table_commandes
        (user_id, car_id, order_type, documents, adate)
        VALUES
        (4, 1, 'location', 'upload/doc1.pdf', '2026-08-10 10:00:00'),
         (4, 1, 'location', 'upload/doc2.pdf', '2026-08-12 10:00:00'),
          (4, 1, 'location', 'upload/doc3.pdf', '2026-08-13 10:00:00'),
           (4, 1, 'location', NULL, '2026-08-14 10:00:00'),
            (5, 1, 'location', 'upload/doc5.pdf', '2026-08-15 10:00:00')
        ");


        $res =  AffichDocUtilisateurEspaceClient($this->pdo, 4);

        $this->assertCount(3, $res);
        $this->assertSame('upload/doc3.pdf', $res[0]['documents']);
        $this->assertSame('upload/doc2.pdf', $res[1]['documents']);
        $this->assertSame('upload/doc1.pdf', $res[2]['documents']);
    }
}
