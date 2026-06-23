<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonctions_index.php';

class AffichageBtnEspaceClientIndexTest extends TestCase

{

protected function setUp(): void
{
$_SESSION = [];

}
//si non connecté
public function testAffichBtnCreaCompteSiNonConnecter()
{
$affich_btn = AffichageBtnEspaceClientIndex();

$this->assertStringContainsString('Créer un compte', $affich_btn);
$this->assertStringContainsString('index_cnxn_creacompte.php', $affich_btn);
}

// Si connecté
public function testAffichBtnEspaceClientSiConnecter()
{
$_SESSION['user_id'] =  1;
$_SESSION['role'] =  'client';


$affich_btn = AffichageBtnEspaceClientIndex();

$this->assertStringContainsString('Espace client', $affich_btn);
$this->assertStringContainsString('espace_client_news.php', $affich_btn);
}
// Si admin
public function testAffichBtnEspaceClientSiAdmin()
{
$_SESSION['user_id'] =  1;
$_SESSION['role'] =  'admin';


$affich_btn = AffichageBtnEspaceClientIndex();

$this->assertSame('', $affich_btn);
}
}
?>