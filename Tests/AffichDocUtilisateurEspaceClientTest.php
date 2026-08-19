<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_espace_client.php';

class AffichDocUtilisateurEspaceClientTest extends TestCase
{


    public function testAffichDocUtilisateurEspaceClient(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec("
        CREATE TABLE table_commandes ( id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        documents TEXT,
        adate TEXT)
        ");

        $pdo->exec("
        INSERT INTO table_commandes
        (user_id, documents, adate)
        VALUES
        (4,'upload/doc1.pdf', '2026-08-10 10:00:00'),
         (4,'upload/doc2.pdf', '2026-08-12 10:00:00'),
          (4,'upload/doc3.pdf', '2026-08-13 10:00:00'),
           (4,NULL, '2026-08-14 10:00:00'),
            (5,'upload/doc5.pdf', '2026-08-15 10:00:00')
        ");


        $res =  AffichDocUtilisateurEspaceClient($pdo, 4);

        $this->assertCount(3, $res);
        $this->assertSame('upload/doc3.pdf', $res[0]['documents']);
        $this->assertSame('upload/doc2.pdf', $res[1]['documents']);
         $this->assertSame('upload/doc1.pdf', $res[2]['documents']);
    }
}
