<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreTotalCommandeTest extends TestCase
{
    public function testNbreTotalCommande()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->exec(
            "CREATE TABLE table_commandes (
id INTEGER PRIMARY KEY AUTOINCREMENT)"
        );

        $pdo->exec("
INSERT INTO table_commandes (id)
VALUES
(1),
(2),
(3)
");

        $res = NbreTotalCommande($pdo);
        $this->assertEquals(3, $res);
    }
}
?>
