# Tenpin bowling game

## Requirement
- PHP 7.1
- Composer

## Run
- composer install
- php -r "file_exists('.env') || copy('.env.example', '.env');"
- php artisan key:generate


## Play the game thru command line

- php artisan play:game "[[5,2],[8,1],[6,4],[10],[5,5],[2,6],[8,1],[5,3],[6,1],[10,10,10]]"

## Run test
-./vendor/bin/phpunit



