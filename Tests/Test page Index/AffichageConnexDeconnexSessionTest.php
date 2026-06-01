<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/index.php';

class AffichageConnexDeconnexSessionTest extends TestCase
{

    public function testAffichBtnConnexIndex()
    {
        // test si fermé affiche Connexion
        $_SESSION = [];
        $affichage = AffichagebtnConnexdeconnex();
        $this->assertStringContainsString("Connexion", $affichage);
    }

    public function testAffichBtnDeconnexIndex()
    {
        // test si fermé affiche Connexion
        $_SESSION["user_id"] = 1;
        $affichage = AffichagebtnConnexdeconnex();
        $this->assertStringContainsString("Déconnexion", $affichage);
    }
}
?>