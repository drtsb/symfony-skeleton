#!/bin/bash
set -e

echo "Running Code Style Analysis..."
/app/vendor/bin/phpcs

echo "Running PHP Static Analysis..."
php -d memory_limit=-1 /app/vendor/bin/phpstan analyse -c /app/phpstan.neon.dist

echo "Running deptrac for modules..."
/app/vendor/bin/deptrac analyse depfile-modules.yaml

echo "Running deptrac for layers..."
/app/vendor/bin/deptrac analyse depfile-layers.yaml