<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Installation

1. Simply run `docker-compose build` inside a machine which supports docker.
    * This will install the needed php extensions and packages, set correct permissions and working directory.
2. Start the containers using `docker-composer up`, the app is using nginx to run.
3. Make sure to run `composer install` and `npm install` and `npm run build` inside the container
4. Run the migrations to populate the database with tables using the command:
    * `php artisan migrate`
5. Access the project's first page.
    * `https://localhost`
6. Register a user using the Registration page.
7. After a successful login, navigate to Playlists, add a new playlist using the spotify Playlist-ID.
8. To add the songs, enter the playlist details page and click the Load songs button, only then the application will ask spotify for the songs.

## Important

To be able to use the search function, make sure to Import the models into the search index:
1. Run scout:import
  - for playlists run `php artisan scout:import "App\Models\Playlist"`
  - for songs run `php artisan scout:import "App\Models\Song"`
2. Make sure to have a worker running to process the imports from the queue.
   - `php artisan queue:work`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
