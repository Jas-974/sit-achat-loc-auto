<?php

use PHPUnit\Framework\TestCase;

class ConnexHashPwdTest extends TestCase
{

public function testHashPwd(): void
{
     $pwd = 'Gioisac1$';

    $user = [
        'pwd_hash' => password_hash('Gioisac1$', PASSWORD_DEFAULT)
    ];

    $verif = password_verify(
        $pwd,
        $user['pwd_hash']
    );

    $this->assertTrue($verif);
}
public function tearDown(): void
   {
       // réinitilise
$pwd = null;
$user = null;


   }
}