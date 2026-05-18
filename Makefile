.PHONY: build install shell paginator imdb phpstan fix fix-check test

build:
	docker compose build

install:
	docker compose run --rm app composer install

paginator:
	docker compose run --rm app php examples/paginator.php

imdb:
	docker compose run --rm app sh bin/imdb-title.sh $(id)

phpstan:
	docker compose run --rm app vendor/bin/phpstan analyse src

fix:
	docker compose run --rm app vendor/bin/php-cs-fixer fix

fix-check:
	docker compose run --rm app vendor/bin/php-cs-fixer fix --dry-run --diff

test:
	docker compose run --rm app vendor/bin/phpunit
