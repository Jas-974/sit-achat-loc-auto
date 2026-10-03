<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonctions_index.php';

class RechVehiculeTest extends TestCase

{
    private PDO $pdo;

    protected function setUp(): void
    {
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


        //insertion des données de test dans la table
        $this->pdo->exec("
INSERT INTO vehicule (id, image, marque, modele, type_offre, statut)
VALUES
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
