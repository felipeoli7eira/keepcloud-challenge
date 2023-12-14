APP_CONTAINER=laravelapp
DB_CONTAINER=laravelapp

dev/local:
	docker-compose up -d
	docker exec -it ${APP_CONTAINER} cp .env.example .env
	docker exec -it ${APP_CONTAINER} composer install

dev/down:
	docker compose down

dev/migrate:
	docker exec -it ${APP_CONTAINER} php artisan migrate

dev/migrateseed:
	docker exec -it ${APP_CONTAINER} php artisan migrate --seed

dev/dbwipe:
	docker exec -it ${APP_CONTAINER} php artisan db:wipe
