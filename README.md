<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Laravel Checklister

### install dependencies
$ composer install 


### Create a copy of your .env.example file to .env
$ cp .env.example .env 

### Generate an app encryption key
$ php artisan key:generate

### Create an empty database for our application and then In the .env file, add database information to allow Laravel to connect to the database
$ DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD 

### Migrate the database
$ php artisan migrate

### Seed the database
$ php artisan db:seed

### make a storage link , If nedded
$ php artisan storage:link

