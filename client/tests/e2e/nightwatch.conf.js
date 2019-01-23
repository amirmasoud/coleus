require('babel-core/register');
const fs = require("fs");

module.exports = ((settings) => {
  return settings;
})(require('../../../nightwatch.json'));
