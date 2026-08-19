<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_espace_client.php';

class enregDocumentTest extends TestCase
{


    protected function setUp(): void
    {
        $_FILES =[];
    }

    public function testPasDeFichierSelectionner()
    {
        
    $pdo = new PDO('sqlite::memory:');


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$_FILES = [];


        $res_enreg_doc = enregDocument($pdo);

        $this->assertEquals('Aucun fichier selectionné.', $res_enreg_doc);
    }

    
// test si aucun fichier
public function testErreurFichier()
{

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 $_FILES["document"] = [
    "name" => "fichier_test.pdf",
    "tmp_name" => "",
    "error" => 1
 ];

        $res_enreg_doc = enregDocument($pdo);

        $this->assertEquals('Aucun fichier selectionné.', $res_enreg_doc);


}
}

?>