<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreTotalVehiculeTest extends TestCase
{
    public function testNbreTotalVehicule()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->exec(
            "

CREATE TABLE vehicule (
id INTEGER PRIMARY KEY AUTOINCREMENT)"
        );

        $pdo->exec("
INSERT INTO vehicule DEFAULT VALUES;
INSERT INTO vehicule DEFAULT VALUES;
INSERT INTO vehicule DEFAULT VALUES;
INSERT INTO vehicule DEFAULT VALUES;
INSERT INTO vehicule DEFAULT VALUES;

");

        $res = NbreTotalVehicule($pdo);
        $this->assertEquals(5, $res);
    }
}
?>
