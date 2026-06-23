<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/dev/fonction_commande_voiture_location.php';

class generationNumCommandTest extends TestCase
{
public function testGenerationNumDeLaCommand()
{

$num_command = generationNumCommand();

$this->assertStringStartsWith('CMD', $num_command);
$this->assertEquals(15, strlen($num_command));
$this->assertMatchesRegularExpression('/^CMD\d{12}$/', $num_command);

}
}
    ?>