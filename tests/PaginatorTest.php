<?php

declare(strict_types=1);

namespace Martinandrasi\Hugmarket\Tests;

use InvalidArgumentException;
use Martinandrasi\Hugmarket\Paginator;
use PHPUnit\Framework\TestCase;

final class PaginatorTest extends TestCase
{
    public function testItRejectsPerPageLessThanOne(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Per page must be greater than 0.');

        new Paginator(perPage: 0);
    }

    public function testItRejectsPageLessThanOne(): void
    {
        $paginator = new Paginator(perPage: 2);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Page must be greater than 0.');

        $paginator->paginate(
            items: ['a', 'b'],
            page: 0,
        );
    }

    public function testItPaginatesTheSecondPage(): void
    {
        $paginator = new Paginator(perPage: 2);

        $result = $paginator->paginate(
            items: ['a', 'b', 'c', 'd', 'e'],
            page: 2,
        );

        self::assertSame(['c', 'd'], $result->items);
        self::assertSame(2, $result->currentPage);
        self::assertSame(2, $result->perPage);
        self::assertSame(5, $result->totalItems);
        self::assertSame(3, $result->totalPages);
    }

    public function testItReturnsEmptyItemsForPageBeyondTheEnd(): void
    {
        $paginator = new Paginator(perPage: 2);

        $result = $paginator->paginate(
            items: ['a', 'b', 'c'],
            page: 3,
        );

        self::assertSame([], $result->items);
        self::assertSame(3, $result->currentPage);
        self::assertSame(2, $result->perPage);
        self::assertSame(3, $result->totalItems);
        self::assertSame(2, $result->totalPages);
    }

    public function testItHandlesEmptyItems(): void
    {
        $paginator = new Paginator(perPage: 2);

        $result = $paginator->paginate(
            items: [],
            page: 1,
        );

        self::assertSame([], $result->items);
        self::assertSame(1, $result->currentPage);
        self::assertSame(2, $result->perPage);
        self::assertSame(0, $result->totalItems);
        self::assertSame(0, $result->totalPages);
    }
}
