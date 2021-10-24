#!/usr/bin/make
# Makefile readme (ru): <http://linux.yaroslavl.ru/docs/prog/gnu_make_3-79_russian_manual.html>
# Makefile readme (en): <https://www.gnu.org/software/make/manual/html_node/index.html#SEC_Contents>

dc_bin := $(shell command -v docker-compose 2> /dev/null)
docker_bin := $(shell command -v docker 2> /dev/null)
dc_app_name = app

SHELL = /bin/bash
RUN_APP_ARGS = --rm --entrypoint="" "$(dc_app_name)"

define print
	printf " \033[33m[%s]\033[0m \033[32m%s\033[0m\n" $1 $2
endef
define print_block
	printf " \e[30;48;5;82m  %s  \033[0m\n" $1
endef

include .env
export

.PHONY : help tests \
		 install update 'shell' test \
		 up down restart logs clean

.SILENT : help install up down 'shell'
.DEFAULT_GOAL : help

# This will output the help for each task. thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## Show this help
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

shell: ## Start shell into app container
	$(dc_bin) run $(RUN_APP_ARGS) bash

up: ## Create and start containers
	$(dc_bin) up --detach
	$(call print_block, 'Navigate your browser to ⇒ http://127.0.0.1')
	$(call print_block, 'RabbitMQ web admin (guest:guest) ⇒ http://127.0.0.1:15672/#/queues')
	$(call print_block, 'Additional ports (available for connections) - PostgreSQL ⇒ 5432; Redis ⇒ 6379')

down: ## Stop and remove containers, networks and images
	$(dc_bin) down -t 5

restart: down up ## Restart all containers

logs: ## Show docker logs
	$(dc_bin) logs --follow

clean: ## Make some clean
	$(dc_bin) down -v -t 5

build:
	$(dc_bin) rm -sf
	$(dc_bin) down --remove-orphans
	$(dc_bin) build
	$(dc_bin) up -d

build-app:
	$(dc_bin) build --no-cache app

stop:
	$(dc_bin) stop

init:
	$(dc_bin) run -e XDEBUG_MODE=develop --rm --entrypoint="/app/docker/app/run-init.sh" app

install: ## Install all app dependencies
	$(dc_bin) run -e XDEBUG_MODE=develop --no-deps $(RUN_APP_ARGS) composer install --no-interaction --ansi --prefer-dist

update: ## Update all app dependencies
	$(dc_bin) run -e XDEBUG_MODE=develop --no-deps $(RUN_APP_ARGS) composer update slevomat/coding-standard -n --ansi --prefer-dist

require:
	$(dc_bin) run -e XDEBUG_MODE=develop --no-deps $(RUN_APP_ARGS) composer require

require-dev:
	$(dc_bin) run -e XDEBUG_MODE=develop --no-deps $(RUN_APP_ARGS) composer require --dev

enter:
	$(dc_bin) exec $(dc_app_name) bash

exec:
	$(dc_bin) exec $(dc_app_name) php bin/console $(command)

tail-logs:
	$(dc_bin) logs -f $(dc_app_name)

check: ## Execute app code check
	$(dc_bin) run -e XDEBUG_MODE=develop --no-deps --rm --entrypoint="/app/docker/app/run-analysis.sh" app

fix: ## Execute app code style fix
	$(dc_bin) run -e XDEBUG_MODE=develop --no-deps --rm --entrypoint="/app/vendor/bin/phpcbf" app

tests: ## Execute app tests, can use param to proxy `in codeception run`
	$(dc_bin) -f docker-compose.test.yml run --rm --entrypoint="/app/docker/app/run-tests.sh $(filter-out tests-dev,$(MAKECMDGOALS))" sut
	make tests-down

tests-shell: ## Run shell for tests
	$(dc_bin) -f docker-compose.test.yml run --rm --entrypoint="/app/docker/app/tests-shell-entrypoint.sh" sut
	make tests-down

tests-down: ## Stop and remove test containers, networks and images
	$(dc_bin) -f docker-compose.test.yml down

test-file:
	$(dc_bin) exec $(dc_app_name) php /app/vendor/bin/codecept run $(FILE)