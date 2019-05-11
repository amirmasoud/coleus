import Vue from 'vue'

Vue.prototype.$toPersian = n => {
  const digits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹']
  return n.toString().replace(/\d/g, x => digits[x])
}
