<?php

declare(strict_types=1);

namespace Martinandrasi\Hugmarket;

final readonly class Movie
{
    public function __construct(
        public string $title,
    ) {
    }
}
