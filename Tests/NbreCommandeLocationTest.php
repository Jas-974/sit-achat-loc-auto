<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreCommandeLocationTest extends TestCase
{
    public function testNbreCommandeLocation()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->exec(
            "

CREATE TABLE table_commandes (
id INTEGER PRIMARY KEY AUTOINCREMENT,
order_type TEXT)"
        );

        $pdo->exec("
INSERT INTO table_commandes(order_type)
VALUES
('location'),
('location'),
('achat')
");

        $res = NbreCommandeLocation($pdo, "location");
        $this->assertEquals(2, $res);
    }
}
?>
