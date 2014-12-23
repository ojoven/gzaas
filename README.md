# Gzass 2.0

Gzaas clone.

Frontend:
* Angular.js
* Bootstrap

Backend: 
* Silex
 
## Install dependencies:

```
npm install
bower install 
composer install
```

## Run the server:

```
grunt serve
```

## Run unit test

* Backend: 
```
phpunit
```
* Frontend:
```
karma start karma.js
```

## Database

The example uses sqlite.
Please rename gzaas.sqlite.dist to gzaas.sqlite

```
mv db/gzaas.sqlite.dist db/gzaas.sqlite
```

## Pre-requisites

* npm (brew install npm / apt-get install npm)
* bower (npm install bower -g)
* grunt-cli (npm install grunt-cli -g)
* composer (curl -sS https://getcomposer.org/installer | php)
