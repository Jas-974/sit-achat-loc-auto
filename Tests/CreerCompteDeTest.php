<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_creacompte.php';

class CreerCompteDeTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $_POST = [];
$_SERVER["REQUEST_METHOD"] = "POST";

        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("

CREATE TABLE users (
id INTEGER PRIMARY KEy,
numero_client TEXT,
nom TEXT,
prenom TEXT,
date_naissance TEXT,
email TEXT,
telephone TEXT,
permis_b TEXT,
adresse TEXT,
code_postal TEXT,
pseudo TEXT,
pwd_hash TEXT
        )
");
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
$_POST["date_naissance"] ="01-01-1992";
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
$_POST["date_naissance"] ="01-01-1992";
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