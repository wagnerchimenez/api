up:
	docker-compose build --no-cache
	docker-compose up -d --force-recreate

down:
	docker-compose down

clear:
	sudo rm -R docker

container:
	docker exec -it api-php-symfony bash
	make up