.DEFAULT_GOAL := help

# -----------------------------------
# Variables
# -----------------------------------
is_docker := $(shell docker info > /dev/null 2>&1 && echo 1)
user := $(shell id -u)
group := $(shell id -g)
port ?= 8080
host ?= localhost

ifeq ($(is_docker), 1)
	dc := USER_ID=$(user) GROUP_ID=$(group) docker-compose
	de := docker-compose exec
	dr := $(dc) run --rm
	drtest := $(dc) -f docker-compose.test.yaml run --rm
	sfc := $(de) php bin/console
	node := $(dr) --user="$(user)" node
	php := $(dr) --no-deps php
	phptest := $(drtest) phptest
	composer := $(php) composer
	host := 0.0.0.0
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

.PHONY: serve
serve: vendor/autoload.php ## start app
	$(php) -S $(host):$(port) -t public -d display_errors=1

.PHONY: lint
lint: vendor/autoload.php ## code style standard and static analysis
	$(php) vendor/bin/phpcs -s
	$(php) vendor/bin/ecs check
	$(php) bin/console lint:yaml config
	$(php) bin/console lint:twig templates
	$(php) bin/console lint:container
	$(php) vendor/bin/phpstan

.PHONY: migrate
migrate: vendor/autoload.php ## create database and migrate to the latest version
	$(php) bin/console doctrine:database:create --if-not-exists
	$(php) bin/console doctrine:migration:migrate --no-interaction --allow-no-migration

.PHONY: test
test: vendor/autoload.php ## unit and integration tests
	$(phptest) bin/console cache:clear --env=test
	$(phptest) bin/console doctrine:schema:validate --skip-sync
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

.PHONY: lf
lf: vendor/autoload.php ## code style standard fix
	$(php) vendor/bin/ecs check --fix
	$(php) vendor/bin/phpcbf

.PHONY: ref
ref: vendor/autoload.php ## refactoring proposal
	make lf
	$(php) vendor/bin/rector --dry-run

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
	$(node) npm rebuild node-sass  # see https://github.com/yarnpkg/yarn/issues/4867
	$(node) yarn run build
