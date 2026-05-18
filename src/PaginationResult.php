<?php

declare(strict_types=1);

namespace Martinandrasi\Hugmarket;

/**
 * @template T
 */
final readonly class PaginationResult
{
    /** @var array<T> */
    public array $items;

    /**
     * @param array<T> $items
     */
    public function __construct(
        array $items,
        public int $currentPage,
        public int $perPage,
        public int $totalItems,
        public int $totalPages,
    ) {
        $this->items = $items;
    }
}
