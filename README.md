# Leaderboard

![ci](https://github.com/pridit-a2oa/leaderboard/actions/workflows/build-image.yml/badge.svg)

This project was created using the VILT (Vue, Inertia.js, Laravel, Tailwind) stack. It integrates game server data to drive the display of a leaderboard.

## Features

-   Full authentication flow
-   Associate a [Steam](https://store.steampowered.com/) user identifier (OpenID) with an account
-   Support for linking characters to an account and performing actions
-   Webhook support to associate [Ko-fi](https://ko-fi.com) contributions and allow users to access a set of permission restricted features

## Install

Make a copy of the environment file:

```
cp .env.example .env
```

With [laravel/sail](https://github.com/laravel/sail) scaffold the project using containers:

```
sail up -d && sail npm run dev
```

> For a first time setup, run migrations and seed the database:
>
> ```
> sail artisan migrate && sail artisan db:seed
> ```

## SSR Issues

1. **Link** component v-html directive ignored: [vuejs/core#6435](https://github.com/vuejs/core/issues/6435)
2. **Font Awesome** hydration issue using strings: [FortAwesome/vue-fontawesome#394](https://github.com/FortAwesome/vue-fontawesome/issues/394)
