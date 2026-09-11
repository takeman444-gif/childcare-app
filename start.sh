#!/bin/bash
php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force
apache2-foreground
