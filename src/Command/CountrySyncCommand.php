<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\CountrySyncService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CountrySyncCommand extends Command
{
    public function __construct(
        private readonly CountrySyncService $countrySyncService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('countries:sync');
        $this->setDescription('Synchronize the countries from the REST Countries API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Synchronizing countries from REST Countries API');

        try {
            $this->countrySyncService->sync();
            $io->success('Countries synchronized successfully');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Error synchronizing countries: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}