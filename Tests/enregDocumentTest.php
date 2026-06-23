<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_espace_client.php';

class enregDocumentTest extends TestCase
{

    protected function setUp(): void
    {
        $_FILES =[];
    }

    public function testPasDeFichierSelectionner()
    {
        $conn = new mysqli();

        $res_enreg_doc = enregDocument($conn);

        $this->assertEquals('Aucun fichier selectionné.', $res_enreg_doc);
    }

public function testErreurFichier()
{

 $conn = new mysqli();

 $_FILES["document"] = [
    "name" => "fichier_test.pdf",
    "tmp_name" => "",
    "error" => 1
 ];

        $res_enreg_doc = enregDocument($conn);

        $this->assertEquals('Aucun fichier selectionné.', $res_enreg_doc);


}
}

?>