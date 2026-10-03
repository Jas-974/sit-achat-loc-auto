<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_location.php';

class recupUtilisateurDeLaCommandeTest extends TestCase
{
private PDO $pdo;



protected function setUp(): void {

$_SESSION = [];

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
INSERT INTO users (id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(1, 'TEST013', 'Mrpie', 'John', 'mrjohn.P@orange.fr', 'mrpie', 'john', 'client')
");

    }


public function testRecupInfoUtilisateur()
 {
        $_SESSION["user_id"] = 1;
        $res_info_utilisateur = recupUtilisateurDeLaCommande($this->pdo);


        $this->assertTrue($res_info_utilisateur["success"]);
        $this->assertEquals("Mrpie", $res_info_utilisateur["user"]["nom"]);
        $this->assertEquals("John", $res_info_utilisateur["user"]["prenom"]);
        $this->assertEquals("mrjohn.P@orange.fr", $res_info_utilisateur["user"]["email"]);
    }

}


?>