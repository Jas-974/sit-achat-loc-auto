<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_location.php';

class miseAjourStatusVehiculeReserveTest extends TestCase
{
  private PDO $pdo;


  protected function setUp(): void
  {

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

    $this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (1,'peugeot', '208', 'location', 'disponible', NULL)");
  }


  public function testReservationImpossibleSiVehiculeDejaReserv(): void
  {
    //Le vehicule est deja réservé
    $this->pdo->exec("UPDATE vehicule
    SET statut = 'reserve'
    WHERE id =1");

    //reserver une deuxieme fois
    $_POST['id'] = 1;
    $_POST['maj_status_command'] = 'Réservation en cours';
    $res_reservation = miseAjourStatusVehiculeReserve($this->pdo);

    //refus deuxieme reservation
    $stmt = $this->pdo->query("
SELECT statut FROM vehicule WHERE id= 1");

    $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->assertEquals('reserve', $vehicule['statut']);
    $this->assertFalse($res_reservation);
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
