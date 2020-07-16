import Vue from 'vue'
import Router from 'vue-router'

import Home from '~/pages/home.vue'
import Books from '~/pages/books.vue'
import Profile from '~/pages/_username/index.vue'
import Parent from '~/pages/_username/_book/_parent/_page.vue'
import Page from '~/pages/_username/_book/_parent/_page/index.vue'

Vue.use(Router)

export function createRouter() {
  return new Router({
    mode: 'history',
    routes: [
      {
        path: '/',
        component: Home,
        name: 'index'
      },
      {
        path: '/books',
        component: Books,
        name: 'books'
      },
      {
        path: '/:username',
        component: Profile,
        name: 'username'
      },
      {
        path: '/:username/:book',
        component: Profile,
        name: 'username-book'
      },
      {
        path: '/',
        component: Parent,
        name: 'username-book-parent',
        children: [
          {
            path: '/:username/:book/:parent/:page+',
            component: Page,
            name: 'username-book-parent-page'
          }
        ]
      }
    ]
  })
}
