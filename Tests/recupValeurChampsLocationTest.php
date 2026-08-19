<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_insert_location_admin.php';

class recupValeurChampsLocationTest extends TestCase
{
    // verifie si tous les champs sont renseigné
public function testRecupValeurChampsLocationTousLesChamps(): void
{
$post = [
    "marque" => " Peugeot ",
        "modele" => " 208 ",
        "annee" => " 2022 ",
        "boite" => " Manuelle ",
        "puissance" => " 110 ",
        "carburant" => " Essence ",
        "couleur" => " Rouge ",
        "type_offre" => " location ",
        "statut" => " disponible ",
        "description" => " SUV ",
        "caution" => " 1000 ",
        "prix_loc_jour" => " 120 ",
        "forfait_par_mois" => " 2500 "
];

$res = recupValeurChampsLocation($post);

        $this->assertSame("Peugeot", $res["marque"]);
        $this->assertSame("208", $res["modele"]);
        $this->assertSame("2022", $res["annee"]);
        $this->assertSame("Manuelle", $res["boite"]);
        $this->assertSame("110", $res["puissance"]);
        $this->assertSame("Essence", $res["carburant"]);
$this->assertSame("Rouge", $res["couleur"]);
        $this->assertSame("location", $res["type_offre"]);
        $this->assertSame("disponible", $res["statut"]);
        $this->assertSame("SUV", $res["description"]);
        $this->assertSame("1000", $res["caution"]);
        $this->assertSame("120", $res["prix_loc_jour"]);
        $this->assertSame("2500", $res["forfait_par_mois"]);


}


public function testRecupValeurChampsLocationTousLesChampsVide(): void
{

$res = recupValeurChampsLocation([]);

        $this->assertSame("", $res["marque"]);
        $this->assertSame("", $res["modele"]);
        $this->assertSame("", $res["annee"]);
        $this->assertSame("", $res["boite"]);
        $this->assertSame("", $res["puissance"]);
        $this->assertSame("", $res["carburant"]);
        $this->assertSame("", $res["couleur"]);
        $this->assertSame("", $res["type_offre"]);
        $this->assertSame("", $res["statut"]);
        $this->assertSame("", $res["description"]);
        $this->assertSame("", $res["caution"]);
        $this->assertSame("", $res["prix_loc_jour"]);
        $this->assertSame("", $res["forfait_par_mois"]);


}

}
?>