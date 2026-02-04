<?php

declare(strict_types=1);

namespace App\Dto\Command3;

use App\Dto\Interface\ResponseDto;
use stdClass;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(source: stdClass::class)]
final readonly class UserResponseDto implements ResponseDto
{
    public function __construct(
        public string $firstname,

        public string $lastname,
    ) {}
}
