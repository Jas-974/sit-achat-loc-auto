<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/index.php';

class AffichageBtnDashboardAdminIndexTest extends TestCase {
public function testAffichBtnDashBoardAdminOKIndex(){
$_SESSION["role"] ="admin";
$affichage = AffichageBtnDashboardAdminIndex();
$this->assertStringContainsString("Dashboard Admin", $affichage);
}

public function testAffichBtnDashBoardAdminNOKIndex(){
$_SESSION["role"] ="client";
$affichage = AffichageBtnDashboardAdminIndex();
$this->assertStringNotContainsString("Créer un compte", $affichage);
}
}
?>

