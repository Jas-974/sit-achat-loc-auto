<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_location.php';

class enregCommandeVehiculeLocationTest extends TestCase
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

    //insertion données de test
    $this->pdo->exec("
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(4, 'TEST003', 'MrTestrois', 'John', 'mrjohntrois@orange.fr', 'mrtestrois', 'john', 'client')
");


    $this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (1,'peugeot', '208', 'location', 'disponible', NULL)");
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
    $this->assertIsNumeric($res_enreg_command);

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
