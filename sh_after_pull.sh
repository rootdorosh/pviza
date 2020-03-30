#!/usr/bin/env bash

composer install
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate app_version:update
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate view:clear 
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate config:clear
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate cache:clear 
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate scms:clear
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate config:cache
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate migrate
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate db:seed --class=SyncSeeder 