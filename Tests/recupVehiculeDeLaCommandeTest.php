<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_commande_voiture_location.php';

class recupVehiculeDeLaCommandeTest extends TestCase
{
private PDO $pdo;


protected function setUp(): void {

$_GET = [];

  $this->pdo = new PDO('sqlite::memory:');
$this->pdo->exec("
CREATE TABLE vehicule (
id INTEGER PRIMARY KEy,
marque TEXT, 
modele TEXT, 
annee TEXT, 
kilometrage TEXT, 
boite, carburant TEXT, 
type_offre TEXT, 
prix TEXT, 
statut TEXT, 
status_command TEXT, 
image TEXT, 
loyer_mois TEXT, 
apport TEXT, 
prix_loc_jour TEXT,
forfait_par_mois TEXT, 
caution TEXT
)
");

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

$_GET["id"]= 5; 

$res_recup_vehicule  = recupVehiculeDeLaCommande($this->pdo);

$this->assertFalse($res_recup_vehicule["success"]);
$this->assertEquals("ID manquant", $res_recup_vehicule["message"]);

}

public function testVehculeTrouve()
{

$_GET["id"]= 1; 

$res_recup_vehicule  = recupVehiculeDeLaCommande($this->pdo);

$this->assertTrue($res_recup_vehicule["success"]);
$this->assertEquals("peugeot", $res_recup_vehicule["vehicule"]["marque"]);
$this->assertEquals("208", $res_recup_vehicule["vehicule"]["modele"]);
$this->assertEquals("location", $res_recup_vehicule["vehicule"]["type_offre"]);
$this->assertEquals("2020", $res_recup_vehicule["vehicule"]["annee"]);
}
}
?>