<?php

declare(strict_types=1);

namespace App\Dto\Command6;

use App\Dto\Interface\ResponseDto;

final readonly class ActivityCollectionResponseDto implements ResponseDto
{
    public function __construct(
        public array $activities,
    ) {}
}
