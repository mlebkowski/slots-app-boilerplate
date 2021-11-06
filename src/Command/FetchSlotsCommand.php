<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\SlotFetching\SlotsFetcher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchSlotsCommand extends Command
{
    protected static $defaultName = 'app:fetch-slots';

    private SlotsFetcher $slotsFetcher;

    public function __construct(SlotsFetcher $slotsFetcher)
    {
        parent::__construct();
        $this->slotsFetcher = $slotsFetcher;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->slotsFetcher->fetch();
        return Command::SUCCESS;
    }
}
