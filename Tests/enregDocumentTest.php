<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_espace_client.php';

class enregDocumentTest extends TestCase
{

    private PDO $pdo;

    protected function setUp(): void
    {
        $_FILES = [];

        $port = getenv('DB_TEST_PORT') ?: '3307';
        $user = getenv('DB_TEST_USER') ?: 'root';
        $password = getenv('DB_TEST_PASSWORD') ?: '';

        $this->pdo = new PDO("mysql:host=127.0.0.1;port=$port;dbname=locachat_test;charset=utf8mb4", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function testPasDeFichierSelectionner()
    {

        $_FILES = [];

        $res_enreg_doc = enregDocument($this->pdo);

        $this->assertEquals('Aucun fichier selectionné.', $res_enreg_doc);
    }


    // test si aucun fichier
    public function testErreurFichier()
    {


        $_FILES["document"] = [
            "name" => "fichier_test.pdf",
            "tmp_name" => "",
            "error" => 1
        ];

        $res_enreg_doc = enregDocument($this->pdo);

        $this->assertEquals('Aucun fichier selectionné.', $res_enreg_doc);
    }
}
