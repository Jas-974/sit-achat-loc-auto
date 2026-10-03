<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_espace_client.php';

class RecupInformationUtilisateurConnecteTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $_SESSION = [];
        $_POST = [];


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
INSERT INTO users (id, numero_client, nom, prenom,email, pseudo, pwd_hash, role) VALUES
(1, 'TEST012', 'MrTesun', 'Johny', 'mrjohn1@orange.fr', 'mrtesun', 'johny', 'client'),
(2, 'TEST013', 'MrTesdeu', 'Pierre', 'mrjohn2@orange.fr', 'mrtesde', 'pierre', 'client')
");
    }

    public function testInformationUtilisateurConnecte()
    {
        $_SESSION["user_id"] = 1;
        $res_info_utilisateur = RecupInformationUtilisateurConnecte($this->pdo);


        $this->assertTrue($res_info_utilisateur["success"]);
        $this->assertEquals("TEST012", $res_info_utilisateur["user"]["numero_client"]);
        $this->assertEquals("mrtesun", $res_info_utilisateur["user"]["pseudo"]);
        $this->assertEquals("mrjohn1@orange.fr", $res_info_utilisateur["user"]["email"]);
    }

    public function testInformationUtilisateurNonConnecte()
    {

        $res_info_utilisateur = RecupInformationUtilisateurConnecte($this->pdo);

        $this->assertFalse($res_info_utilisateur["success"]);
        $this->assertEquals("Connexion nécessaire.", $res_info_utilisateur["message"]);
    }


    public function testInformationUtilisateurInexistant()
    {
        $_SESSION["user_id"] = 780;


        $res_info_utilisateur = RecupInformationUtilisateurConnecte($this->pdo);

        $this->assertFalse($res_info_utilisateur["success"]);
        $this->assertEquals("Utilisateur introuvable.", $res_info_utilisateur["message"]);
    }
}
