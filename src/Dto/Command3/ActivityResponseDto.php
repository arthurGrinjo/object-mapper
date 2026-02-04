<?php

declare(strict_types=1);

namespace App\Dto\Command3;

use App\Dto\Interface\ResponseDto;

final readonly class ActivityResponseDto implements ResponseDto
{
    public function __construct(
        public string $name,

        public UserResponseDto $user,

        public int $elapsedTime,

        public string $deviceName,
    ) {}
}
