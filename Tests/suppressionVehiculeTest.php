<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_suppression_vehiculeLoc.php';

class suppressionVehiculeTest extends TestCase
{
    private PDO $pdo;
    private array $vehicule;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');


        $this->pdo->exec("
        CREATE TABLE vehicule ( 
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        marque TEXT,
        modele TEXT,
        annee TEXT
        )
        ");

        $this->pdo->exec("
        INSERT INTO vehicule (marque, modele, annee) VALUES
        ('Renault','Clio','2020'),
('Peugeot', '208', '2021')
        ");
    }
    public function testSupprUnVehicule(): void
    {
        $this->assertTrue(
            supressionVehiculeLoc($this->pdo, [1])
        );
        //compte le nombre de ligne dans la table
        $res_suppVehicule = $this->pdo->query('SELECT COUNT(*) FROM vehicule')->fetchColumn();

        $this->assertEquals(1, $res_suppVehicule);
    }

    public function testSupprDeuxVehicule(): void
    {
        $this->assertTrue(
            supressionVehiculeLoc($this->pdo, [1, 2])
        );
        //compte le nombre de ligne dans la table
        $res_suppVehicule = $this->pdo->query('SELECT COUNT(*) FROM vehicule')->fetchColumn();

        $this->assertEquals(0, $res_suppVehicule);
    }
}
?>