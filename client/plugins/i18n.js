import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n, {
  inject: true
})

const i18n = new VueI18n({
  locale: 'fa',
  messages: {}
})

export default async ({ app }) => {
  if (process.client) {
    await loadMessages('fa')
  }

  app.i18n = i18n
}

/**
 * @param {String} locale
 */
export async function loadMessages (locale) {
  if (Object.keys(i18n.getLocaleMessage(locale)).length === 0) {
    const messages = await import(/* webpackChunkName: "lang-[request]" */ `~/lang/${locale}`)
    i18n.setLocaleMessage(locale, messages)
  }

  if (i18n.locale !== locale) {
    i18n.locale = locale
  }
}
