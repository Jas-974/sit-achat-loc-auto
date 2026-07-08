<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_achat.php';

class recupdonneeUtilisateurCommandeAchatTest extends TestCase
{

private PDO $pdo;

protected function setup(): void
{

$_SESSION = [];

    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}



    //test si l'utilisateur n'est pas connecté donc une connexion est nécéssaire pour continuer la commande
public function testrecupUtilisateurConnexionNecessaire(): void
{
$_SESSION  = [];


$res_recup_donnee =  recupdonneeUtilisateurCommandeAchat($this-> pdo);

$this->assertFalse($res_recup_donnee["success"]);
$this->assertEquals("connexion_necessaire", $res_recup_donnee["message"]);

}





// test si on est dans le cas ou l'utilisateur n'est pas trouvé
public function testRecupUtilisateurIntrouvable(): void
{

$_SESSION["user_id"] = 1;

 $this->pdo->exec("
CREATE TABLE users (
id INTEGER PRIMARY KEy,
nom TEXT,
prenom  TEXT, 
email TEXT)
 ");

$res_recup_donnee =  recupdonneeUtilisateurCommandeAchat($this-> pdo);

$this->assertFalse($res_recup_donnee["success"]);
$this->assertEquals("utilisateur introuvable", $res_recup_donnee["message"]);

}

// test si on est dans le cas ou l'utilisateur est trouvé
public function testRecupUtilisateurTrouve(): void
{

$_SESSION["user_id"] = 1;

 $this->pdo->exec("
CREATE TABLE users (
id INTEGER PRIMARY KEy,
nom TEXT,
prenom  TEXT, 
email TEXT)
 ");

$this->pdo->exec("
INSERT INTO users(id, nom, prenom, email)
VALUES (1,'Payet', 'Michel', 'payet.michel@orange.fr')
");

$res_recup_donnee =  recupdonneeUtilisateurCommandeAchat($this-> pdo);

$this->assertTrue($res_recup_donnee["success"]);
$this->assertEquals("Payet", $res_recup_donnee["user"]["nom"]);
$this->assertEquals("Michel", $res_recup_donnee["user"]["prenom"]);
$this->assertEquals("payet.michel@orange.fr", $res_recup_donnee["user"]["email"]);


}







}

?>