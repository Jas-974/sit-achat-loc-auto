<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_achat.php';

class enregCommandVehiculeAchatTest extends TestCase
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

      //nétoyage des tables
      $this->pdo->exec("DELETE FROM table_statu_command");
      $this->pdo->exec("DELETE FROM documents_upload");
      $this->pdo->exec("DELETE FROM table_commandes");
      $this->pdo->exec("DELETE FROM vehicule");
      $this->pdo->exec("DELETE FROM users");

      //insertion données de test
      $this->pdo->exec("
INSERT INTO users(id, numero_client, nom, prenom,email, pseudo, pwd_hash, role)
VALUES
(4, 'TEST004', 'MrTeskat', 'John', 'mrjohnteskat@orange.fr', 'mrteskat', 'john', 'client')
");



      $this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (1,'peugeot', '208', 'achat', 'disponible', NULL)");
   }

   public function testBoutonNonCliquer(): void
   {

      $donnee_user = [
         "nom" => "Robert",
         "prenom" => "Jacques",
         "email" => "robert.jacques@orange.fr"
      ];

      $donnee_vehicule = [
         "id" => 1,
         "type_offre" => "achat"
      ];

      $res_enreg = enregCommandVehiculeAchat($this->pdo, $donnee_user, $donnee_vehicule, 4);
      $this->assertFalse($res_enreg);
   }

   //fonction test validation commande avec téléversement de document
   public function testCommandeAvecDocument(): void
   {
      $_POST["maj_status_command"] = "Réservation en cours";

      $this->pdo->exec("
INSERT INTO documents_upload (id, user_id, car_id, documents)
VALUES (1, 4, 1, 'uploads/test_document.pdf')
");

      $donnee_user = [
         "nom" => "Robert",
         "prenom" => "Jacques",
         "email" => "robert.jacques@orange.fr"
      ];

      $donnee_vehicule = [
         "id" => 1,
         "type_offre" => "achat"
      ];

      $command = enregCommandVehiculeAchat($this->pdo, $donnee_user, $donnee_vehicule, 4);

      $this->assertIsNumeric($command);
      $stmt = $this->pdo->query("SELECT * FROM table_commandes");
      $com = $stmt->fetch(PDO::FETCH_ASSOC);


      $this->assertEquals(4, $com["user_id"]);
      $this->assertEquals(1, $com["car_id"]);
      $this->assertEquals("achat", $com["order_type"]);
      $this->assertEquals("uploads/test_document.pdf", $com["documents"]);


      $stmt = $this->pdo->query("SELECT * FROM table_statu_command");
      $lestatus = $stmt->fetch(PDO::FETCH_ASSOC);


      $this->assertEquals($command, $lestatus["commande_id"]);
      $this->assertEquals("Robert", $lestatus["nom"]);
      $this->assertEquals("Jacques", $lestatus["prenom"]);
      $this->assertEquals("robert.jacques@orange.fr", $lestatus["email"]);
      $this->assertEquals("achat", $lestatus["type_offre"]);
      $this->assertEquals("Réservation en cours", $lestatus["status_command"]);

      $stmt = $this->pdo->query("SELECT COUNT(*) FROM documents_upload");
      $this->assertEquals(0, $stmt->fetchColumn());
   }
}
