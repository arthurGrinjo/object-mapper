<?php

declare(strict_types=1);

namespace App\Dto\Command4;

use App\Dto\Interface\ResponseDto;

final readonly class UserResponseDto implements ResponseDto
{
    public function __construct(
        public string $firstname,

        public string $lastname,
    ) {}
}
