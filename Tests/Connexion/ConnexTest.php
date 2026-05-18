<?php

use PHPUnit\Framework\TestCase;
// Test de validation des champs du formulaire
class ConnexTest extends TestCase
{
    public function testEmailEtPwdPost()
    {
        $_POST["email"] = "email.jas@orange.fr";
        $_POST["pwd"] = "Gioisac1$";

        if (isset($_POST["email"])) {
            $identif = trim($_POST["email"]);
        } else {
            $identif = "";
        }

        if (isset($_POST["pwd"])) {
            $pwd = trim($_POST["pwd"]);
        } else {
            $pwd = "";
        }

        $this->assertEquals("email.jas@orange.fr", $identif);
        $this->assertEquals("Gioisac1$", $pwd);
    }

    public function testEmailEtPwdPostVide()
    {
        $_POST = [];

        if (isset($_POST["email"])) {
            $identif = trim($_POST["email"]);
        } else {
            $identif = "";
        }

        if (isset($_POST["pwd"])) {
            $pwd = trim($_POST["pwd"]);
        } else {
            $pwd = "";
        }

        $this->assertEquals("", $identif);
        $this->assertEquals("", $pwd);
    }


// test de connexion
public function recupIdentifiant()
{
    return [
        'email' => trim($_POST['email'] ?? ''),
        'pwd' => trim($_POST['pwd'] ?? '')
    ];
}

}

