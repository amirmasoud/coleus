import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import { HasError, AlertError, AlertSuccess } from 'vform'

import Login from './auth/Login'
import NewBook from './books/New'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  Login,
  NewBook
].forEach(Component => {
  Vue.component(Component.name, Component)
})
