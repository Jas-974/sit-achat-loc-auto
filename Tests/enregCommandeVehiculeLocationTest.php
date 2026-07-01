<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_location.php';

class enregCommandeVehiculeLocationTest extends TestCase
{
  private PDO $pdo;


  protected function setUp(): void
  {

    $_POST = [];

    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->exec("
CREATE TABLE table_statu_command (
id INTEGER PRIMARY KEy,
numero_command TEXT,
nom TEXT,
prenom TEXT, 
email TEXT, 
type_offre TEXT, 
status_command TEXT, 
user_id TEXT
)"
);

 $this->pdo->exec("
 CREATE TABLE table_commandes (
id INTEGER PRIMARY KEy,
user_id INTEGER, 
car_id INTEGER, 
order_type TEXT, 
documents TEXT, 
adate TEXT)
");

}

public function testEnregCommandeLocation()
{
$_POST["maj_status_command"] = "Réservation en cours";

$donnee_user = [
"nom" => "Robert",
"prenom" => "Leto",
"email" => "leto.Rob@orange.fr"
];

$donnee_vehicule = [
"id" => 1,
"type_offre" => "location"
];

$res_enreg_command = enregCommandeVehiculeLocation($this->pdo, $donnee_user, $donnee_vehicule, 4);
$this->assertTrue($res_enreg_command);

$stmt = $this->pdo->query("SELECT * FROM table_statu_command");
$res_status = $stmt->fetch(PDO::FETCH_ASSOC);


$this->assertEquals("Robert", $res_status["nom"]);
$this->assertEquals("Leto", $res_status["prenom"]);
$this->assertEquals("leto.Rob@orange.fr", $res_status["email"]);
$this->assertEquals("location", $res_status["type_offre"]);
$this->assertEquals("Réservation en cours", $res_status["status_command"]);


$stmt = $this->pdo->query("SELECT * FROM table_commandes");
$la_command = $stmt->fetch(PDO::FETCH_ASSOC);
$this->assertEquals(4, $la_command["user_id"]);
$this->assertEquals(1, $la_command["car_id"]);
$this->assertEquals("location", $la_command["order_type"]);
}
}
?>