#!/bin/bash

php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan event:clear
php artisan event:cache
php artisan optimize:clear
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

