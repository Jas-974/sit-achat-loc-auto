<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class MiseaJourCommandRejeterTest extends TestCase
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
status_command TEXT,
code_status_command TEXT)"
);

//execution de la requete
        $this->pdo->exec("
INSERT INTO table_statu_command(commande_id, status_command, code_status_command)
VALUES
(1, 'Réservation en cours', '1')
");
    }

public function testRejetCommand()
{
$_GET["id"] = 1;
$_GET["rejeter"] = "rejeter";

MiseaJourCommandRejeter($this->pdo);
 $stmt = $this->pdo->query("SELECT * FROM table_statu_command WHERE id = 1");
  $commande = $stmt->fetch(PDO::FETCH_ASSOC);

$this->assertEquals ("Commande Rejeter merci de vous rapprocher du Service Client au +262 46 78 24", $commande["status_command"]);
$this->assertEquals ("3", $commande["code_status_command"]);

}

}

?>