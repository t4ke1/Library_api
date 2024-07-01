build:
	docker compose up --build

rebuild:
	docker compose down && docker compose up --build

start:
	docker compose up -d

restart:
	docker compose down && docker compose up -d

php:
	docker compose exec php bash

fixtures:
	docker compose exec php bash -c "php bin/console doctrine:fixtures:load"

migrations:
	docker compose exec php bash -c "php bin/console doctrine:fixtures:load"

AuthorClear:
	    docker compose exec php bash -c "php bin/console DeleteAuthor"
