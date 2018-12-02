import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {
  faUser, faLock, faSignOutAlt, faCog, faChevronRight, faChevronLeft, faCheckCircle,
  faFont, faSortUp, faSortDown, faTimesCircle, faBars, faAngleDoubleRight,
  faAngleDoubleLeft
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub, faGoogle
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faChevronRight, faChevronLeft,
  faCheckCircle, faFont, faSortUp, faSortDown, faTimesCircle, faBars,
  faAngleDoubleRight, faAngleDoubleLeft, faGoogle
)

Vue.component('fa', FontAwesomeIcon)
