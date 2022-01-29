up-force:
	docker-compose build --no-cache
	docker-compose up -d --force-recreate

up: 
	docker-compose build
	docker-compose up -d

down:
	docker-compose down

clear:
	sudo rm -R docker

container:
	docker exec -it api-php-symfony bash
	make up