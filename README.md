# Dream DB II - Práctica 2 de Bases de Datos II

## Development

```bash
# Create project
composer create-project laravel/laravel dreamdb2

# Create key
php artisan key:generate --ansi

# Install dependencies
composer install

# In case of error
composer dump-autoload
# or
composer update
# then
composer install

# Start server
php artisan serve
```

## Database

```bash
# Migration
php artisan migrate

# Seed (optional)
php artisan db:seed
```

## Routes (TODO)

### Users

```bash
{user}/ # GET perfil de usuario (nombre usuario)
{user}/edit # POST editar perfil de usuario (nombre usuario, datos personales)
{user}/update # POST actualizar perfil de usuario (nombre usuario, datos personales)
{user}/delete # POST eliminar perfil de usuario (nombre usuario)
{user}/inbox # GET mensajes recibidos de usuario (nombre usuario)
# --- Creo que no hace falta --- #
{user}/inbox/send # POST enviar mensaje a usuario (nombre usuario, nombre usuario destino, texto)
{user}/inbox/delete # POST eliminar mensaje de usuario (nombre usuario, id mensaje)
# ------------------------------ #
{user}/followers # GET seguidores usuario (nombre usuario)
{user}/following # GET seguidos por el usuario (nombre usuario)
{user}/follow # POST seguir usuario (nombre usuario, nombre usuario a seguir)
{user}/unfollow # POST dejar de seguir usuario (nombre usuario, nombre usuario a dejar de seguir)
{user}/publications # GET publicaciones de usuario (nombre usuario)
{user}/publications/following # GET publicaciones de usuarios seguidos por el usuario (nombre usuario)
{user}/publications/create # POST crear publicación (nombre usuario, texto)
{user}/publications/delete # POST eliminar publicación (nombre usuario, id publicación)
{user}/publications/share # POST compartir publicación (nombre usuario, id publicación)
{user}/publications/comments # GET comentarios de publicación (id publicación)
{user}/publications/comments/create # POST crear comentario (id publicación, nombre usuario, texto)
{user}/publications/comments/delete # POST eliminar comentario (id comentario)
{user}/publications/stories # GET historias de usuario (nombre usuario)
{user}/publications/stories/create # POST crear historia (nombre usuario, texto)
{user}/publications/stories/delete # POST eliminar historia (nombre usuario, id historia)
```

### Social Media (App)

```bash
login/ # POST login usuario (nombre usuario, contraseña y datos personales)
register/ # POST registro usuario (nombre usuario y contraseña)
```

# Laravel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Cubet Techno Labs](https://cubettech.com)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[Many](https://www.many.co.uk)**
-   **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
-   **[DevSquad](https://devsquad.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[OP.GG](https://op.gg)**
-   **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
-   **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
