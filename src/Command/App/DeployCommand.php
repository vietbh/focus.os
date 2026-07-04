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
    description: 'Deploy application for production.',
)]
final class DeployCommand extends Command
{
    public function __construct(
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $io = new SymfonyStyle(
            $input,
            $output,
        );

        $io->title('Focus OS Deployment');

        try {
            $this->composerInstall($io);

//            $this->runSymfonyCommand(
//                'doctrine:migrations:migrate',
//                [
//                    '--no-interaction' => true,
//                ],
//                $output,
//            );

            $this->runSymfonyCommand(
                'cache:clear',
                [
                    '--env' => 'prod',
                ],
                $output,
            );

            $this->runSymfonyCommand(
                'tailwind:build',
                [],
                $output,
            );
            $this->runSymfonyCommand(
                'asset-map:compile',
                [],
                $output,
            );

            $this->runSymfonyCommand(
                'cache:warmup',
                [
                    '--env' => 'prod',
                ],
                $output,
            );

            $this->resetOpcache($io);

            $io->success(
                'Deployment completed successfully.',
            );

            return Command::SUCCESS;
        } catch (\Throwable $exception) {
            $io->error(
                $exception->getMessage(),
            );

            return Command::FAILURE;
        }
    }

    private function composerInstall(
        SymfonyStyle $io,
    ): void {
        $io->section(
            'Composer Install',
        );

        $process = new Process([
            'composer',
            'install',
            '--no-dev',
            '--prefer-dist',
            '--optimize-autoloader',
            '--classmap-authoritative',
        ]);

        $process->setTimeout(
            3600,
        );

        $process->run(
            static function (
                string $type,
                string $buffer,
            ): void {
                echo $buffer;
            },
        );

        if (
            !$process->isSuccessful()
        ) {
            throw new \RuntimeException(
                $process->getErrorOutput(),
            );
        }
    }

    private function runSymfonyCommand(
        string $commandName,
        array $arguments,
        OutputInterface $output,
    ): void {
        $application =
            $this->getApplication();

        if ($application === null) {
            throw new \RuntimeException(
                'Console application not available.',
            );
        }

        $command =
            $application->find(
                $commandName,
            );

        $command->run(
            new ArrayInput(
                array_merge(
                    [
                        'command' => $commandName,
                    ],
                    $arguments,
                ),
            ),
            $output,
        );
    }

    private function resetOpcache(
        SymfonyStyle $io,
    ): void {
        if (
            !\function_exists(
                'opcache_reset',
            )
        ) {
            return;
        }

        opcache_reset();

        $io->success(
            'OPcache reset completed.',
        );
    }
}
