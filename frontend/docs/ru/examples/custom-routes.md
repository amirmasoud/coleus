---
title: Custom Routes
description: Custom Routes example with Nuxt.js
github: custom-routes
livedemo: https://custom-routes.nuxtjs.org
---

## Documentation

> Nuxt.js is based on vue-router and allows you to defined custom routes :rocket:

### Usage

Add your custom routes inside `nuxt.config.js`:
```js
module.exports = {
  router: {
    routes: [
      { path: '/users/:id', component: 'pages/user' }
    ]
  }
}
```

| key  | Optional? | definition |
|------|------------|-----------|
| `path` | **Required** | Route path, it can have dynamic mapping, look at [vue-router documentation](https://router.vuejs.org/en/essentials/dynamic-matching.html) about it. |
| `component` | **Required** | Path to the `.vue` component, if relative, it has to be from the app folder. |
| `name` | Optional | Route name, useful for linking to it with `<router-link>`, see [vue-router documentation](https://router.vuejs.org/en/essentials/named-routes.html) about it. |
| `meta` | Optional | Let you add custom fields to get back inside your component (available in the context via `route.meta`  inside `data` and `fetch` methods). See [vue-router documentation](https://router.vuejs.org/en/advanced/meta.html) about it. |
| `children` | Optional | *Not supported* |

### Hidden pages

>If you want don't want nuxt.js to generate a route for a specific page, you just have to **rename it with _ at the beginning**.

Let's say I have a component `pages/user.vue` and I don't want nuxt.js to create the `/user`. I can rename it to `pages/_user.vue` and voilà!

You can then change the component path in the `nuxt.config.js`:
```js
// ...
  { path: '/users/:id', component: 'pages/_user' }
// ...
```
