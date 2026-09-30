# Webman Starter

A PHP 8.3+ starter project built on [Webman](https://webman.workerman.net/). It includes Webman Console, database integrations (Eloquent and Think ORM), Redis, validation, Blade, migrations, and Laravel-style cache, filesystem, HTTP client, and authentication packages.

## Requirements

- PHP 8.3 or newer and Composer
- PHP extensions: `curl`, `dom`, `json`, `pdo`, `zip`, and `redis` (see `composer.json`)
- A database or Redis server only if your application uses those integrations

## Get started

From a checkout of this repository:

```sh
composer install
cp .env.example .env
php start.php start
```

Open <http://127.0.0.1:8787>. The starter's home page is the default Webman welcome page. The HTTP listener is configured in `config/process.php`.

For a background process, use `php start.php start -d`; stop it with `php start.php stop`. Run `php webman list` to see the available console commands.

## Configuration

Copy `.env.example` to `.env` and set values relevant to your application. The environment file is ignored by Git. `APP_URL` and the `AWS_*` values are used by the filesystem configuration in `config/plugin/webman-tech/laravel-filesystem/filesystems.php`; `CACHE_STORE` selects the cache store and defaults to `file`.

The database and Redis connections currently have their own settings in `config/database.php`, `config/think-orm.php`, and `config/redis.php`. Set those files for your services: the `DB_*` and `REDIS_*` entries in `.env.example` are **not** wired into these connection configs. The default database examples point to local MySQL, while Redis defaults to `127.0.0.1:6379`.

Change the timezone in `config/app.php` and the locale in `config/translation.php`. The default view handler is `Raw` in `config/view.php`; configure Blade there if you want to render Blade templates.

## Setup wizard

`composer setup-webman` runs the interactive setup wizard. It lets you choose a locale, timezone, and optional Console, database, Redis, validation, and template packages. It can update `composer.json` by installing selected packages and removing installed components you did not select. It asks for confirmation before removing primary components. Review your selections before running it in an existing project. The wizard is skipped in non-interactive Composer sessions.

## Project layout

| Path | Purpose |
| --- | --- |
| `app/controller/` | HTTP controllers; `IndexController` contains the example actions |
| `app/model/` | Example model |
| `app/view/` | Example view |
| `config/` | Webman and plugin configuration |
| `database/` | Migration and seeder paths used by the migrations plugin |
| `public/` | Public web assets |
| `resource/translations/` | Translation files |
| `runtime/` | Runtime data and logs |

For migration commands, run `php webman list` and look for `migrate:*` and `seed:*`. Configure the database connection before using them.

## Documentation and license

See the [Webman documentation](https://webman.workerman.net/) for framework usage. This project is licensed under the [MIT License](LICENSE).
