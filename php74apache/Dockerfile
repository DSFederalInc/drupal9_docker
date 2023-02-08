FROM php:8.1-apache

# Uncomment this if you're running xdebug
#  ARG WITH_XDEBUG=false
#
#  RUN if [ $WITH_XDEBUG = "true" ] ; then \
#          pecl install xdebug; \
#          docker-php-ext-enable xdebug; \
#          echo "error_reporting=E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#          echo "display_startup_errors=On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#          echo "display_errors=On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#          echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#  		echo "xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#  		echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#  		echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#  		echo "xdebug.client_host=172.19.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#  		echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#      fi ;
  
# install the PHP extensions we need
RUN set -ex; \
	\
	if command -v a2enmod; then \
		a2enmod rewrite; \
	fi; \
	\
	savedAptMark="$(apt-mark showmanual)"; \
	\
	apt-get update; \
    	apt-get install -y --no-install-recommends \
    		libjpeg-dev \
    		libpng-dev \
    		libpq-dev \
    		libzip-dev \
            libfreetype6-dev \
	; \
	\
	docker-php-ext-configure gd --with-freetype=/usr --with-jpeg=/usr; \
        	# docker-php-ext-configure zip --with-libzip; \
        	docker-php-ext-install -j "$(nproc)" \
    		gd \
    		opcache \
    		pdo_mysql \
    		pdo_pgsql \
    		zip \
	; \
	\

	apt-mark auto '.*' > /dev/null; \
	apt-mark manual $savedAptMark; \
	ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
		| awk '/=>/ { print $3 }' \
		| sort -u \
		| xargs -r dpkg-query -S \
		| cut -d: -f1 \
		| sort -u \
		| xargs -rt apt-mark manual; \
	\
	apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
	rm -rf /var/lib/apt/lists/*

# set recommended PHP.ini settings
COPY php.ini "$PHP_INI_DIR/php.ini"

# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=60'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.enable_cli=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini
RUN curl -OL https://github.com/drush-ops/drush-launcher/releases/download/0.6.0/drush.phar \ 
&& chmod +x drush.phar \
&& mv drush.phar /usr/local/bin/drush

#Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php && \
	mv composer.phar /usr/local/bin/composer && \
	php -r "unlink('composer-setup.php');"


#Install git, curl, wget and vim	
RUN apt-get update && apt-get install -y \
	curl \
	git \
	vim \
	wget

#Install drush
RUN wget -O drush.phar https://github.com/drush-ops/drush-launcher/releases/download/0.4.2/drush.phar && \
	chmod +x drush.phar && \
	mv drush.phar /usr/local/bin/drush

RUN apt-get update && apt-get install -y default-mysql-client && rm -rf /var/lib/apt

RUN a2enmod rewrite

COPY drupal9.conf /etc/apache2/sites-enabled/drupal9.conf

RUN a2dissite 000-default.conf

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

