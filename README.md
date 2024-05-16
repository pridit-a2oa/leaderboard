![Leaderboard](https://github.com/pridit-a2oa/leaderboard/assets/12836049/ec37884e-7876-46d4-a9fd-26893fd12ce5)

# Leaderboard

![ci](https://github.com/pridit-a2oa/leaderboard/actions/workflows/build-image.yml/badge.svg)

At its core, this [Laravel](https://laravel.com/) project integrates game server data to drive the display of a leaderboard.

## Features

-   Full account flow/lifecycle (register, login, recover, update, delete)
-   Support for linking characters to an account and performing actions
-   [Steam](https://store.steampowered.com/) user identifier (via OpenID) associating with an account (to match characters)
-   [Ko-fi](https://ko-fi.com) webhook support to associate contributions and allow users to access a set of permission restricted features

## Getting Started

Make a copy of the environment file:

```
cp .env.example .env
```

With [laravel/sail](https://laravel.com/docs/11.x/sail) start/build the project's containers:

```
./vendor/bin/sail up -d
```

> For the remaining steps `sail` acts as an alias of `./vendor/bin/sail`

Run vite:

```
sail npm run dev
```

### Initial Setup

Generate an application key:

```
sail artisan key:generate
```

Run the migrations and seed the database:

```
sail artisan migrate && sail artisan db:seed
```

### Ready

You should now be able to access the application via:

-   http://localhost

## Bridge

As the platform depends on data inserted from an Arma 2: Operation Arrowhead mission there will need to be [SQF](https://community.bistudio.com/wiki/SQF_Syntax) scripting considerations to utilitise the project as intended.

The following tables are used as part of this process:

-   `characters` ([uid](https://community.bistudio.com/wiki/getPlayerUID), [name](https://community.bistudio.com/wiki/name), [score](https://community.bistudio.com/wiki/score))
    -   _minimum for basic function_
-   `character_statistic` (character_id, statistic_id, value)
    -   _for tracking additional statistics_
-   `model_has_roles` (role_id, model_id)
    -   _for determining feature access based on a permissions library_

For an example on how this has been integrated into an existing mission using [Arma2NETMySQL](https://arma2netmysqlplugin.readthedocs.io/en/latest/), see the repo [pridit-a2oa/co40_Domination.Takistan](https://github.com/pridit-a2oa/co40_Domination.Takistan).

## Deployment

For ease of use this application can be deployed through [Docker](https://www.docker.com/), as it is already dockerized with support for [SSR](https://inertiajs.com/server-side-rendering#running-the-ssr-server) and a [Queue Worker](https://laravel.com/docs/11.x/queues#running-the-queue-worker).

> For non-Docker hosting solutions, such as [Forge](https://forge.laravel.com/), please explore these on your own (with the above considerations).

Build the image:

```
docker build . -t leaderboard
```

Start the container:

```
docker run -d \
    --name leaderboard \
    --restart unless-stopped \
    -e KOFI_TOKEN=<OPTIONAL> \
    -e STEAM_AUTH_API_KEYS=<OPTIONAL> \
    -p 8080:8080 \
    leaderboard
```

> [!IMPORTANT]  
> This barebones container does not include mail or database support, and won't work as-is. Check the [.env.example](.env.example) file for applicable environment variables, as this will vary depending on other containers or the services you want to use (e.g. Mailgun/managed database).

## Linting

For style fixing [laravel/pint](https://laravel.com/docs/11.x/pint) can be used.

```
./vendor/bin/pint
```

## Issues (SSR)

1. **Link** component v-html directive ignored: [vuejs/core#6435](https://github.com/vuejs/core/issues/6435)
2. [Font Awesome](https://fontawesome.com/) hydration mismatch using strings: [FortAwesome/vue-fontawesome#394](https://github.com/FortAwesome/vue-fontawesome/issues/394)

## License

This project is licensed under the [MIT License](LICENSE).
