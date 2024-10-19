![Leaderboard](https://github.com/user-attachments/assets/307b747c-bb00-47e3-a5dc-5cabef32579a)

# Leaderboard

![lint](https://github.com/pridit-a2oa/leaderboard/actions/workflows/coding-standards.yml/badge.svg)
![tests](https://github.com/pridit-a2oa/leaderboard/actions/workflows/tests.yml/badge.svg)

This project integrates game server data to drive the display of a leaderboard, with some additional facilities for logged in users to associate and manage elements of their respective in-game character(s).

## Features

-   Full account flow/lifecycle (register, login, recover, update, delete)
-   Support for linking characters to an account and performing actions
-   [Steam](https://store.steampowered.com/) user identifier (via OpenID) associating with an account (to match characters)
-   [Gravatar](https://gravatar.com) support for overriding character avatars with the one driven via user email instead of Steam
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
sail yarn run dev
```

### Initial Setup

Generate an application key:

```
sail artisan key:generate
```

Run the migrations, which will also seed the database:

```
sail artisan migrate:fresh
```

### Ready

You should now be able to access the application via:

-   http://laravel.test

### Deployment

For ease of use this application can be deployed through [Docker](https://www.docker.com/), as it is already dockerized with support for a [Queue Worker](https://laravel.com/docs/11.x/queues#running-the-queue-worker).

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

## Bridge

As the platform depends on data inserted from an Arma 2: Operation Arrowhead mission there will need to be [SQF](https://community.bistudio.com/wiki/SQF_Syntax) scripting considerations to utilitise the project as intended.

The following tables are used as part of this process:

| Optional | Name                  | Fields                                                                                                                                                                 | Purpose                                       |
| -------- | --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------- |
| ❌       | `characters`          | [guid](https://community.bistudio.com/wiki/getPlayerUID)<br />[name](https://community.bistudio.com/wiki/name)<br />[score](https://community.bistudio.com/wiki/score) | Stores the main data                          |
| ✔️       | `character_statistic` | character_id<br />statistic_id<br /> value                                                                                                                             | Tracking `statistics`                         |
| ✔️       | `model_has_roles`     | role_id<br /> model_id                                                                                                                                                 | Feature access based on a permissions library |

For an example on how this has been integrated into an existing mission using [Arma2NETMySQL](https://arma2netmysqlplugin.readthedocs.io/en/latest/), see the repo [pridit-a2oa/co40_Domination.Takistan](https://github.com/pridit-a2oa/co40_Domination.Takistan).

## SSR

SSR is not fully supported due to outstanding [issues](#issues) and will not work as-is. If you would like to experiment with SSR you can do so by running:

```
yarn run build:ssr
```

```
sail artisan inertia:start-ssr
```

For further information, see [Server-side rendering (SSR) - Inertia.js](https://inertiajs.com/server-side-rendering).

## Issues

1. (SSR) **Link** component v-html directive ignored: [vuejs/core#6435](https://github.com/vuejs/core/issues/6435)
2. (SSR) [Font Awesome](https://fontawesome.com/) hydration mismatch using strings: [FortAwesome/vue-fontawesome#394](https://github.com/FortAwesome/vue-fontawesome/issues/394)
3. [Web Components](https://vuejs.org/guide/extras/web-components) with SSR (missing exports, definitions, bundling) and general limitations (shadow DOM restricting styling)

## Linting

For style fixing [laravel/pint](https://laravel.com/docs/11.x/pint) can be used.

```
./vendor/bin/pint
```

## Testing

> Create a new MySQL database called `testing`

Run the unit/feature tests:

```
sail artisan test
```

Run the browser tests supported by [laravel/dusk](https://laravel.com/docs/11.x/dusk):

```
sail dusk
```

While running Dusk tests Selenium can be observed using noVNC via:

-   http://localhost:7900/?autoconnect=1&resize=scale&password=secret

> [!IMPORTANT]
> Dusk will not work with [Vite](http://localhost:5173/) running, so ensure it is off prior to running this test suite.

## License

This project is licensed under the [MIT License](LICENSE).
