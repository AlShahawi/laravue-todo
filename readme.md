# LaravueTodo

LaravueTodo is a SPA Task Manager Created using Laravel and Vue.JS.

## Installation
```
git clone https://github.com/AlShahawi/laravue-todo.git
cp .env.example .env
# configure your db connection in .env
php artisan key:generate
composer install
npm install
php artisan migrate --seed
php artisan passport:install
php artisan serv
```
Open your browser and go to `http://localhost:8000` to see the application.
Login using credentials `demo@demo.com` and password `123456`.

## Development
Make sure you run gulp after edit vue components or any javascript files.
