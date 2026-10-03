<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_cnxn.php';

class ConnexUserTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $_SESSION = [];
        $_POST = [];


        $port = getenv('DB_TEST_PORT') ?: '3307';
        $user = getenv('DB_TEST_USER') ?: 'root';
        $password = getenv('DB_TEST_PASSWORD') ?: '';

        $this->pdo = new PDO("mysql:host=127.0.0.1;port=$port;dbname=locachat_test;charset=utf8mb4", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


   //néttoyage des tables
    $this->pdo->exec("DELETE FROM table_statu_command");
    $this->pdo->exec("DELETE FROM documents_upload");
    $this->pdo->exec("DELETE FROM table_commandes");
    $this->pdo->exec("DELETE FROM vehicule");
    $this->pdo->exec("DELETE FROM users");



        $hash_pwd = password_hash('Gioisac1$', PASSWORD_DEFAULT);

        $this->pdo->exec("
INSERT INTO users(id, numero_client, nom, prenom, pseudo, email, pwd_hash, role) VALUES
(1,'user1', 'client', 'John', 'email1.jas@orange.fr', 'mrclient', '$hash_pwd', 'client'),
(2,'user2', 'client', 'John', 'email.jas@orange.fr', 'mrclients', '$hash_pwd', 'admin')
");

    }

    public function testSiChampVide()
    {
        $_POST['email'] = '';
        $_POST['pwd'] = '';

        $res_cnxn = ConnexUser($this->pdo, '', '');

        $this->assertFalse($res_cnxn['success']);
        $this->assertEquals('Veuillez remplir tous les champs', $res_cnxn['message']);
    }

    public function testSiUserNonOK()
    {
        $_POST['email'] = 'monsieuruser@orange.fr';
        $_POST['pwd'] = 'Gioisac1$';

        $res_cnxn = ConnexUser($this->pdo, '', '');

        $this->assertFalse($res_cnxn['success']);
        $this->assertEquals('identifiants incorrects', $res_cnxn['message']);
    }

    public function testSiPwdNOK()
    {
        $_POST['email'] = 'monsieuruser@orange.fr';
        $_POST['pwd'] = 'Gioisac1$OIUT';

        $res_cnxn = ConnexUser($this->pdo, '', '');

        $this->assertFalse($res_cnxn['success']);
        $this->assertEquals('identifiants incorrects', $res_cnxn['message']);
    }


    public function testSiAdminOK()
    {
        $_POST['email'] = 'email.jas@orange.fr';
        $_POST['pwd'] = 'Gioisac1$';

        $res_cnxn = ConnexUser($this->pdo, '', '');

        $this->assertTrue($res_cnxn['success']);
        $this->assertEquals('dashboard_admin.php', $res_cnxn['redirect']);
        $this->assertEquals('admin', $_SESSION['role']);
    }


    public function testSiclientOK()
    {
        $_POST['email'] = 'email1.jas@orange.fr';
        $_POST['pwd'] = 'Gioisac1$';

        $res_cnxn = ConnexUser($this->pdo, '', '');

        $this->assertTrue($res_cnxn['success']);
        $this->assertEquals('index.php', $res_cnxn['redirect']);
        $this->assertEquals('client', $_SESSION['role']);
    }
}
