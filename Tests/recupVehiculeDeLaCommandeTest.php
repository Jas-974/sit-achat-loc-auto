<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_location.php';

class recupVehiculeDeLaCommandeTest extends TestCase
{
  private PDO $pdo;


  protected function setUp(): void
  {

    $_GET = [];

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



    $this->pdo->exec("
INSERT INTO vehicule (id, marque, modele, annee, kilometrage, boite, carburant, type_offre, prix, statut, status_command, image, loyer_mois, apport, prix_loc_jour,forfait_par_mois, caution ) VALUES
(1, 'Peugeot', '208', '2020', '50000', 'Manuelle', 'Essence', 'location', '12000', 'disponible', 'aucune', 'image.jpg', '300', '1000', '40', '900', '500')
");
  }
  public function testIdManquant()
  {

    $_GET = [];

    $res_recup_vehicule  = recupVehiculeDeLaCommande($this->pdo);
    $this->assertFalse($res_recup_vehicule["success"]);
    $this->assertEquals("ID manquant", $res_recup_vehicule["message"]);
  }

  public function testVehculeNontrouve()
  {

    $_GET["id"] = 5;

    $res_recup_vehicule  = recupVehiculeDeLaCommande($this->pdo);

    $this->assertFalse($res_recup_vehicule["success"]);
    $this->assertEquals("Véhicule introuvable", $res_recup_vehicule["message"]);
  }

  public function testVehculeTrouve()
  {

    $_GET["id"] = 1;

    $res_recup_vehicule  = recupVehiculeDeLaCommande($this->pdo);

    $this->assertTrue($res_recup_vehicule["success"]);
    $this->assertEquals("Peugeot", $res_recup_vehicule["vehicule"]["marque"]);
    $this->assertEquals("208", $res_recup_vehicule["vehicule"]["modele"]);
    $this->assertEquals("location", $res_recup_vehicule["vehicule"]["type_offre"]);
    $this->assertEquals("2020", $res_recup_vehicule["vehicule"]["annee"]);
  }
}
