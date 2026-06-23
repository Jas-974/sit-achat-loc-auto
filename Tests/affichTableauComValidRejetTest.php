<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_dashboard_administrateur.php';

class affichTableauComValidRejetTest extends TestCase
{

    public function testAffichTableau()
    {

        //constitution des données du tableau
        $app_command = [
            [
                "id" => 1,
                "nom" => "Monsieur",
                "prenom" => "Test",
                "numero_command" => "CMD001",
                "order_type" => "location",
                "status_command" => "Réservation en cours",
                "documents" => "document.pdf",
                "adate" => "2026-06-08"
            ]
        ];

        ob_start();

        affichTableauComValidRejet($app_command);

        $html = ob_get_clean();

        //vérif des informations dans $html
        $this->assertStringContainsString("Monsieur", $html);
        $this->assertStringContainsString("Test", $html);
        $this->assertStringContainsString("CMD001", $html);
        $this->assertStringContainsString("location", $html);
        $this->assertStringContainsString("Réservation en cours", $html);
        $this->assertStringContainsString("document.pdf", $html);
        $this->assertStringContainsString("2026-06-08", $html);
    }
}
