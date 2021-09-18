#!/bin/bash
echo "Checking connections..."

/app/docker/app/wait-for ${DB_APP_HOST}:${DB_APP_PORT} -t 240 -- echo "PostgreSQL is ready."
/app/docker/app/wait-for ${RABBITMQ_HOST}:${RABBITMQ_PORT} -t 240 -- echo "RabbitMQ is ready."
/app/docker/app/wait-for ${REDIS_HOST}:${REDIS_PORT} -t 240 -- echo "Redis is ready."

cd /app

echo "Applying migrations..."
bin/console doctrine:migrations:migrate --no-interaction

echo "Initializing..."
bin/console app:init:all

bash
