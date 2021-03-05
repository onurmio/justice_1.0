FROM ubuntu:latest

# Set time zone.
ENV TZ=Europe/Istanbul
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install apache, PHP, and supplimentary programs.
RUN apt-get update && \
    apt-get -y upgrade && \
    apt-get -y install \
    apache2 \
    php \
    php-cli \
    libapache2-mod-php \
    php-gd \
    php-curl \
    php-json \
    php-mbstring \
    php-mysql \
    php-xml \
    php-xsl \
    php-zip \
    php-pear\
    php-dev \
    php-redis \
    composer

# Enable apache mods.
RUN a2enmod php7.4
RUN a2enmod rewrite

# Install php modules.
RUN pecl install mongodb

# Enable external modules.
RUN echo 'extension=mongodb.so' >> /etc/php/7.4/cli/php.ini
RUN echo 'extension=mongodb.so' >> /etc/php/7.4/apache2/php.ini

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.4/apache2/php.ini
RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.4/apache2/php.ini

# Arrange permissions.
RUN chmod -R 777 /var/www/html

# Copy source files and arrange them.
WORKDIR /var/www/html
RUN rm -rf index.html
COPY src/ .
RUN chmod -R 777 /var/www/html/storage

# Install required packages.
RUN composer install

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Update the default apache site with the config we created.
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# Expose apache.
EXPOSE 80

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD ["apache2ctl", "-D", "FOREGROUND"]