<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\Command3\ActivityResponseDto;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

#[AsCommand(name: 'app:test-3')]
readonly class ObjectMapperCommand_3
{

    private const string API_RESPONSE = <<<JSON
   {
      "user":{
         "firstname":"Pietje",
         "lastname":"Janssen"
      },
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
        $output->writeln('<info>Convert JSON with User into DTO via ObjectMapper</info>');

        $output->writeln('<info>JSON:</info>');

        dump(json_decode(self::API_RESPONSE));

        $output->writeln('<info>DTO:</info>');

        dump(
            $this->objectMapper->map(
                source: json_decode(self::API_RESPONSE),
                target: ActivityResponseDto::class,
            )
        );

        return Command::SUCCESS;
    }
}
