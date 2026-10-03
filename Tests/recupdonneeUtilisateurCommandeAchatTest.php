<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_achat.php';

class recupdonneeUtilisateurCommandeAchatTest extends TestCase
{

    private PDO $pdo;

    protected function setUp(): void
    {

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
    }



    //test si l'utilisateur n'est pas connecté donc une connexion est nécéssaire pour continuer la commande
    public function testrecupUtilisateurConnexionNecessaire(): void
    {
        $_SESSION  = [];


        $res_recup_donnee =  recupdonneeUtilisateurCommandeAchat($this->pdo);

        $this->assertFalse($res_recup_donnee["success"]);
        $this->assertEquals("connexion_necessaire", $res_recup_donnee["message"]);
    }

    // test si on est dans le cas ou l'utilisateur n'est pas trouvé
    public function testRecupUtilisateurIntrouvable(): void
    {

        $_SESSION["user_id"] = 1;

        $res_recup_donnee =  recupdonneeUtilisateurCommandeAchat($this->pdo);

        $this->assertFalse($res_recup_donnee["success"]);
        $this->assertEquals("utilisateur introuvable", $res_recup_donnee["message"]);
    }

    // test si on est dans le cas ou l'utilisateur est trouvé
    public function testRecupUtilisateurTrouve(): void
    {

        $_SESSION["user_id"] = 1;


        $this->pdo->exec("
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES (1,'TEST011','Payet', 'Michel', 'payet.michel@orange.fr', 'mpayet','test', 'client')
");

        $res_recup_donnee =  recupdonneeUtilisateurCommandeAchat($this->pdo);

        $this->assertTrue($res_recup_donnee["success"]);
        $this->assertEquals("Payet", $res_recup_donnee["user"]["nom"]);
        $this->assertEquals("Michel", $res_recup_donnee["user"]["prenom"]);
        $this->assertEquals("payet.michel@orange.fr", $res_recup_donnee["user"]["email"]);
    }
}
