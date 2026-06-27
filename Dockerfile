# Use an official PHP image with Apache pre-installed
FROM php:8.2-apache

# Copy all your project files into the Apache public web directory
COPY . /var/www/html/

# Enable the Apache rewrite module (useful for clean routing if you add it later)
RUN a2enmod rewrite

# Expose port 80 so the container can accept incoming web traffic
EXPOSE 80

# Start Apache in the foreground so the container stays active
CMD ["apache2-foreground"]
