<?php

namespace App\Command\App;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'app:deploy',
    description: 'Deploy application for production',
)]
class DeployCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Composer install production
        $io->section('Composer install');

        $process = new Process([
            'composer',
            'install',
            '--no-dev',
            '--optimize-autoloader',
        ]);

        $process->setTimeout(null);

        $process->run(function ($type, $buffer) use ($output) {
            $output->write($buffer);
        });

        if (!$process->isSuccessful()) {
            $io->error('Composer install failed.');
            return Command::FAILURE;
        }

        // Symfony commands
        $commands = [
            ['importmap:install'],
            ['asset-map:compile'],
            ['cache:clear', '--env' => 'prod'],
            ['cache:warmup', '--env' => 'prod'],
        ];

        foreach ($commands as $config) {
            $name = array_shift($config);

            $io->section(sprintf('Running %s', $name));

            $command = $this->getApplication()?->find($name);

            if (!$command) {
                $io->error(sprintf('Command "%s" not found.', $name));
                return Command::FAILURE;
            }

            $exitCode = $command->run(
                new ArrayInput($config),
                $output
            );

            if ($exitCode !== Command::SUCCESS) {
                return $exitCode;
            }
        }

        $io->success('Deploy completed successfully.');

        return Command::SUCCESS;
    }
}
