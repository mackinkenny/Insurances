#!/bin/bash
export COMPOSER_ALLOW_SUPERUSER=1; composer show; composer install
cd /var/www/ && sudo php artisan storage:link && php artisan config:cache
sudo chown -R www-data /var/www
sudo chgrp -R www /var/www
sudo chmod 2775 /var/www
find /var/www -type d -exec sudo chmod 2775 {} \;
find /var/www -type f -exec sudo chmod 0664 {} \;
sudo chmod -R 777 /var/www/storage
composer update
composer dump-autoload