![Leaderboard](https://github.com/pridit-a2oa/leaderboard/assets/12836049/f6ab91db-cfdd-4b11-b6fa-814ead8cae4e)

# Leaderboard

![ci](https://github.com/pridit-a2oa/leaderboard/actions/workflows/build-image.yml/badge.svg)

At its core, this project integrates game server data to drive the display of a leaderboard.

## Features

-   Full account flow (register, login, update, reset, deletion)
-   Associate a [Steam](https://store.steampowered.com/) user identifier via OpenID with an account
-   Support for linking characters to an account and performing actions
-   Webhook support to associate [Ko-fi](https://ko-fi.com) contributions and allow users to access a set of permission restricted features

## Install

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

## Issues (SSR)

1. **Link** component v-html directive ignored: [vuejs/core#6435](https://github.com/vuejs/core/issues/6435)
2. [Font Awesome](https://fontawesome.com/) hydration issue using strings: [FortAwesome/vue-fontawesome#394](https://github.com/FortAwesome/vue-fontawesome/issues/394)

## License

This project is licensed under the [MIT License](LICENSE.md).
