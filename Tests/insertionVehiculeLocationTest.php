<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_insert_location_admin.php';

class insertionVehiculeLocationTest extends TestCase
{
  private PDO $pdo;


  protected function setUp(): void
  {

    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->exec("
CREATE TABLE vehicule (
id INTEGER PRIMARY KEy,
marque TEXT,
modele TEXT,
annee TEXT,
boite TEXT,
puissance TEXT,
carburant TEXT,
couleur TEXT,
type_offre TEXT,
statut TEXT,
description TEXT,
caution TEXT,
prix_loc_jour TEXT,
forfait_par_mois TEXT
    )

");

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

$res_veh = $this->pdo->query("SELECT COUNT (*) FROM vehicule")->fetchColumn();

$this->assertEquals(1, $res_veh);

  }
}

?>