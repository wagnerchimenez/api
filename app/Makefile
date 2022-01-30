up:
	composer install
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:diff
	php bin/console doctrine:migrations:migrate
	php bin/console doctrine:fixtures:load

test:
	php ./vendor/bin/phpunit tests --color=auto

down:
	php bin/console doctrine:database:drop --force