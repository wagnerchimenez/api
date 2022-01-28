build:
	docker-compose down
	docker-compose up -d

db:
	cd app && php bin/console doctrine:database:drop --force

up:
	cd app && php bin/console doctrine:database:create
	cd app && php bin/console doctrine:migrations:diff
	cd app && php bin/console doctrine:migrations:migrate
	