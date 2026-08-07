<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/dev/fonction_dashboard_administrateur.php';

class VerifNombreLogTest extends TestCase
{
    public function testVerifNombreLog()
    {

        //création d'un fichier tempraire
        $fichierTemp = tempnam(sys_get_temp_dir(), 'logTest');

        file_put_contents(
            $fichierTemp,
            "[2026-07-10 19:37:00] [INFO] Test du système de logs 1
[2026-07-10 19:40:00] [INFO] Test du système de logs 2
[2026-07-10 19:50:00] [INFO] Test du système de logs 3
[2026-07-10 19:55:00] [ERROR] Test du système de logs 4"
        );


        $res = VerifNombreLog($fichierTemp, "INFO");
        $this->assertSame(3, $res);
        //suppression du fichier
        unlink($fichierTemp);
    }

    public  function testFichierInexistant()
    {
        $res = VerifNombreLog("fichier_introuvable.log", "INFO");
        $this->assertSame(0, $res);
    }
}
