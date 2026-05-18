<?php

use PHPUnit\Framework\TestCase;

class ConnexStatusChampTest extends TestCase
{
    public function testChampsVide()
    {
        $identif = "";
        $pwd = "";

        $result = ($identif === "" || $pwd === "");

        $this->assertTrue($result);
    }

    public function testEmailVide()
    {
        $identif = "";
        $pwd = "motdepasse";

        $result = ($identif === "" || $pwd === "");

        $this->assertTrue($result);
    }

    public function testMotpassVide()
    {
        $identif = "email.jas@orange.fr";
        $pwd = "";

        $result = ($identif === "" || $pwd === "");

        $this->assertTrue($result);
    }

    public function testChampsOk()
    {
        $identif = "email.jas@orange.fr";
        $pwd = "Gioisac1$";

        $result = ($identif === "" || $pwd === "");

        $this->assertFalse($result);
    }
}