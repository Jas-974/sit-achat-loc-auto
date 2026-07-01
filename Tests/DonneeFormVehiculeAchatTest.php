<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/gPostvalue.php';
require_once __DIR__ . '/../src/dev/fonction_insert_achat_admin.php';

class DonneeFormVehiculeAchatTest extends TestCase
{

public function testrecupDonneeFormVehiculeAchat()
{

$_SERVER["REQUEST_METHOD"] = "POST";

$_POST = [
"marque" => "BMW",
"modele" => "Série 6",
"annee" => "2023",
"kilometrage" => "50000",
"boite" => "manuel",
"puissance" => "120 CH",
"carburant" => "Essence",
"couleur" => "Rouge",
"type_offre" => "achat",
"prix" => "25000",
"statut" => "Disponible",
"description" => "Confort premium, GPS intégré, faible kilométrage",
"apport" => "3000",
"loyer_mois" => "250"
];

$res_recup = recupDonneeFormVehiculeAchat();

$this->assertEquals("BMW", $res_recup["marque"]);
$this->assertEquals("Série 6", $res_recup["modele"]);
$this->assertEquals("2023", $res_recup["annee"]);
$this->assertEquals("25000", $res_recup["prix"]);
$this->assertEquals("achat", $res_recup["type_offre"]);


}

}
?>