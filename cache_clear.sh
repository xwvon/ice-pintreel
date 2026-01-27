#!/bin/bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear
composer dump-autoload
