<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonctions_index.php';

class RechVehiculeTest extends TestCase

{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');

//création de la table
        $this->pdo->exec("

CREATE TABLE vehicule (

id INTEGER PRIMARY KEy,
image TEXT,
marque TEXT,
modele TEXT,
type_offre TEXT,
statut
)
");

        //insertion des données de test dans la table
        $this->pdo->exec("
INSERT INTO vehicule VALUES
(1,'image_1', 'Renault','R5','achat','disponible'),
(2,'image_2', 'BMW','X1','location','disponible'),
(3,'image_3', 'Peugeot','207','location','disponible')
");
    }
// Si recherche vide
    public function testRetourneVideSiRechercheVide()
    {
        $resultat_recherche_vehicule = RechVehicule($this->pdo, '');
        $this->assertEmpty($resultat_recherche_vehicule);
  
    }
// si recherche OK
        public function testRetourneVehiculeSiRechercheNonVide()
    {
        $resultat_recherche_vehicule = RechVehicule($this->pdo, 'Renault');
        $this->assertCount(1, $resultat_recherche_vehicule);
   $this->assertEquals('Renault', $resultat_recherche_vehicule[0]['marque']);
    }

//Si vehicule non trouvé
       public function testRetourneVehiculeSiVehculeNonTrouver()
    {
        $resultat_recherche_vehicule = RechVehicule($this->pdo, 'LEXUS');
        $this->assertEmpty($resultat_recherche_vehicule);

    }
}




?>
