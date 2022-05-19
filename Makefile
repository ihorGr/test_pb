DOCKER         = docker
DOCKER_COMPOSE = docker-compose
EXEC_PHP       = $(DOCKER) exec test-pb-php-cli
SYMFONY        = $(EXEC_PHP) bin/console
COMPOSER       = $(EXEC_PHP) composer

.PHONY: install
install: docker composer db fixtures

docker:
	$(DOCKER_COMPOSE) --project-directory ./ up -d --build

composer:
	$(COMPOSER) install

db:
	while ! docker exec test-pb-mysql mysql --user=test_db --password=12345 -e "SELECT 1" >/dev/null 2>&1; do sleep 2; done
	$(SYMFONY) doctrine:migrations:migrate

fixtures:
	$(SYMFONY) doctrine:fixtures:load --group=PriceTestFixtures --append --group=CurrencyPairTestFixtures --append

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) kill

.PHONY: run
run: docker