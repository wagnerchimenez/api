environment:
	docker-compose build --force-rm --no-cache
	docker-compose up -d --force-recreate
	mkdir -p app/migrations

container:
	docker exec -it api-php-symfony bash
	make up