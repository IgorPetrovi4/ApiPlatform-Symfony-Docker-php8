<?php

namespace App\Command;

use App\Service\ApiContentReceiver;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'api:import',
    description: 'This command to import file .json.
    Run bin/console api:import api_url [GET]'
)]
class CategoryImportCommand extends Command
{
    public function __construct(
        private readonly ?ApiContentReceiver $apiContentReceiver,
    )
    {parent::__construct();}

    protected function configure(): void
    {
        $this
            ->addArgument('api_url', InputArgument::OPTIONAL,
                'GET url https://localhost/api/products or https://localhost/api/categories'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $api_url = $input->getArgument('api_url');
        $content = $this->apiContentReceiver->getApiContent($api_url);
        $io->note($content);
        $io->success('Your file is ready, click the link  ' . $this->apiContentReceiver->getfilePath());
        return Command::SUCCESS;
    }

}
