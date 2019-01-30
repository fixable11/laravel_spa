https://spa.fixable.org.ua - working example

## Installation

Clone this repository

```bash
git clone https://github.com/fixable11/laravel_spa.git
```

Install composer dependencies

```bash
composer install
```

Generate key on .env file

```bash
cp .env.example .env
php artisan key:generate
```

Generate jwt on .env file

```bash
php artisan jwt:secret
```

Install node modules
```bash
npm install
```

Optionally if you want to start `npm run watch` you should change proxy in webpack.mix.js
```
mix.browserSync({
    proxy: 'lara'
});
```

## Settings for Database

Replace database settings with yours in .env file

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
Then run
```
php artisan migrate --seed
```

## Settings for Pusher

Go to .env file and change Broadcast drive to pusher

```
BROADCAST_DRIVER=pusher
```

and also give credentials of your pusher on .env file

```
PUSHER_APP_ID=xxxxxx
PUSHER_APP_KEY=xxxxxxxxxxxxxxxxxxxx
PUSHER_APP_SECRET=xxxxxxxxxxxxxxxxxxxxxx
PUSHER_APP_CLUSTER=xxx
```

