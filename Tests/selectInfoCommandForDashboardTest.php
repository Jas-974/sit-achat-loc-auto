<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class selectInfoCommandForDashboardTest extends TestCase
{

 private PDO $pdo;

    protected function setUp(): void
    {
        $_GET = [];
// création de la table

        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("

CREATE TABLE table_statu_command (
id INTEGER PRIMARY KEy,
commande_id INTEGER,
numero_command TEXT,
status_command TEXT
)"
);

 $this->pdo->exec("
 CREATE TABLE users (
id INTEGER PRIMARY KEy,
nom TEXT,
prenom TEXT);
");

$this->pdo->exec("
 CREATE TABLE table_commandes (
id INTEGER PRIMARY KEy,
user_id INTEGER,
order_type TEXT,
documents TEXT,
adate TEXT);
");


$this->pdo->exec("
INSERT INTO users(id, nom, prenom)
VALUES
(1, 'Monsieur', 'Detest')
");

$this->pdo->exec("
INSERT INTO table_statu_command(id, commande_id, numero_command, status_command)
VALUES
(1, 10, 'CMD9875', 'Réservation en cours')
");


$this->pdo->exec("
INSERT INTO table_commandes (id, user_id, order_type, documents, adate)
VALUES
(10, 1, 'location', 'doc.pdf', '2026-06-08')
");
    }

public function testaffichageCommandDashboard(){

$res_info_command = selectInfoCommandForDashboard($this->pdo);

$this->assertCount(1, $res_info_command);

$this->assertEquals('Monsieur', $res_info_command[0]['nom']);
$this->assertEquals('Detest', $res_info_command[0]['prenom']);
$this->assertEquals('CMD9875', $res_info_command[0]['numero_command']);
$this->assertEquals('location', $res_info_command[0]['order_type']);

}
}
?>