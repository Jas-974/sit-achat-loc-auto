<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_commande_voiture_location.php';

class miseAjourStatusVehiculeReserveTest extends TestCase
{
  private PDO $pdo;


  protected function setUp(): void
  {

    $_POST = [];

    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->exec("
CREATE TABLE vehicule (
id INTEGER PRIMARY KEy,
status_command TEXT,
statut TEXT )
");

    $this->pdo->exec("
INSERT INTO vehicule (id, status_command, statut) VALUES
(1, NULL, 'disponible')
");
  }

  public function testMiseAJourStatusVehicule()
  {
    $_POST['id'] = 1;
    $_POST["maj_status_command"] = "réservation en cours";

    miseAjourStatusVehiculeReserve($this->pdo);

    $stmt = $this->pdo->query("

SELECT status_command, statut 
FROM
vehicule WHERE id= 1");

    $res_vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertEquals('réservation en cours', $res_vehicule['status_command']);
    $this->assertEquals("reserve", $res_vehicule["statut"]);
  }

  public function testSansMiseAJourStatusVehicule()
  {
    $_POST = [];

    miseAjourStatusVehiculeReserve($this->pdo);

    $stmt = $this->pdo->query("

SELECT status_command, statut 
FROM
vehicule WHERE id= 1");

    $res_vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->assertNull($res_vehicule['status_command']);
    $this->assertEquals('disponible', $res_vehicule["statut"]);
  }
}
