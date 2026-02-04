<?php

declare(strict_types=1);

namespace App\Dto\Command4;

use App\Dto\Interface\ResponseDto;
use Symfony\Component\ObjectMapper\Attribute\Map;

final readonly class ActivityResponseDto implements ResponseDto
{
    public function __construct(
        public string $name,

        #[Map(target: UserResponseDto::class)]
        public array $users,

        public int $elapsedTime,

        public string $deviceName,
    ) {}
}
