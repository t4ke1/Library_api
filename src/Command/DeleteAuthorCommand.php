<?php

namespace App\Command;

use App\Services\AuthorService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'DeleteAuthor',
    description: 'Delete author without books',
)]
class DeleteAuthorCommand extends Command
{
    public function __construct(
        private AuthorService $authorService
    )
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->authorService->deleteAuthorsWithOutBook()) {
            $output->writeln('Authors without books were deleted.');
            return Command::SUCCESS;
        } else {
            $output->writeln("Dont have authors without book.");
            return Command::FAILURE;
        }
    }
}
