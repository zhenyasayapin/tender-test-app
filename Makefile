SHELL := /bin/bash

ARGS = $(filter-out $@,$(MAKECMDGOALS))
PHP_CONTAINER = tender-test-app-php

start:
	docker compose up -d
restart:
	docker compose down && docker compose up -d
rebuild:
	docker compose down &&  docker compose build && docker compose up -d
stop:
	docker compose down
build:
	docker compose build
exec:
	@docker exec -it $(ARGS)
console:
	@docker exec -it $(PHP_CONTAINER) symfony console $(ARGS)
composer:
	@docker exec -it $(PHP_CONTAINER) symfony composer $(ARGS)
symfony:
	@docker exec -it $(PHP_CONTAINER) symfony $(ARGS)
phpunit:
	@docker exec -it $(PHP_CONTAINER) php bin/console doctrine:database:drop --env=test --force --if-exists
	@docker exec -it $(PHP_CONTAINER) php bin/console doctrine:database:create --env=test
	@docker exec -it $(PHP_CONTAINER) php bin/console doctrine:schema:update --env=test --force
	@docker exec -it $(PHP_CONTAINER) vendor/bin/phpunit $(ARGS)