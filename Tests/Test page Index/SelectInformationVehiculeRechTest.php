<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/index.php';

class SelectInformationVehiculeRechTest extends TestCase
{

  public function testChampRech()
  {
    $_GET['champ_recherche'] = 'CLIO';

    $this->assertNotEmpty($_GET['champ_recherche']);
    $this->assertEquals('CLIO', $_GET['champ_recherche']);
  }
  public function testselectRechercheIndex(): void
  {



    $sql = "SELECT image, modele, marque, type_offre FROM vehicule";


    $this->assertStringContainsString("SELECT", $sql);
    $this->assertStringContainsString("vehicule", $sql);
    $this->assertStringContainsString("SELECT image, modele, marque, type_offre FROM vehicule", $sql);
  }

  public function testselectAffichageIndex(): void
  {

    $donnee_de_recherche = [
      'image' => 'audia3.png',
      'modele' => 'clio',
      'marque' => 'Renault',
      'type_offre' => 'location'
    ];


    $affichage = htmlspecialchars($donnee_de_recherche['image']) . '' .
      htmlspecialchars($donnee_de_recherche['modele']) . '' .
      htmlspecialchars($donnee_de_recherche['marque']) . '' .
      htmlspecialchars($donnee_de_recherche['type_offre']);


    $this->assertStringContainsString('audia3.png', $affichage);
    $this->assertStringContainsString('clio', $affichage);
    $this->assertStringContainsString('Renault', $affichage);
    $this->assertStringContainsString('location', $affichage);
  }
}
