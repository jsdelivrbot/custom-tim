FROM docker-vsct.pkg.cloud.socrate.vsct.fr/webana/httpd-php:2.2.32-7.2.3

ENV APP_NAME tim
ENV APP_LOG_DIR /var/log/$APP_NAME
ENV APP_CACHE_DIR /tmp/$APP_NAME

RUN rm -rf $APACHE_WORKDIR/*
COPY . $APACHE_WORKDIR
RUN rm $APACHE_WORKDIR/php_ini_overwrite.conf $APACHE_WORKDIR/php_extensions.conf $APACHE_WORKDIR/apache.conf

COPY php_ini_overwrite.conf $DOCKER_PHP/php-overwrite-ini.conf
COPY php_extensions.conf $DOCKER_PHP/php-extensions.conf
COPY apache.conf $APACHE_VHOST_DIR/apache.conf

RUN mkdir -p $APP_LOG_DIR \
    && chown -R daemon:daemon $APP_LOG_DIR

RUN mkdir -p $APP_CACHE_DIR \
    && chown -R daemon:daemon $APP_CACHE_DIR

VOLUME $APP_LOG_DIR
VOLUME $APP_CACHE_DIR