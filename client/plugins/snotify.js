import Vue from 'vue'
import Snotify, { SnotifyPosition, SnotifyStyle } from 'vue-snotify'

const options = {
  toast: {
    icon: false,
    pauseOnHover: false,
    showProgressBar: false,
    position: SnotifyPosition.centerBottom,
    type: SnotifyStyle.simple
  },
  global: {
    oneAtTime: true,
    preventDuplicates: true
  }
}

Vue.use(Snotify, options)
