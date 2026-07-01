<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_insert_location_admin.php';

class DonneeFormVehiculeAdminInsertLocationTest extends TestCase
{

    public function testrecupValeurChampsLocation(): void
    {
        $post = [
            "marque" => "BMW",
            "modele" => "Série 6",
            "annee" => "2023",
            "boite" => "manuel",
            "puissance" => "120 CH",
            "carburant" => "Essence",
            "couleur" => "Rouge",
            "type_offre" => "location",
            "statut" => "Disponible",
            "description" => "Confort premium, GPS intégré, faible kilométrage",
            "caution" => "500",
            "prix_loc_jour" => "25",
            "forfait_par_mois" => "750",
        ];

        $res_valeur = recupValeurChampsLocation($post);

        $this->assertEquals("BMW", $res_valeur["marque"]);
        $this->assertEquals("Série 6", $res_valeur["modele"]);
        $this->assertEquals("120 CH", $res_valeur["puissance"]);
    }
}
