.PHONY: cache-clear
.PHONY: test
.PHONY: bdd
.PHONY: build

all: bdd build


vendor:
	php /usr/local/bin/composer.phar install


cache-clear: vendor
	rm -rf var/

bdd: cache-clear
	php bin/console doctrine:database:create --if-not-exists
	php bin/console doctrine:schema:update --force
	php bin/console doctrine:fixtures:load -n

node_modules:
	yarn install

build:
	bash build.sh


test: cache-clear
	php /usr/local/bin/phpunit.phar

