<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_insert_achat_admin.php';

class insertVehiculeTest extends TestCase
{
    private PDO $pdo;
    private array $vehicule;

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




$this->vehicule = [
"marque" => "Renault",
"modele" => "Clio",
"annee" => "2020",
"kilometrage" => "45000",
"boite" => "Manuelle",
"puissance" => "90",
"carburant" => "Essence",
"couleur" => "Blanc",
"type_offre" => "achat",
"prix" => "9500",
"statut" => "disponible",
"description" => "Citadine économique et confortable.",
"apport" => "950",
"loyer_mois" => "158",
];

    }

    public function testInsertvehicule()
    {

$this->assertTrue(insertVehicule($this->pdo, $this->vehicule));
//compte le nombre d'enreg dans la base
$res_vehicule = $this->pdo->query("SELECT COUNT(*) FROM vehicule")->fetchColumn();

$this->assertEquals(1, $res_vehicule);
    }
}
?>