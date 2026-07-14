<?php

$envFile = dirname(__DIR__, 2) . '/.env';

if (!is_file($envFile)) {
    throw new RuntimeException('Le fichier .env est introuvable.');
}

$env = parse_ini_file($envFile, false, INI_SCANNER_RAW);

if ($env === false) {
    throw new RuntimeException('Impossible de lire le fichier .env.');
}

// Variables qui doivent exister et ne pas être vides
foreach (['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER'] as $key) {
    if (!isset($env[$key]) || trim($env[$key]) === '') {
        throw new RuntimeException(
            "Variable manquante ou vide dans .env : $key"
        );
    }
}

// Le mot de passe doit exister, mais peut être vide en local avec XAMPP
if (!array_key_exists('DB_PASSWORD', $env)) {
    throw new RuntimeException(
        'Variable manquante dans .env : DB_PASSWORD'
    );
}

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $env['DB_HOST'],
    $env['DB_PORT'],
    $env['DB_NAME']
);

try {
    $pdo = new PDO(
        $dsn,
        $env['DB_USER'],
        $env['DB_PASSWORD'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    throw new RuntimeException(
        'Erreur de connexion à la base de données.',
        0,
        $e
    );
}