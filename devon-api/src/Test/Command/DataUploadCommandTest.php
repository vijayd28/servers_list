<?php


namespace App\Test\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * Class DataUploadCommandTest
 * @package App\Test\Command
 */
class DataUploadCommandTest extends KernelTestCase
{
    /**
     * Test the command
     */
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('servers:data-upload');
        $commandTester = new CommandTester($command);
        $commandTester->execute();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Username: Wouter', $output);
    }
}