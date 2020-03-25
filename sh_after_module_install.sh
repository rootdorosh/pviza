#!/usr/bin/env bash
php artisan view:clear 
php artisan config:clear
php artisan cache:clear 
php artisan scms:clear
php artisan config:cache
php artisan migrate
php artisan db:seed --class=SyncSeeder