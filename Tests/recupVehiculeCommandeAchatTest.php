<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_achat.php';

class recupVehiculeCommandeAchatTest extends TestCase
{

    private PDO $pdo;

    protected function setUp(): void
    {

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
    }

    //test Id vehicule manquant
    public function testIdManquant(): void
    {
        $resultat_id = recupVehiculeCommandeAchat($this->pdo);

        $this->assertFalse($resultat_id["success"]);
        $this->assertEquals("ID manquant", $resultat_id["message"]);
    }

    // test veuhicule non trouvé
    public function testVehiculeIntrouvable(): void
    {
        $_GET["id"] = 60;

        $resultat_vehicule = recupVehiculeCommandeAchat($this->pdo);

        $this->assertFalse($resultat_vehicule["success"]);
        $this->assertEquals("Véhicule introuvable", $resultat_vehicule["message"]);
    }

    //test vehicule trouver
    public function testVehiculeTrouver(): void
    {
        $_GET["id"] = 1;

        $this->pdo->exec("
INSERT INTO vehicule (
id, marque, modele, annee, kilometrage, boite, carburant, type_offre, prix, statut, status_command, image, loyer_mois, apport )
VALUES (1, 'Peugeot', '208', '2020', '50000', 'Manuelle','Essence', 'achat', '12000', 'disponible', 'aucune',
'images/peugeot.png', '300', '1000')
 ");

        $resultat_vehicule = recupVehiculeCommandeAchat($this->pdo);

        $this->assertTrue($resultat_vehicule["success"]);
        $this->assertEquals("Peugeot", $resultat_vehicule["vehicule"]["marque"]);
        $this->assertEquals("208", $resultat_vehicule["vehicule"]["modele"]);
        $this->assertEquals("achat", $resultat_vehicule["vehicule"]["type_offre"]);
        $this->assertEquals("12000.00", $resultat_vehicule["vehicule"]["prix"]);
    }
}
