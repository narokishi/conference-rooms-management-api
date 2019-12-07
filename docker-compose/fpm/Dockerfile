FROM php:7.3-fpm
ARG TIMEZONE
ARG DOCKER_USER

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Update sources
RUN apt-get update -y
RUN apt-get upgrade -y

# Install GIT
RUN apt-get install -y git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir /.composer && chown -R ${DOCKER_USER}:${DOCKER_USER} /.composer

# Install PHP extensions dependiencies
RUN apt-get install -y libzip-dev unzip

# Install PHP "zip" extension
RUN pecl install zip
RUN docker-php-ext-enable zip

# Install PostgreSQL driver
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install PHP "xdebug" extension
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Install PHP "redis" extension
RUN pecl install -o -f redis
RUN docker-php-ext-enable redis

# Install "Node.js"
RUN apt-get update --fix-missing
RUN apt-get install -y gnupg
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

# Install "yarn"
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn
RUN mkdir /.yarn && chown -R ${DOCKER_USER}:${DOCKER_USER} /.yarn
RUN mkdir /.cache && chown -R ${DOCKER_USER}:${DOCKER_USER} /.cache
RUN touch /.yarnrc && chown -R ${DOCKER_USER}:${DOCKER_USER} /.yarnrc

# http://www.eatmybusiness.com/food/2015/04/21/why-always-run-rm-rf-varlibaptlists-after-an-apt-get-install/290/
RUN rm -rf /var/lib/apt/lists/* rm -rf /tmp/pear
