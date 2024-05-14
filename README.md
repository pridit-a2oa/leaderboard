![Leaderboard](https://github.com/pridit-a2oa/leaderboard/assets/12836049/ec37884e-7876-46d4-a9fd-26893fd12ce5)

# Leaderboard

![ci](https://github.com/pridit-a2oa/leaderboard/actions/workflows/build-image.yml/badge.svg)

At its core, this project integrates game server data to drive the display of a leaderboard.

## Features

-   Full account flow (register, login, update, reset, deletion)
-   Associate a [Steam](https://store.steampowered.com/) user identifier via OpenID with an account
-   Support for linking characters to an account and performing actions
-   Webhook support to associate [Ko-fi](https://ko-fi.com) contributions and allow users to access a set of permission restricted features

## Getting Started

Make a copy of the environment file:

```
cp .env.example .env
```

With [laravel/sail](https://github.com/laravel/sail) start/build the project's containers:

```
sail up -d
```

Run vite:

```
npm run dev
```

### Initial Setup

Generate an application key:

```
sail artisan key:generate
```

Run the migrations and seed database:

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
-   `character_statistic` (character_id, statistic_id) - if used with supporter features

For an example on how this has been integrated using [Arma2NETMySQL](https://arma2netmysqlplugin.readthedocs.io/en/latest/), see the repo [pridit-a2oa/co40_Domination.Takistan](https://github.com/pridit-a2oa/co40_Domination.Takistan).

## Deployment

For ease of use this application can be deployed through [Docker](https://www.docker.com/), as it is already dockerized with support for [SSR](https://inertiajs.com/server-side-rendering) and a [Queue Worker](https://laravel.com/docs/11.x/queues#running-the-queue-worker).

> For non-Docker hosting solutions, such as [Forge](https://forge.laravel.com/), please explore these on your own.

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
> This barebones container does not include mail or database support, and won't work as-is. Check the [.env.example](.env.example) file for applicable environment variables, as this will depend on other containers or the services you want to use (e.g. Mailgun/managed database).

## Issues (SSR)

1. **Link** component v-html directive ignored: [vuejs/core#6435](https://github.com/vuejs/core/issues/6435)
2. [Font Awesome](https://fontawesome.com/) hydration issue using strings: [FortAwesome/vue-fontawesome#394](https://github.com/FortAwesome/vue-fontawesome/issues/394)

## License

This project is licensed under the [MIT License](LICENSE).
