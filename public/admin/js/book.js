/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "./";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 50);
/******/ })
/************************************************************************/
/******/ ({

/***/ 31:
/***/ (function(module, exports) {

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  scopeId,
  cssModules
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  // inject cssModules
  if (cssModules) {
    var computed = options.computed || (options.computed = {})
    Object.keys(cssModules).forEach(function (key) {
      var module = cssModules[key]
      computed[key] = function () { return module }
    })
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 36:
/***/ (function(module, exports, __webpack_require__) {

Vue.component('book-extra', __webpack_require__(45));

var create = new Vue({
    el: '#book',
    data: {}
});

/***/ }),

/***/ 42:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = {
    data: function data() {
        return {
            toAdd: [],
            extraData: [],
            inputName: ''
        };
    },
    props: {
        range: {
            type: String,
            default: 0
        },
        data: {
            type: String
        }
    },
    mounted: function mounted() {
        var json = JSON.parse(this.data);
        this.extraData = Object.keys(json).map(function (key) {
            return [key, json[key]];
        });
    },
    methods: {
        increase: function increase() {
            this.toAdd.push([]);
        },
        decrease: function decrease() {
            this.toAdd.pop();
        },
        removeExistingItems: function removeExistingItems(index) {
            this.extraData.splice(index, 1);
        }
    }
};

/***/ }),

/***/ 45:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(31)(
  /* script */
  __webpack_require__(42),
  /* template */
  __webpack_require__(47),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/Users/amirmasoud/Sites/negarin/resources/assets/js/components/books/Extra.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Extra.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7638b70d", Component.options)
  } else {
    hotAPI.reload("data-v-7638b70d", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 47:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    staticClass: "col-md-2 hidden-sm hidden-xs"
  }), _vm._v(" "), _c('div', {
    staticClass: "col-md-5"
  }, [_c('button', {
    staticClass: "col-btn bg-purple btn btn-sm btn-block",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.increase
    }
  }, [_vm._v("Add")])]), _vm._v(" "), _c('div', {
    staticClass: "col-sm-5"
  }, [_c('button', {
    staticClass: "btn btn-sm btn-warning btn-block",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.decrease
    }
  }, [_c('i', {
    staticClass: "fa fa-minus"
  }), _vm._v(" Pop")])])]), _vm._v(" "), _vm._l((_vm.extraData), function(data, index) {
    return _c('div', [_c('div', {
      staticClass: "form-group"
    }, [_c('div', {
      staticClass: "col-sm-2"
    }, [_c('input', {
      staticClass: "form-control",
      attrs: {
        "type": "text",
        "name": "extra[]",
        "dir": "auto"
      },
      domProps: {
        "value": data[0]
      }
    })]), _vm._v(" "), _c('div', {
      staticClass: "col-sm-9"
    }, [_c('input', {
      staticClass: "form-control",
      attrs: {
        "type": "text",
        "name": "extra[]",
        "dir": "auto"
      },
      domProps: {
        "value": data[1]
      }
    })]), _vm._v(" "), _c('div', {
      staticClass: "col-sm-1"
    }, [_c('button', {
      staticClass: "btn btn-warning pull-left",
      attrs: {
        "type": "button"
      },
      on: {
        "click": function($event) {
          _vm.removeExistingItems(index)
        }
      }
    }, [_c('i', {
      staticClass: "fa fa-minus"
    })])])])])
  }), _vm._v(" "), _vm._l((_vm.toAdd), function(item, index) {
    return _c('div', [_c('div', {
      staticClass: "form-group"
    }, [_c('div', {
      staticClass: "col-sm-2"
    }, [_c('input', {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: (_vm.inputName),
        expression: "inputName"
      }],
      staticClass: "form-control",
      attrs: {
        "type": "text",
        "name": "extra[]",
        "dir": "auto"
      },
      domProps: {
        "value": (_vm.inputName)
      },
      on: {
        "input": function($event) {
          if ($event.target.composing) { return; }
          _vm.inputName = $event.target.value
        }
      }
    })]), _vm._v(" "), _c('div', {
      staticClass: "col-sm-10"
    }, [(_vm.inputName == 'file') ? _c('input', {
      staticClass: "form-control",
      attrs: {
        "type": "file",
        "name": "extra[]"
      }
    }) : _c('input', {
      staticClass: "form-control",
      attrs: {
        "type": "text",
        "name": "extra[]"
      }
    })])])])
  })], 2)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-7638b70d", module.exports)
  }
}

/***/ }),

/***/ 50:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(36);


/***/ })

/******/ });