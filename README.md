# Leaderboard

![ci](https://github.com/pridit-a2oa/leaderboard/actions/workflows/build-image.yml/badge.svg)

Laravel 11 w/ Inertia.js leaderboard system

## Install

```
sail up -d
```

```
sail npm run dev
```

```
sail php artisan db:seed
```

## SSR Issues

1. **Link** component v-html directive ignored: [vuejs/core#6435](https://github.com/vuejs/core/issues/6435)
2. **Font Awesome** hydration issue using strings: [FortAwesome/vue-fontawesome#394](https://github.com/FortAwesome/vue-fontawesome/issues/394)
