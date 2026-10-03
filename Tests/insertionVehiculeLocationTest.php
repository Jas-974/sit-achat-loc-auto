<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_insert_location_admin.php';

class insertionVehiculeLocationTest extends TestCase
{
  private PDO $pdo;
  private array $infoVehicule;


  protected function setUp(): void
  {

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




    $this->infoVehicule = [

            'marque' => 'Renault',
            'modele' => 'Clio',
            'annee' => '2020',
            'boite' => 'Manuelle',
            'puissance' => '90',
            'carburant' => 'Essence',
            'couleur' => 'Blanc',
            'type_offre' => 'location',
            'statut' => 'disponible',
            'description' => 'Citadine économique et confortable.',
            'caution' => '500',
            'prix_loc_jour' => '35',
            'forfait_par_mois' => '700',
    ];
  }

  public function testInsertVehiculeLoc(): void
  {

$this->assertTrue(insertionVehiculeLocation($this->pdo, $this->infoVehicule));

$res_veh = $this->pdo->query("SELECT COUNT(*) FROM vehicule")->fetchColumn();

$this->assertEquals(1, $res_veh);

  }
}

?>