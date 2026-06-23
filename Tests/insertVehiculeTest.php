<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_insert_achat_admin.php';

class insertVehiculeTest extends TestCase
{
    private PDO $pdo;
    private array $vehicule;

    protected function setUp(): void
    {

        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("
        CREATE TABLE vehicule ( 
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        marque TEXT,
modele TEXT,
annee TEXT,
kilometrage TEXT,
boite TEXT,
puissance TEXT,
carburant TEXT,
couleur TEXT,
type_offre TEXT,
prix TEXT,
statut TEXT,
description TEXT,
apport TEXT,
loyer_mois TEXT
        )
");



$this->vehicule = [
"marque" => "Renault",
"modele" => "Clio",
"annee" => "2020",
"kilometrage" => "45000",
"boite" => "Manuelle",
"puissance" => "90",
"carburant" => "Essence",
"couleur" => "Blanc",
"type_offre" => "achat",
"prix" => "9500",
"statut" => "disponible",
"description" => "Citadine économique et confortable.",
"apport" => "950",
"loyer_mois" => "158",
];

    }

    public function testInsertvehicule()
    {

$this->assertTrue(insertVehicule($this->pdo, $this->vehicule));
//compte le nombre d'enreg dans la base
$res_vehicule = $this->pdo->query("SELECT COUNT (*) FROM vehicule")->fetchColumn();

$this->assertEquals(1, $res_vehicule);
    }
}
?>