<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Activity;
use stdClass;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

#[AsCommand(name: 'app:test')]
readonly class ObjectMapperCommand
{

    public function __construct(
        private ObjectMapperInterface $objectMapper,
    ) {}

    public function __invoke(OutputInterface $output): int
    {
        $output->writeln('<info>Convert StdClass into new Entity.</info>');

        $newActivity = new StdClass();
        $newActivity->name = 'Keyboard';
        $newActivity->sku = 'KB-001';

        $output->writeln('<info>Object:</info>');

        dump($this->objectMapper->map(
            source: $newActivity,
            target: Activity::class,
        ));

        dump($this->objectMapper->map(
            source: $newActivity,
            target: new Activity()
        ));

        return Command::SUCCESS;
    }
}
