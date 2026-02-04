<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\Command5\ActivityResponseDto;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

#[AsCommand(name: 'app:test-5')]
readonly class ObjectMapperCommand_5
{
    private const string API_RESPONSE = <<<JSON
   [
      {
          "name":"Title lorem ipsum",
          "elapsed_time":13592,
          "device_name":"Car"
      },
      {
          "name":"Title dolor sit amet",
          "elapsed_time":65291,
          "device_name":"Bike"
      }
]
JSON;

    public function __construct(
        private ObjectMapperInterface $objectMapper,
    ) {}

    public function __invoke(OutputInterface $output): int
    {
        $output->writeln('<info>Convert JSON with array of Activities into DTO via ObjectMapper.</info>');
        $output->writeln('<info>Possible solution, using foreach.</info>');

        $output->writeln('<info>JSON:</info>');

        dump(json_decode(self::API_RESPONSE));

        $output->writeln('<info>DTO:</info>');
        $result = [];
        if (is_array(json_decode(self::API_RESPONSE))) {
            foreach(json_decode(self::API_RESPONSE) as $source) {
                $result[] = $this->objectMapper->map(
                    source: $source,
                    target: ActivityResponseDto::class,
                );
            }
        }

        dump($result);

        return Command::SUCCESS;
    }
}
