<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreVehiculeDisponibleTest extends TestCase
{
    public function testNbreVehiculeDisponible()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->exec(
            "

CREATE TABLE vehicule (
id INTEGER PRIMARY KEY AUTOINCREMENT,
statut TEXT)"
        );

        $pdo->exec("
INSERT INTO vehicule(statut)
VALUES
('disponible'),
('disponible'),
('reserve')
");

        $res = NbreVehiculeDisponible($pdo, "disponible");
        $this->assertEquals(2, $res);
    }
}
?>