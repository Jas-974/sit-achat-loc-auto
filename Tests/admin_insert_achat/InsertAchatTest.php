<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/fonctions/gPostvalue.php";

class insertAchatTest extends TestCase
{

    public function testMarque()
    {

        $_POST["marque"] = " Peugeot ";

        $this->assertEquals("Peugeot", gPostValue("marque"));

    }

// autre champ de test
 public function testLoyermois()
    {

        $_POST["loyer_mois"] = " 433.17 ";

        $this->assertEquals("433.17", gPostValue("loyer_mois"));

    }
// autre champ de test
 public function testApport()
    {

        $_POST["apport"] = " 2100.00 ";

        $this->assertEquals("2100.00", gPostValue("apport"));

    }

}