<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_location.php';

class enregCommandeVehiculeLocationAvecDocumentTest extends TestCase
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
(4, 'TEST002', 'MrTess', 'John', 'mrjohn@orange.fr', 'mrtess', 'john', 'client')
");



    $this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (1,'peugeot', '208', 'location', 'disponible', NULL)");

    //insertion documents
    $this->pdo->exec("INSERT INTO documents_upload (user_id, car_id, documents, created_at)
        VALUES
        (4, 1,  'uploads/documents_de_test.pdf', CURRENT_TIMESTAMP)");
  }

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

    $commande_id = enregCommandeVehiculeLocation(
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
    $this->assertEquals("uploads/documents_de_test.pdf", $commande["documents"]);

    $stmt = $this->pdo->query("SELECT COUNT(*) FROM documents_upload");
    $this->assertEquals(0, $stmt->fetchColumn());
  }
}
