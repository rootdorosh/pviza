#!/usr/bin/env bash

/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan app_version:update
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan view:clear 
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan config:clear
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan cache:clear 
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan scms:clear
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan config:cache
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan migrate
/usr/local/php72/bin/php -c /home/parfymer/.system/php/poland.shengen-viza.com.ua.ini -f artisan db:seed --class=SyncSeeder 