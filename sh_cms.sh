#!/usr/bin/env bash
php artisan scms:clear
php artisan config:clear
php artisan cache:clear
php artisan config:cache