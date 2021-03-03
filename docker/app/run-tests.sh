#!/bin/bash
set -e

echo "Checking connections..."
/app/docker/app/wait-for pgsql_sut:5432 -t 240 -- echo "PostgreSQL is ready."
/app/docker/app/wait-for rmq_sut:5672 -t 240 -- echo "RabbitMQ is ready."
/app/docker/app/wait-for redis_sut:6379 -t 240 -- echo "Redis is ready."

touch /app/.env

echo "Applying migrations..."
php /app/bin/console doctrine:migrations:migrate --no-interaction

echo "Running tests..."
php /app/vendor/bin/codecept build
php /app/vendor/bin/codecept run
