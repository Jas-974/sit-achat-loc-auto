<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/index.php';

class AffichageBtnEspaceClientIndexTest extends TestCase
{
    public function testAffichBtnDashBoardAdminOKIndex()
    {

        $_SESSION = [];
        $affichage = AffichageBtnEspaceClientIndex();
        $this->assertStringContainsString("Créer un compte", $affichage);
    }

    public function testAffichBtnDashBoardAdminNOKIndex()
    {
        $_SESSION["user_id"] = 1;
        $_SESSION["role"] = "client";
        $affichage = AffichageBtnEspaceClientIndex();
        $this->assertStringContainsString("Espace client", $affichage);
    }
}
