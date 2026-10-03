<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_achat.php';

class majStatusVehiculeReserveAchatTest extends TestCase
{

    private PDO $pdo;

    protected function setUp(): void
    {

        $_POST = [];

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


        $this->pdo->exec("INSERT INTO vehicule (id, marque, modele, type_offre, statut, status_command)
        VALUES
        (1,'peugeot', '208', 'achat', 'disponible', 'aucune')");
    }

    //test bouton non cliqué donc pas de mise a jours
    public function testBoutonNonCliquer(): void
    {

        majStatusVehiculeReserveAchat($this->pdo);

        $stmt = $this->pdo->query("SELECT status_command, statut FROM vehicule WHERE id = 1");
        $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals("aucune", $vehicule["status_command"]);
        $this->assertEquals("disponible", $vehicule["statut"]);
    }

    //test misea ajours vehicule en reservé
    public function testBoutonCliquer(): void
    {
        $_POST["id"] =  1;

        $_POST["maj_status_command"] = "Réservation en cours";

        majStatusVehiculeReserveAchat($this->pdo);

        $stmt = $this->pdo->query("SELECT status_command, statut FROM vehicule WHERE id = 1");
        $vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals("Réservation en cours", $vehicule["status_command"]);
        $this->assertEquals("reserve", $vehicule["statut"]);
    }
}
