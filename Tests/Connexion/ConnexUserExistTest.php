<?php

use PHPUnit\Framework\TestCase;

class ConnexUserExistTest extends TestCase
{

 private PDO $pdo;
// initialiser la table
    public function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');

        $this->pdo->exec("
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                pseudo TEXT,
                email TEXT,
                pwd_hash TEXT,
                role TEXT
            )
        ");
// création des données
        $this->pdo->exec("
            INSERT INTO users (pseudo, email, pwd_hash, role)
            VALUES ('jas', 'jas@orange.com', 'h256528123', 'user')
        ");
    }

    //fonction du test
    public function testUserExistTest()
    {
    $identif = 'jas';
//a tester
    $sql = "SELECT id, pseudo, email, pwd_hash, role
            FROM users
            WHERE email = :id OR pseudo = :id
            LIMIT 1";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([
        ":id" => $identif
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //les tests de vérification si les colones
    $this->assertNotFalse($user);

    $this->assertArrayHasKey('id', $user);

    $this->assertArrayHasKey('pseudo', $user);

    $this->assertArrayHasKey('email', $user);

    $this->assertArrayHasKey('pwd_hash', $user);

    $this->assertArrayHasKey('role', $user);
}

}