#!/bin/bash
set -e

echo "Running Code Style Analysis..."
/app/vendor/bin/phpcs

echo "Running PHP Static Analysis..."
php -d memory_limit=-1 /app/vendor/bin/phpstan analyse -c /app/phpstan.neon.dist

echo "Running deptrac..."
/app/vendor/bin/deptrac analyse depfile-modules.yaml
/app/vendor/bin/deptrac analyse depfile-layers.yaml