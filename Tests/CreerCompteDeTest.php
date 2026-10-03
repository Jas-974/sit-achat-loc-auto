<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_creacompte.php';

class CreerCompteDeTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $_POST = [];
$_SERVER["REQUEST_METHOD"] = "POST";

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


//test la génération du numero client
    public function testGenerationNumClient(){

$num_client = genererNumeroClient();
$this -> AssertEquals(6, strlen($num_client));
    }
//test pwd diffèrent entre les deux champs
public function testPwdDifferent(){

$_POST["nom"] ="ama";
$_POST["prenom"] ="amaa";
$_POST["date_naissance"] ="1992-01-01";
$_POST["email"] ="ama.2@oran.fr";
$_POST["telephone"] ="262692057880";
$_POST["permis_b"] ="23658985";
$_POST["adresse"] ="1200 rue du test";
$_POST["code_postal"] ="97440";
$_POST["pseudo"] ="amaui";
$_POST["pwd"] ="amaui2345$";
$_POST["confirmation_pwd"] ="amaui43425$";

$res_creacompte = CreerUnCompte($this->pdo);

$this->assertFalse($res_creacompte["success"]);
}

// test des champs vide
public function testdesChampsVide(){
$_POST = [];
$Res_CreerCompte = CreerUnCompte($this->pdo);


$this->assertFalse($Res_CreerCompte["success"]);
$this->assertEquals("Tous les champs doivent être saisies", $Res_CreerCompte["message"]);
}

public function testCreaCompte(){
//test création du compte
$_POST["nom"] ="ama";
$_POST["prenom"] ="amaa";
$_POST["date_naissance"] ="1992-01-01";
$_POST["email"] ="ama.2@oran.fr";
$_POST["telephone"] ="262692057880";
$_POST["permis_b"] ="23658985";
$_POST["adresse"] ="1200 rue du test";
$_POST["code_postal"] ="97440";
$_POST["pseudo"] ="amaui";
$_POST["pwd"] ="amaui2345$";
$_POST["confirmation_pwd"] ="amaui2345$";

$res_creacompte = CreerUnCompte($this->pdo);
$this -> assertTrue($res_creacompte["success"]);

$this -> assertEquals("index.php?success=1", $res_creacompte['redirect']);
}

    }