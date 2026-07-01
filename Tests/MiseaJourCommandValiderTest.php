<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class MiseaJourCommandValiderTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $_GET = [];


        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("

CREATE TABLE table_statu_command (
id INTEGER PRIMARY KEy,
status_command TEXT,
code_status_command TEXT)"
);


        $this->pdo->exec("
INSERT INTO table_statu_command(id, status_command, code_status_command)
VALUES
(1, 'Réservation en cours', '1')
");
    }


//test de validation dela commande coét admin
    public function testValideCommand()
    {

 $_GET["id"] =  1;
  $_GET["valider"] =  "valider";

  MiseaJourCommandValider($this->pdo);

  $stmt = $this->pdo->query("SELECT * FROM table_statu_command WHERE id = 1");
  $commande = $stmt->fetch(PDO::FETCH_ASSOC);

$this->assertEquals("Commande Validée , merci de proceder au paiement",
            $commande["status_command"]);

$this->assertEquals("2", $commande["code_status_command"]);


    }
    }
?>