<?php

use PHPUnit\Framework\TestCase;

class ConnexMessageTest extends TestCase
{
    public function testConnexObligatoire()
    {
        $_GET["message"] = "connexion_obligatoire";

   $affiche ="";

        if (
            isset($_GET["message"]) &&
            $_GET["message"] === "connexion_obligatoire"
        ) {
            $affiche = "Veuillez vous connecter pour accéder à votre espace client.";
        }


        $this->assertEquals("Veuillez vous connecter pour accéder à votre espace client.", $affiche);
    }

    public function testMessageAbsConnexion()
    {
        $_GET["message"] = "";

$affiche ="";
        if (
            isset($_GET["message"]) &&
            $_GET["message"] === "connexion_obligatoire"
        ) {
            $affiche = "<p>Veuillez vous connecter pour accéder à votre espace client.</p>";
        }

       $this->assertEquals("", $affiche);

    }
}