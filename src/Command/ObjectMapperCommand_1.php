<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\Command1\ActivityResponseDto;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

#[AsCommand(name: 'app:test-1')]
readonly class ObjectMapperCommand_1
{

    private const string API_RESPONSE = <<<JSON
   {
      "name":"Title lorem ipsum",
      "elapsed_time":13592,
      "device_name":"Car"
   }
JSON;

    public function __construct(
        private ObjectMapperInterface $objectMapper,
    ) {}

    public function __invoke(OutputInterface $output): int
    {
        $output->writeln('<info>Convert JSON into DTO via ObjectMapper</info>');

        $output->writeln('<info>JSON:</info>');

        dump(self::API_RESPONSE);

        $output->writeln('<info>DTO:</info>');

        $result = $this->objectMapper->map(
            source: json_decode(self::API_RESPONSE),
            target: ActivityResponseDto::class,
        );

        dump($result);

        return Command::SUCCESS;
    }
}
