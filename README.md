# Authentication Server

This application is an authentication server that manages user information and act as an oauth2 provider for various other applications.

## Usage
TODO

## Installation
```
composer install
php artisan migate
php artisan passport:install
```

## Deploying
Run this command to generate the required encryption keys. The keys are not stored within source control and will be located at `storage/*.key` 
```
php artisan passport:keys
```