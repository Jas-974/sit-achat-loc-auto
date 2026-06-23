<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/gPostvalue.php';
require_once __DIR__ . '/../../src/dev/fonction_insert_achat_admin.php';

class VerifFormChampsVideTest extends TestCase
{

public function testChampsRemplis(): void
{
$champF = [
'marque' => 'Renault',
'modele' => 'Clio',
'annee' => '2020',
'kilometrage' => '45000',
'boite' => 'Manuelle',
'puissance' => '90',
'carburant' => 'Essence',
'couleur' => 'Blanc',
'type_offre' => 'achat',
'prix' => '9500',
'statut' => 'disponible',
'description' => 'Citadine économique et confortable.',
'apport' => '950',
'loyer_mois' => '158',
];

$this->assertFalse(verifChampVide($champF));
}



public function testUnChampsVide(): void
{
$champF = [
'marque' => 'Renault',
'modele' => 'Clio',
'annee' => '2020',
'kilometrage' => '',
'boite' => 'Manuelle',
'puissance' => '90',
'carburant' => 'Essence',
'couleur' => 'Blanc',
'type_offre' => 'achat',
'prix' => '9500',
'statut' => 'disponible',
'description' => 'Citadine économique et confortable.',
'apport' => '950',
'loyer_mois' => '158',
];

$this->assertTrue(verifChampVide($champF));
}


public function testTousLesChampsSontVide(): void
{
$champF = [
'marque' => '',
'modele' => '',
'annee' => '',
'kilometrage' => '',
'boite' => '',
'puissance' => '',
'carburant' => '',
'couleur' => '',
'type_offre' => '',
'prix' => '',
'statut' => 'disponible',
'description' => '',
'apport' => '',
'loyer_mois' => '',
];

$this->assertTrue(verifChampVide($champF));
}

}
    ?>