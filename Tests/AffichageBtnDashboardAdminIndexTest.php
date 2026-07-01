<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonctions_index.php';

class AffichageBtnDashboardAdminIndexTest extends TestCase

{
protected function setUp(): void
{

    $_SESSION = [];
}
//test de vérifcation d'affichage du bouton dashboard admin
public function testAffBtnDashboardAdmin()
{
$_SESSION['role'] ='admin';

$affich_btn = AffichageBtnDashboardAdminIndex();

$this->assertStringContainsString('Dashboard Admin', $affich_btn);
$this->assertStringContainsString('dashboard_admin.php', $affich_btn);
}
//test de vérification de non affichage du bouton Dashboard Admin si c'est un client connecter
public function testAffBtnclient()
{
$_SESSION['role'] ='client';

$affich_btn = AffichageBtnDashboardAdminIndex();

$this->assertSame('', $affich_btn);
}

//test de vérification de non affichage du bouton Dashboard Admin si c'est un client non connecter
public function testAffBtnclientNonConnecter()
{

$affich_btn = AffichageBtnDashboardAdminIndex();

$this->assertSame('', $affich_btn);
}
}
?>