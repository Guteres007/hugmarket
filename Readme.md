# Hugmarket Test

This project contains solutions for these tasks:

1. IMDb movie title fetcher
2. Generic paginator

## Requirements

- Docker
- Docker Compose
- Make

## Project Setup

From a clean checkout, run:

```bash
make build
make install
```

The Docker environment provides `OMDB_API_KEY` for the IMDb example.
When running `bin/imdb-title.sh` directly, set `OMDB_API_KEY` in your shell.

## Run The Examples

Run the IMDb title fetcher:

```bash
make imdb id=tt0120338
```

Run the paginator:

```bash
make paginator
```

## Code Quality

Run static analysis:

```bash
make phpstan
```

Fix PHP code style:

```bash
make fix
```

Check formatting:

```bash
make fix-check
```


Run tests:

```bash
make test
```
