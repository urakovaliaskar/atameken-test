## Project
- Предполагается, что есть база сurrency_db.
- Предполагается, .env настроен на эту базу.
- Версия Php ^7.2.5
- Версия Laravel 

Пример .env db connection

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=currency_db
DB_USERNAME=root
DB_PASSWORD=
```

### Clone

- Clone this repo to your local machine using `https://github.com/urakovaliaskar/atameken-test.git`

### Setup

> install composer packages first

```shell
$ composer install
```

> migration and seeding, passport

```shell
$ php artisan migrate:fresh
$ php artisan db:seed
$ php artisan passport:install
```
> currency refresh command, runs daily

```shell
$ php artisan refresh:currency
```

## Requesting

Header должен иметь Authorization: 'Bearer yourtoken' и Accept: application/json. Чтобы получить токен нужно авторизоваться с телом указанным ниже на роут `http://127.0.0.1:8000/api/login`

```javascript
{
	"username": "admin",
	"password": "123456789"
}
```
## Api
- Get request `http://127.0.0.1:8000/api/currencies`, optional query 'date' (04.08.20)
- Get request `http://127.0.0.1:8000/api/currencies`, required query 'name' (AUD), optional query 'date' (04.08.20)
