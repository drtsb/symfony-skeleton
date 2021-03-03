FROM composer:2.0.9 AS composer
FROM debian:buster-slim

ENV PHP_VERSION 8.0
ENV COMPOSER_ALLOW_SUPERUSER 1
ARG ADDITIONAL_PACKAGES
ENV ADDITIONAL_PACKAGES=${ADDITIONAL_PACKAGES}
ENV DEBIAN_FRONTEND noninteractive

RUN set -ex && \
    apt-get -q update && \
    apt-get -qy upgrade && \
    apt-get install -qy wget curl gnupg2 apt-utils apt-transport-https ca-certificates && \
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb https://packages.sury.org/php/ buster main" > /etc/apt/sources.list.d/php.list  && \
    apt-get -q update && \
    apt-get -qy install --no-install-recommends \
    supervisor zip unzip aspell aspell-ru netcat \
    php${PHP_VERSION}-fpm php${PHP_VERSION}-cli php${PHP_VERSION}-xml php${PHP_VERSION}-intl php${PHP_VERSION}-curl \
    php${PHP_VERSION}-bcmath php${PHP_VERSION}-readline \
    php${PHP_VERSION}-mbstring php${PHP_VERSION}-zip php${PHP_VERSION}-pgsql  \
    php-igbinary php${PHP_VERSION}-redis ${ADDITIONAL_PACKAGES} && \
    apt-get -qy autoremove && \
    apt-get clean && \
    rm -r /var/lib/apt/lists/* && \
    cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime

# install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN ln -sf /dev/stderr /tmp/php${PHP_VERSION}-fpm.log

RUN groupadd -g 1008 nginx && \
    useradd -u 1008 -g 1008 nginx && \
    mkdir /run/php && \
    mkdir -p /home/nginx/.composer && \
    chown -R nginx:nginx /home/nginx && \
    mkdir -p /var/log/supervisor && \
    chown -R nginx:nginx /var/log/supervisor

COPY ./docker/app/php/ /etc/php/${PHP_VERSION}/
COPY ./docker/app/supervisor/ /etc/supervisor/

COPY . /app
COPY ./docker/app/app-entrypoint.sh /app-entrypoint.sh
WORKDIR /app

RUN chown -R nginx:nginx /app && \
    chmod +x /app/docker/app/*.sh && \
    chmod +x /app-entrypoint.sh && \
    su nginx -c "composer install -o" && \
    su nginx -c "rm -rf ~/.composer/cache/" && \
    cat .env.test > .env && \
    su nginx -c "php bin/console assets:install" && \
    rm -rf /app/var/cache/*

EXPOSE 9000

ENTRYPOINT ["/app-entrypoint.sh"]
CMD ["php-fpm8.0", "-F"]
