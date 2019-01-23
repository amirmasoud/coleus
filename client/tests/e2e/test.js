import { Nuxt, Builder } from 'nuxt'
import { resolve } from 'path'

// We keep a reference to Nuxt so we can close
// the server at the end of the test
let nuxt = null

module.exports = {
  'default' : {
    nuxt : null,
  },

  before : async function(browser, done) {
    const rootDir = resolve(__dirname, '../../../')
    let config = {}
    try { config = require(resolve(rootDir, 'client/nuxt.config.js')) } catch (e) {}
    config.rootDir = rootDir // project folder
    config.dev = false // production build
    config.mode = 'universal' // Isomorphic application
    this.nuxt = new Nuxt(config)
    await new Builder(this.nuxt).build()
    this.nuxt.listen(4000, 'localhost')
    done()
  },

  after : function(browser) {
    this.nuxt.close()
  },

  'Demo test Google' : function (browser) {
    browser
      .url('http://localhost:4000')
      .waitForElementVisible('body')
      .assert.containsText('body', 'حافظ')
      .end()
  }
};
