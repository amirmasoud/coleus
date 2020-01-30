---
title: Async Data
description: You may want to fetch data and render it on the server-side. Nuxt.js adds an `asyncData` method to let you handle async operations before setting the component data.
---

> You may want to fetch data and render it on the server-side.
Nuxt.js adds an `asyncData` method to let you handle async operations before setting the component data.

<div>
  <a href="http://vueschool.io/?friend=nuxt" target="_blank" class="Promote">
    <img src="/async-data-with-nuxtjs.png" srcset="/async-data-with-nuxtjs-2x.png 2x" alt="AsyncData by vueschool"/>
    <div class="Promote__Content">
      <h4 class="Promote__Content__Title">Async Data with Nuxt.js</h4>
      <p class="Promote__Content__Description">Learn how to manage asynchronous data with Nuxt.js.</p>
      <p class="Promote__Content__Signature">Video courses made by VueSchool to support Nuxt.js developpement.</p>
    </div>
  </a>
</div>

## The asyncData Method

Sometimes you just want to fetch data and pre-render it on the server-side without using a store.
`asyncData` is called every time before loading the component (**only for pages components**).
It can be called server-side or before navigating to the corresponding route.
This method receives [the context](/api#context) as the first argument, you can use it to fetch some data and nuxt.js will merge it with the component data.

<div class="Alert Alert--orange">

You do **NOT** have access of the component instance through `this` inside `data` because it is called **before initiating** the component.

</div>

Nuxt.js offers you different ways to use `asyncData`. Choose the one you're the most familiar with:

1. Returning a `Promise`. Nuxt.js will wait for the promise to be resolved before rendering the component.
2. Using the [async/await proposal](https://github.com/lukehoban/ecmascript-asyncawait) ([learn more about it](https://zeit.co/blog/async-and-await))
3. Define a callback as second argument. It has to be called like this: `callback(err, data)`

### Returning a Promise
```js
export default {
  asyncData ({ params }) {
    return axios.get(`https://my-api/posts/${params.id}`)
      .then((res) => {
        return { title: res.data.title }
      })
  }
}
```

### Using async/await
```js
export default {
  async asyncData ({ params }) {
    const { data } = await axios.get(`https://my-api/posts/${params.id}`)
    return { title: data.title }
  }
}
```

### Using a callback
```js
export default {
  asyncData ({ params }, callback) {
    axios.get(`https://my-api/posts/${params.id}`)
      .then((res) => {
        callback(null, { title: res.data.title })
      })
  }
}
```

### Displaying the data

The result from asyncData will be **merged** with data.
You can display the data inside your template like you're used to doing:

```html
<template>
  <h1>{{ title }}</h1>
</template>
```

## The Context

To see the list of available keys in `context`, take a look at the [API Pages data](/api).

### Accessing dynamic route data 

You can use the context object injected into the `asyncData` property to access dynamic route data. For example, dynamic route params can be accessed using the name of the file or folder that configured it. So if you define a file named `_slug.vue`, you can acccess it via `context.params.slug`.

## Handling Errors

Nuxt.js adds the `error(params)` method in the `context`, you can call it to display the error page. `params.statusCode` will be also used to render the proper status code form the server-side.

Example with a `Promise`:
```js
export default {
  asyncData ({ params, error }) {
    return axios.get(`https://my-api/posts/${params.id}`)
      .then((res) => {
        return { title: res.data.title }
      })
      .catch((e) => {
        error({ statusCode: 404, message: 'Post not found' })
      })
  }
}
```

If you're using the `callback` argument, you can call it directly with the error and nuxt.js will call the `error` method for you:
```js
export default {
  asyncData ({ params }, callback) {
    axios.get(`https://my-api/posts/${params.id}`)
      .then((res) => {
        callback(null, { title: res.data.title })
      })
      .catch((e) => {
        callback({ statusCode: 404, message: 'Post not found' })
      })
  }
}
```

To customize the error page, take a look at the [VIEWS layouts section](/guide/views#layouts).