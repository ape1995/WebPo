YIOrderSystem
==========

### Requirement
- PHP 7 or higher
- MySQL 5.5 or higher

### Local Setup
- `git clone http://192.168.15.51/git.server/YIOrder.git`
- `cd YIOrder`
- `composer update`
- `change .env.example to .env`
- `config .env file`
- `php artisan migrate`
- `php artisan vendor:publish choose 0 `
- `php artisan infyom:publish`
- `php artisan key:generate`
- `php artisan serve`
- `open http://127.0.0.1:8000`
