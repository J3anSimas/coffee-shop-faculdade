FROM php:8.0-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo_mysql

# Copy the current directory contents into the container at /var/www/html
COPY ./server /var/www/html
COPY ./apache2 /etc/apache2
# Expose port 8080
EXPOSE 8080

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Start Apache server in the foreground
CMD ["apache2-foreground"]