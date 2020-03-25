#!/usr/bin/env bash
composer install
php artisan migrate
php artisan key:generate
php artisan db:seed --class=InstallSeeder
php artisan db:seed --class=SyncSeeder