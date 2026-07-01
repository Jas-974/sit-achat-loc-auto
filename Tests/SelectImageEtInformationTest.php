<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonctions_index.php';

class SelectImageEtInformationTest extends TestCase

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

    public function testRetournInfoVehicule()
    {
        $infovehicule = SelectImageEtInformation($this->pdo);
        $this->assertIsArray($infovehicule);
        $this->assertCount(3, $infovehicule);
        $this->assertEquals('Peugeot', $infovehicule[2]['marque']);
        $this->assertEquals('Renault', $infovehicule[0]['marque']);
        $this->assertEquals('location', $infovehicule[1]['type_offre']);
    }
}




?>










}