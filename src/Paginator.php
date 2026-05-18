<?php

declare(strict_types=1);

namespace Martinandrasi\Hugmarket;

use InvalidArgumentException;
use Martinandrasi\Hugmarket\PaginationResult;

/**
 * @template T
 */
final readonly class Paginator
{
    public function __construct(
        private int $perPage,
    ) {
        if ($this->perPage < 1) {
            throw new InvalidArgumentException(
                'Per page must be greater than 0.'
            );
        }
    }

    /**
     * @param array<T> $items
     *
     * @return PaginationResult<T>
     */
    public function paginate(
        array $items,
        int $page,
    ): PaginationResult {
        if ($page < 1) {
            throw new InvalidArgumentException(
                'Page must be greater than 0.'
            );
        }

        $totalItems = count($items);

        $totalPages = (int) ceil(
            $totalItems / $this->perPage
        );

        $offset = ($page - 1) * $this->perPage;

        $items = array_slice(
            $items,
            $offset,
            $this->perPage
        );

        return new PaginationResult(
            items: $items,
            currentPage: $page,
            perPage: $this->perPage,
            totalItems: $totalItems,
            totalPages: $totalPages,
        );
    }
}
