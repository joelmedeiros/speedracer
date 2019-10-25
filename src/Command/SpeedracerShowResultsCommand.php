<?php

namespace App\Command;

use App\Service\{FileManagement, Race};
use Symfony\Component\Console\{
    Command\Command,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface,
    Style\SymfonyStyle
};

class SpeedracerShowResultsCommand extends Command
{
    protected static $defaultName = 'speedracer:show-results';

    protected function configure()
    {
        $this
            ->setDescription('From a log file, show the result of a race')
            ->addArgument('file', InputArgument::REQUIRED, 'File path');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $file = $input->getArgument('file');

        $fileManagement = new FileManagement($file);
        $data = $fileManagement->read();

        /** @var \ArrayObject $result */
        $result = (new Race($data))->getResults();

        $io->table(['position', 'id', 'name', 'laps', 'total_time', 'avg_speed'], $result);
    }
}
