<?php

declare(strict_types=1);

namespace App\Command;

use Minishlink\WebPush\VAPID;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:generate-vapid',
    description: 'Generate a new VAPID key pair.',
)]
final class GenerateVapidKeysCommand extends Command
{
    /**
     * @throws \ErrorException
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output,
    ): int {
        $keys = VAPID::createVapidKeys();

        $table = new Table($output);

        $table
            ->setHeaders([
                'Key',
                'Value',
            ])
            ->setRows([
                [
                    'WEB_PUSH_VAPID_PUBLIC_KEY',
                    $keys['publicKey'],
                ],
                [
                    'WEB_PUSH_VAPID_PRIVATE_KEY',
                    $keys['privateKey'],
                ],
            ]);

        $table->render();

        $output->writeln('');
        $output->writeln('<info>.env.local</info>');
        $output->writeln('');

        $output->writeln(sprintf(
            'WEB_PUSH_VAPID_PUBLIC_KEY=%s',
            $keys['publicKey'],
        ));

        $output->writeln(sprintf(
            'WEB_PUSH_VAPID_PRIVATE_KEY=%s',
            $keys['privateKey'],
        ));

        $output->writeln(
            'WEB_PUSH_VAPID_SUBJECT=https://focusos.app',
        );

        return Command::SUCCESS;
    }
}
