<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreVehiculeReserveTest extends TestCase
{
    public function testNbreVehiculeReserve()
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
('reserve'),
('reserve')
");

        $res = NbreVehiculeReserve($pdo, "reserve");
        $this->assertEquals(2, $res);
    }
}
?>