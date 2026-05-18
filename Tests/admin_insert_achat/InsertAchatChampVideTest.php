<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../src/fonctions/gPostvalue.php";

class InsertAchatChampVideTest extends TestCase
{

    public function testInsertAchatChampComplet()
    {

   $vehicule = [
    "Renault",
    "ClioV",
    "2020", 
    "45000", 
    "Manuelle",
    "90",
    "Diesel",
    "Noir", 
    "Achat", 
    "Disponible",    
    "Vehicule en bon etat",  
    "3000",     
    "250"   
   ];

        $this->assertTrue(champsVide($vehicule));

    }

 public function testInsertAchatChampManquant()
    {

   $vehicule = [
   "Renault",
    "ClioV",
    "2020", 
    "45000", 
    "",
    "90",
    "Diesel",
    "Noir", 
    "Achat", 
    "Disponible",    
    "Vehicule en bon etat",  
    "",     
    ""   
   ];

        $this->assertFalse(champsVide($vehicule));

    }
}