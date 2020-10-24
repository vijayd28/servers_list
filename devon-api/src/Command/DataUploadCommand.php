<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DataUploadCommand extends Command
{
    /**
     * @var string $defaultName
     */
    protected static $defaultName = 'servers:data-upload';

    /**
     * To configure command details
     */
    protected function configure()
    {
        $this
            ->setDescription('To upload server data from excel to database.')
            ->setHelp('This command allows you to upload excel data to database...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ... put here the code to run in your command

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }
}