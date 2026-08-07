<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreCommandeTest extends TestCase
{
    public function testNbreCommande()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->exec(
            "

CREATE TABLE table_statu_command (
id INTEGER PRIMARY KEY AUTOINCREMENT,
code_status_command INTEGER)"
        );

        $pdo->exec("
INSERT INTO table_statu_command(code_status_command)
VALUES
(2),
(2),
(1)
");

        $res = NbreCommande($pdo, 2);
        $this->assertEquals(2, $res);
    }
}
?>
