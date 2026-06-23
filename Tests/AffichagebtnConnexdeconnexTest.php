
<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonctions_index.php';

class AffichagebtnConnexdeconnexTest extends TestCase
{

    protected function setUp(): void
    {
$_SESSION = [];
    }


public function testAfficheConnexUtilisateurNonConnect()
{

$affich = AffichagebtnConnexdeconnex();

$this->assertStringContainsString('Connexion', $affich);
$this->assertStringContainsString('index_cnxn_creacompte.php', $affich);


}


public function testAfficheConnexUtilisateurConnect()
{
 $_SESSION['user_id'] = 1;
$affich = AffichagebtnConnexdeconnex();

$this->assertStringContainsString('Déconnexion', $affich);
$this->assertStringContainsString('logout.php', $affich);


}
}
?>

