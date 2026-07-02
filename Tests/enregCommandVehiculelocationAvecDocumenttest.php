<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_location.php';

class enregCommandeVehiculeLocationAvecDocumentTest extends TestCase
{
  private PDO $pdo;


  protected function setUp(): void
  {

    $_POST = [];

    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

$this->pdo->exec("
CREATE TABLE documents_upload (
id INTEGER PRIMARY KEy,
user_id INTEGER, 
car_id INTEGER, 
documents TEXT,
created_at TEXT)
");

public function testDocUploadRatachementAvecLaCommand()
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

$commande_id = enregCommandeVehiculeLocation (
    $this->pdo,
    $donnee_user,
    $donnee_vehicule,
    4
);
$this->assertIsNumeric($commande_id);
$stmt = $this->pdo->query("SELECT * FROM table_commandes");
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

$this->assertEquals("4", $commande["user_id"]);
$this->assertEquals("1", $commande["car_id"]);
$this->assertEquals("location", $commande["order_type"]);
$this->assertEquals("uploads/document_test.pdf", $commande["documents"]);

$stmt = $this->pdo->query("SELECT COUNT(*) FROM documents_upload");
$this->assertEquals(à, $stmt->fetchColumn());

}