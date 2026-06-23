<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/gPostvalue.php';
require_once __DIR__ . '/../../src/dev/fonction_insert_location_admin.php';

class VerifFormChampsVideLocTest extends TestCase
{

    public function testChampsRemplis(): void
    {
        $infoVehicule = [
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

        $this->assertFalse(verifChampsVide($infoVehicule));
    }



    public function testUnChampsVide(): void
    {
        $infoVehicule = [
            'marque' => 'Renault',
            'modele' => 'Clio',
            'annee' => '',
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



        $this->assertTrue(verifChampsVide($infoVehicule));
    }


    public function testTousLesChampsSontVide(): void
    {
        $infoVehicule = [
            'marque' => '',
            'modele' => '',
            'annee' => '',
            'boite' => '',
            'puissance' => '',
            'carburant' => '',
            'couleur' => '',
            'type_offre' => '',
            'statut' => '',
            'description' => '',
            'caution' => '',
            'prix_loc_jour' => '',
            'forfait_par_mois' => '',
        ];


        $this->assertTrue(verifChampsVide($infoVehicule));
    }
}
