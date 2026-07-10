<?php
// fonction des gestion de log
function GestionLog(string $type_log, string $message): void
{

$dossier = __DIR__ . "/logs";

if (!is_dir($dossier)) {
mkdir($dossier, 0755, true);
}

$fichier = $dossier . "/app.log";
$date = date("Y-m-d H:i:s");

//ecriture de la ligne de log
$ligne = "[$date] [$type_log] $message" . PHP_EOL;
file_put_contents($fichier, $ligne, FILE_APPEND);

}

//fonction gestion des alertes
function GestionAlerting(string $message): void
{

$dossier = __DIR__ . "/logs";

if (!is_dir($dossier)) {
mkdir($dossier, 0755, true);
}
$fichier = $dossier . "/alerting.log";
$date = date("Y-m-d H:i:s");

//ecriture de la ligne
$ligne = "[$date] [ALERTE] $message" . PHP_EOL;
file_put_contents($fichier, $ligne, FILE_APPEND);
}

?>