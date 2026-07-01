<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_espace_client.php';

class AffichageDeLaRubriqueCommandTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {



        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("

CREATE TABLE table_statu_command (
id INTEGER PRIMARY KEy,
nom TEXT, 
prenom TEXT, 
type_offre TEXT, 
status_command TEXT, 
email TEXT,
`date` TEXT, 
numero_command TEXT, 
code_status_command TEXT)
");

        $this->pdo->exec("
INSERT INTO table_statu_command (id, nom, prenom, type_offre, status_command, email, `date`, numero_command, code_status_command ) VALUES
(1,'Monsieur', 'Test', 'location', 'Réservation en cours', 'tes1@orange.fr', '2026-05-09' , 'CMD2026', '3'),
(2,'Mons', 'Jean', 'achat', 'Commande Validée', 'tes2@orange.fr', '2026-05-09' , 'CMD2030', '2')
");
    }

    public function testAffichCommandAvecEmail()
    {

        $res_affich_command = AffichageDeLaRubriqueCommand($this->pdo, 'tes1@orange.fr');

        $this->assertCount(1, $res_affich_command);
        $this->assertEquals('Monsieur', $res_affich_command[0]["nom"]);
        $this->assertEquals('Test', $res_affich_command[0]["prenom"]);
        $this->assertEquals('CMD2026', $res_affich_command[0]["numero_command"]);
        $this->assertEquals('tes1@orange.fr', $res_affich_command[0]["email"]);
    }
}
