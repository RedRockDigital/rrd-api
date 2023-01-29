## Red Rock Digital API

This is the API for the Red Rock Digital foundations. It is built using the [Laravel](http://laravel.com/) framework.

### Documentation

The documentation for the API can be found [here](https://redrockdigital.github.io/api/).

### Requirements

1. PHP 8.2+
2. MySQL 8+
3. Composer 2+

### Getting Started

In your project, run the following composer require:

```
composer require redrockdigital/api
```

Add the following to your `config/app.php` providers array:

```
RedRockDigital\Api\RedRockApiServiceProvider::class,
```

Then you will then need to publish the config file(s):

```
php artisan vendor:publish --provider="RedRockDigital\Api\RedRockApiServiceProvider"
```

This will publish the following configs to `config/base.php`, `config/payments.php`. The routes, controllers, events, and everything in-between are all pre-registered within the above ServiceProvider. Meaning everything bar two commands, will run out of the box.

The two commands which should be ran to setup the API are:

#### Setup Command

This command will install all the frontend components, needed to build the frontend.

```
php artisan rrd:setup {--force : Force operation without interaction} {--reinstall : Force reinstall of the package}
```

#### Install Command

This command will install the API into your project. Doing the following, will migrate the database, seed the database, install passport keys, and seed database with testing data for local use.

```
php artisan rrd:install {--env= : The env to seed}
```



