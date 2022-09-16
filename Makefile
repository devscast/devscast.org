.DEFAULT_GOAL := help

# -----------------------------------
# Variables
# -----------------------------------
is_docker := $(shell docker info > /dev/null 2>&1 && echo 1)
user := $(shell id -u)
group := $(shell id -g)

ifeq ($(is_docker), 1)
	dc := USER_ID=$(user) GROUP_ID=$(group) docker-compose
	de := docker-compose exec
	dr := $(dc) run --rm
	sfc := $(dr) php bin/console
	node := $(dr) --user="$(user)" node
	php := $(dr) --no-deps php
	phptest := $(dr) php_test
	composer := $(php) composer
else
	php := php
	node := node
	composer := composer
	sfc := $(php) bin/console
endif


# -----------------------------------
# Recipes
# -----------------------------------
.PHONY: help
help: ## show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: lint
lint: vendor/autoload.php ## code style standard and static analysis
	$(php) vendor/bin/phpcs -s
	$(php) vendor/bin/ecs check
	$(sfc) lint:yaml config
	$(sfc) lint:twig templates
	$(sfc) lint:container
	$(php) vendor/bin/phpstan

.PHONY: migrate
migrate: vendor/autoload.php ## create database and migrate to the latest version
	$(sfc) doctrine:database:create --if-not-exists
	$(sfc) doctrine:migration:migrate --no-interaction --allow-no-migration

.PHONY: test
test: vendor/autoload.php public/assets/manifest.json ## unit and integration tests
	$(phptest) bin/console cache:clear --env=test
	$(phptest) bin/console doctrine:database:create --if-not-exists --env=test
	$(phptest) bin/console doctrine:migration:migrate --no-interaction --allow-no-migration --env=test
	$(phptest) bin/console doctrine:schema:validate --skip-sync --env=test
	$(phptest) bin/phpunit --stop-on-failure

.PHONY: build-docker
build-docker:
	$(dc) pull --ignore-pull-failures
	$(dc) build php
	$(dc) build node

.PHONY: dev
dev: vendor/autoload.php node_modules/time ## Start the development env
	$(dc) up

.PHONY: install
install: vendor/autoload.php public/assets/manifest.json ## install and setup
	make clear
	make migrate

.PHONY: clear
clear: vendor/autoload.php ## clear symfony cache
	$(sfc) cache:clear
	$(sfc) cache:pool:clear cache.global_clearer

# -----------------------------------
# Dependencies
# -----------------------------------
vendor/autoload.php: composer.json
	$(composer) install

composer.lock: composer.json
	$(composer) update

node_modules/time: yarn.lock
	$(node) yarn install --force
	touch node_modules/time

public/assets: node_modules/time
	$(node) yarn run build

public/assets/manifest.json: package.json
	$(node) yarn --force
	$(node) yarn run build
