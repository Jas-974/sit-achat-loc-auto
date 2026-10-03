<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_catalogue_globale.php';

class AffichagecatalogueVehiculeTest extends TestCase
{

private PDO $pdo;

protected function setUp(): void
{


//initialise la superglobale
$_GET = [];

  $port = getenv('DB_TEST_PORT') ?: '3307';
    $user = getenv('DB_TEST_USER') ?: 'root';
    $password = getenv('DB_TEST_PASSWORD') ?: '';

    $this->pdo = new PDO("mysql:host=127.0.0.1;port=$port;dbname=locachat_test;charset=utf8mb4", $user, $password);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 //néttoyage des tables
    $this->pdo->exec("DELETE FROM table_statu_command");
    $this->pdo->exec("DELETE FROM documents_upload");
    $this->pdo->exec("DELETE FROM table_commandes");
    $this->pdo->exec("DELETE FROM vehicule");
    $this->pdo->exec("DELETE FROM users");




        $this->pdo->exec("
INSERT INTO vehicule(id, image, modele, marque, type_offre) VALUES
(1,'images/peugeot1.png', '208','Peugeot','location'),
(2,'images/renault1.png', 'clio','renault','achat')
");
    }


    public function testAffichageCatalogueGlobale()
    {

$_GET =[];

$catalogue = AffichagecatalogueVehicule($this->pdo);

$this->assertCount(2, $catalogue);
$this->assertEquals('Peugeot', $catalogue[0]['marque']);
$this->assertEquals('208', $catalogue[0]['modele']);


$this->assertEquals('renault', $catalogue[1]['marque']);
$this->assertEquals('clio', $catalogue[1]['modele']);
    }

      public function testAffichageCatalogueGlobaleAvecRech()
    {

$_GET['champ_recherche'] ='Peugeot';

$catalogue = AffichagecatalogueVehicule($this->pdo);

$this->assertCount(1, $catalogue);
$this->assertEquals('Peugeot', $catalogue[0]['marque']);
$this->assertEquals('208', $catalogue[0]['modele']);
$this->assertEquals('location', $catalogue[0]['type_offre']);
    }
}

?>
