include .env


install: 
	@docker-compose up -d
	@docker exec -it ${APP_NAME}_php8.0 composer update
	@docker exec -it ${APP_NAME}_php8.0 chmod -R 777 storage/
	@docker exec -it ${APP_NAME}_php8.0 php artisan key:generate
	@docker exec -it ${APP_NAME}_php8.0 php artisan migrate
	@docker exec -it ${APP_NAME}_php8.0 php artisan db:seed

docker-up:
	@docker-compose up -d

docker-build:
	@docker-compose up -d --build

docker-stop:
	@docker-compose stop

docker-down:
	@docker-compose down

docker-status:
	@docker-compose ps

docker-logs:
	@docker-compose logs -f

docker-exec-php:
	@docker exec -it ${APP_NAME}_php8.0 bash

test:
	@docker exec -it ${APP_NAME}_php8.0 php artisan test --coverage-html tests/coverage/html

test-unit:
	@docker exec -it ${APP_NAME}_php8.0 php artisan test --testsuite=Unit

infection:
	@docker exec -it ${APP_NAME}_php8.0 vendor/bin/infection

phpinsights:
	@docker exec -it ${APP_NAME}_php8.0 vendor/bin/phpinsights  
	
migrate:
	@docker exec -it ${APP_NAME}_php8.0 php artisan migrate

migrate-rollback:
	@docker exec -it ${APP_NAME}_php8.0 php artisan migrate:rollback

migrate-refresh:
	@docker exec -it ${APP_NAME}_php8.0 php artisan migrate:refresh

seed:
	@docker exec -it ${APP_NAME}_php8.0 php artisan db:seed

