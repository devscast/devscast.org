.PHONY: help
help: ## show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: serve
serve: vendor/autoload.php ## start app
	php -S 0.0.0.0:8080 -t public -d display_errors=1

.PHONY: lint
lint: vendor/autoload.php ## code style standard and static analysis
	php vendor/bin/phpcs -s
	php vendor/bin/ecs check
	php bin/console lint:yaml config
	php bin/console lint:twig templates
	php vendor/bin/phpstan

.PHONY: migrate
migrate: vendor/autoload.php ## create database and migrate to the latest version
	php bin/console doctrine:database:create --if-not-exists
	php bin/console	doctrine:migration:migrate --no-interaction

.PHONY: test
test: vendor/autoload.php ## unit and integration tests
	make migrate
	php vendor/bin/phpunit --coverage-text

.PHONY: install
install: vendor/autoload.php ## install and setup
	make migrate
	yarn install --force
	yarn run build

.PHONY: lf
lf: vendor/autoload.php ## code style standard fix
	php vendor/bin/ecs check --fix
	php vendor/bin/phpcbf

.PHONY: ref
ref: vendor/autoload.php ## refactoring proposal
	make lf
	php vendor/bin/rector --dry-run

# -----------------------------------
# Dependencies
# -----------------------------------
vendor/autoload.php: composer.json
	composer install
	composer dump-autoload --optimize

composer.lock: composer.json
	composer update
