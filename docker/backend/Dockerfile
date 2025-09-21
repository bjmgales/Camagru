FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql
# docker-php-ext-install => compile php source code to enable communication with mysqli and pdo
#pdo, pdo_mysql => PDO (PHP Data Object) is an API providing a set of methods to contact databases. But it requires a driver, here pdo_mysql, to know to which type of database we want to communicate with.

RUN a2enmod rewrite

# enables url rewriting "login.html" => "login"
COPY docker/backend/apache.conf /etc/apache2/sites-available/000-default.conf

COPY docker/backend/sendmail.ini /usr/local/etc/php/conf.d/sendmail.ini

# Configure msmtp to act as sendmail
RUN apt-get update && apt-get install -y msmtp ca-certificates && rm -rf /var/lib/apt/lists/*
RUN ln -sf /usr/bin/msmtp /usr/sbin/sendmail
COPY docker/backend/msmtprc.template /etc/msmtprc.template
COPY docker/backend/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

CMD ["sh", "/usr/local/bin/entrypoint.sh"]


