#!/usr/bin/env bash
set -e

APP_DIR="${APP_DIR:-/app}";

# Migrations
STARTUP_MIGRATE_DATABASE="${STARTUP_MIGRATE_DATABASE:-false}";
STARTUP_SEED_DATABASE="${STARTUP_SEED_DATABASE:-false}";
STARTUP_CHECK_MIGRATIONS="${STARTUP_CHECK_MIGRATIONS:-false}";
STARTUP_START_CONSUMERS="${STARTUP_START_CONSUMERS:-true}";

# Migrate app database
if [[ "$STARTUP_MIGRATE_DATABASE" = "true" ]]; then
  echo '[INFO] Migrate app database';
  php ${APP_DIR}/bin/console doctrine:database:create --if-not-exists --no-interaction;
  php ${APP_DIR}/bin/console doctrine:migrations:migrate --no-interaction;
fi;

# Seed app database
if [[ "$STARTUP_SEED_DATABASE" = "true" ]]; then
  echo '[INFO] Seed app database';
  php ${APP_DIR}/bin/console app:init:all;
fi;

# Check DB migrations
if [[ "$STARTUP_CHECK_MIGRATIONS" = "true" ]]; then
  echo "[INFO] Checking migrations status...";
  NEW_MIGRATIONS=$(php ${APP_DIR}/bin/console doctrine:migrations:status | grep "New Migrations" | awk '{print $4}');
  if [[ "$NEW_MIGRATIONS" -eq 0 ]]; then
    echo "[INFO] Migrations status: OK";
  else
    if [[ "$NEW_MIGRATIONS" -gt 0 ]]; then
      echo "[ERROR] DB is not migrated";
      php ${APP_DIR}/bin/console doctrine:migrations:status;
    else
      echo "[ERROR] DB connection broken or something bad happened";
      php ${APP_DIR}/bin/console doctrine:migrations:status;
    fi
    exit 1;
  fi;
fi;

php ${APP_DIR}/bin/console cache:clear

chown -R nginx:nginx ${APP_DIR}/var

if [ "${STARTUP_START_CONSUMERS}" = "true" ]; then
  echo '[INFO] Seed app database';
  /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
fi;

exec "$@";
