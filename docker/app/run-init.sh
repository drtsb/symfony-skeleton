#!/bin/bash

composer install -o

php bin/console doctrine:database:create --if-not-exists --no-interaction
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console app:init:all