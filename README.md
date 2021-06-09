# geo-junkies-laravel
GEO-JUNKIES 2.0

This is the GeoGuesser application's back-end. Provides the data and authentication for the GeoGueser front-end.

#### Front-end repository link:
https://github.com/SzoBa/Geo-Guesser-front-end.git

#### Used Technologies (backend)
- PHP 7.4
- Laravel 8 (Socialite, Sanctum)
- MariaDB (MySQL)

#### About the project
A geography game which takes you on a journey around the world.
Help students learn geography in a fun way, and entertaining  for adults.

#### Setup
- Create .env file by copying env.example and setting the required params  
- Run: ​ composer install ​
- Create migrations in order with:

    ​ php artisan migrate:all:ordered ​

- Seed the tables:

    ​  php artisan db:seed ​ 
