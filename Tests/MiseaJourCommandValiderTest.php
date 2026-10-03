<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class MiseaJourCommandValiderTest extends TestCase
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
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(10, 'TEST010', 'MrTess', 'John', 'mrjohndix@orange.fr', 'mrtess', 'john', 'client')
");


$this->pdo->exec("
INSERT INTO table_statu_command
(commande_id, numero_command, user_id, nom, prenom, email, type_offre, status_command, code_status_command)
VALUES
(10, 'CMD9875', 10, 'Monsieur', 'Detest', 'detest@test.fr', 'location', 'Réservation en cours', '1')
");

    }


//test de validation dela commande coét admin
    public function testValideCommand()
    {

 $_GET["id"] =  10;
  $_GET["valider"] =  "valider";

  MiseaJourCommandValider($this->pdo);

  $stmt = $this->pdo->query("SELECT * FROM table_statu_command WHERE commande_id = 10");
  $commande = $stmt->fetch(PDO::FETCH_ASSOC);

$this->assertEquals("Commande Validée , merci de proceder au paiement",
            $commande["status_command"]);

$this->assertEquals("2", $commande["code_status_command"]);


    }
    }
?>