environment:
	yes | docker system prune -a -f
	docker-compose build
	docker-compose up -d --force-recreate
	mkdir -p app/migrations

container:
	docker exec -it api-php-symfony bash
	make up

reset:
	sudo rm -R docker
	sudo rm -R migrations