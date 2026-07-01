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


        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("

CREATE TABLE users (
id INTEGER PRIMARY KEy,
numero_client TEXT,
pseudo TEXT,
email TEXT)
");

        $this->pdo->exec("
INSERT INTO users (id, numero_client, pseudo, email) VALUES
(1,'ZY2332','testad', 'klmonp@test.fr'),
(2, 'GP3856','tescmient', 'email1.jas@orange.fr')
");
    }

    public function testInformationUtilisateurConnecte()
    {
        $_SESSION["user_id"] = 1;
        $res_info_utilisateur = RecupInformationUtilisateurConnecte($this->pdo);


        $this->assertTrue($res_info_utilisateur["success"]);
        $this->assertEquals("ZY2332", $res_info_utilisateur["user"]["numero_client"]);
        $this->assertEquals("testad", $res_info_utilisateur["user"]["pseudo"]);
        $this->assertEquals("klmonp@test.fr", $res_info_utilisateur["user"]["email"]);
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
