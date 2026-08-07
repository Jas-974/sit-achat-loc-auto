<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class NbreUtilisateurInscritTest extends TestCase
{
    public function testNbreUtilisateurInscrit()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->exec(
            "

CREATE TABLE users (
id INTEGER PRIMARY KEY AUTOINCREMENT)"
        );

        $pdo->exec("
INSERT INTO  users(id)
VALUES
(NULL),
(NULL),
(NULL),
(NULL)
");

        $res = NbreUtilisateurInscrit($pdo);
        $this->assertEquals(4, $res);
    }
}
?>
