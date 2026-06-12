<?php

namespace App\Command\App;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:build',
    description: 'Build assets',
)]
class BuildCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $commands = [
            'importmap:install',
            'asset-map:compile',
            'cache:clear',
        ];

        foreach ($commands as $commandName) {
            $command = $this->getApplication()?->find($commandName);

            if (!$command) {
                $io->error(sprintf('Command "%s" not found', $commandName));

                return Command::FAILURE;
            }

            $exitCode = $command->run(
                new ArrayInput([]),
                $output
            );

            if ($exitCode !== Command::SUCCESS) {
                return $exitCode;
            }
        }

        $io->success('Build completed');

        return Command::SUCCESS;
    }
}
