<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_commande_voiture_location.php';

class recupUtilisateurDeLaCommandeTest extends TestCase
{
private PDO $pdo;



protected function setUp(): void {

$_SESSION = [];

  $this->pdo = new PDO('sqlite::memory:');
$this->pdo->exec("
CREATE TABLE users (
id INTEGER PRIMARY KEy,
nom TEXT,
prenom TEXT,
email TEXT
)
");

        $this->pdo->exec("
INSERT INTO users (id, nom , prenom, email) VALUES
(1,'Robert', 'Hélène','Rhel@orange.fr')

");
    }


public function testRecupInfoUtilisateur()
 {
        $_SESSION["user_id"] = 1;
        $res_info_utilisateur = recupUtilisateurDeLaCommande($this->pdo);


        $this->assertTrue($res_info_utilisateur["success"]);
        $this->assertEquals("Robert", $res_info_utilisateur["user"]["nom"]);
        $this->assertEquals("Hélène", $res_info_utilisateur["user"]["prenom"]);
        $this->assertEquals("Rhel@orange.fr", $res_info_utilisateur["user"]["email"]);
    }

}


?>