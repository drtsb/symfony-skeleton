ARG APP_IMAGE_TAG

FROM symfony:local AS assets

FROM nginx:1.19.1-alpine

# auto_envsubst 
# https://github.com/nginxinc/docker-nginx/blob/793319d7251c03eccecbf27b60e0cfbbd2d1f400/mainline/alpine/20-envsubst-on-templates.sh
#ENV NGINX_ENVSUBST_TEMPLATE_DIR="/etc/nginx/conf.d"
#ENV NGINX_ENVSUBST_TEMPLATE_SUFFIX=".tmpl"

COPY ./docker/nginx /etc/nginx
COPY --from=assets /app/public /app/public
