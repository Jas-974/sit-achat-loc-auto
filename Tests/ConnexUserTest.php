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


        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("

CREATE TABLE users (
id INTEGER PRIMARY KEy,
pseudo TEXT,
email TEXT,
pwd_hash TEXT,
role TEXT)
");

        $hash_pwd = password_hash('Gioisac1$', PASSWORD_DEFAULT);

        $this->pdo->exec("
INSERT INTO users(id, pseudo, email, pwd_hash, role) VALUES
(1,'user1', 'email1.jas@orange.fr','$hash_pwd','client'),
(2,'user2', 'email.jas@orange.fr','$hash_pwd','admin')
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
