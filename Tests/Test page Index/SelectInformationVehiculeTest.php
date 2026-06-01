<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/index.php';

class SelectInformationVehiculeTest extends TestCase {

public function testselectInfoIndex(): void{



$sql = "SELECT id, image, marque, modele, type_offre, statut FROM vehicule LIMIT 5";


$this->assertStringContainsString("SELECT", $sql);
$this->assertStringContainsString("vehicule", $sql);
$this->assertStringContainsString("LIMIT 5", $sql);
$this->assertStringContainsString("SELECT id, image, marque, modele, type_offre, statut FROM vehicule LIMIT 5", $sql);

}
}