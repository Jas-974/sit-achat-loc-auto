<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_commande_voiture_achat.php';

class majStatusVehiculeReserveAchatTest extends TestCase
{

    private PDO $pdo;

    protected function setUp(): void
    {

        $_POST = [];

        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("
CREATE TABLE vehicule (id INTEGER PRIMARY KEy,
status_command TEXT,
statut TEXT)
 ");

        $this->pdo->exec("
INSERT INTO vehicule (id, status_command, statut)
VALUES
(1,'aucune','disponible')
 ");
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
