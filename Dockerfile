# Utilise une image PHP officielle avec Apache
FROM php:8.2-apache

# Copie les fichiers de ton projet dans le répertoire du serveur Apache
COPY . /var/www/html/

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html/

# Installe curl si nécessaire pour Twilio ou tests
RUN apt-get update && apt-get install -y curl

# Expose le port HTTP
EXPOSE 80
