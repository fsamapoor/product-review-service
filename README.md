<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About Review Project

This project intends to implement a Review service. I'm using the task to show how I would normally approach a Laravel project.
I also want to show my practices on Git flows, writing tests, using static analyzers, utilizing automatic code style checks, adding GitHub workflows as the CI and writing documentation for the project.

## Tools
- [Laravel Pint](https://laravel.com/docs/10.x/pint) as code style fixer.
- [Pest](https://pestphp.com) for writing tests.
- [PHPStan](https://phpstan.org/) for running static analyzes
- [Pest's Type Coverage plugin](https://pestphp.com/docs/type-coverage) for checking %100 type coverage

## GitHub workflows
- [Pint](/.github/workflows/pint.yml) for code style checks.
- [Tests](/.github/workflows/tests.yml) for running the test suite.
- [Static](/.github/workflows/static.yml) for running static analyzes workflows (PHPStan and Pest type coverage).

## Setup
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Dependencies
- [PHP 8.3](https://www.php.net/releases/8.3/en.php)
- [Composer v2](https://getcomposer.org/download/)

### Getting Started
``` bash
git clone https://github.com/fsamapoor/product-review-service.git

cd review

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan db:seed --class=ReviewSeeder

php artisan serve
```

### API Endpoints
| Method   | Route                                        | Description                    |
|----------|----------------------------------------------|--------------------------------|
| `GET`    | `/api/products`                              | Get all products.              |
| `POST`   | `/api/products/:productId/reviews`           | Create a review for a product. |

### Testing
``` bash
composer test
```


TODOs:
- Develop remaining REST endpoints.
- Improve the test-suite.
- Containerize the application.
- Implement authentication.
- Implement authorization.
- Add a new workflow to auto-generate API docs.
- Filament integration.
