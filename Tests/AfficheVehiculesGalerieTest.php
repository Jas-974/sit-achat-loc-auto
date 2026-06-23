<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_catalogue_globale.php';

class AfficheVehiculesGalerieTest extends TestCase
{
public function testAffichGalerietest()
{

$vignette_galerie = [ 
    [
    "id" => 1,
    "image" => "images/peugeot1.png",
    "marque" => "Peugeot",
    "modele" => "208",
    "type_offre" => "location"
]
];
 ob_start();

 AfficheVehiculesGalerie($vehicules);

 $affich_html = ob_get_clean();

$this->assertStringContainsString("Peugeot", $affich_html);
$this->assertStringContainsString("208", $affich_html);
$this->assertStringContainsString("location", $affich_html);
$this->assertStringContainsString("images/peugeot1.png", $affich_html);
$this->assertStringContainsString("ndex_detail_voiture_location.php?id=1", $affich_html);

}
}
?>