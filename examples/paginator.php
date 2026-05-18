<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Martinandrasi\Hugmarket\Movie;
use Martinandrasi\Hugmarket\Paginator;

$movies = [
    new Movie('Titanic'),
    new Movie('Interstellar'),
    new Movie('The Matrix'),
    new Movie('Avatar'),
    new Movie('Gladiator'),
    new Movie('Inception'),
];

$paginator = new Paginator(perPage: 2);

/** @var PaginationResult<Movie> $result */
$paginationResult = $paginator->paginate(
    items: $movies,
    page: 2,
);


print_r($paginationResult->items);
