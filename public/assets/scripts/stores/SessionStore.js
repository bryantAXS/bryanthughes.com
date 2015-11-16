
'use strict';

var Backbone = require("backbone");
var _ = require("underscore");
var LocalStorage = require("backbone.localstorage");

var SessionStore = Backbone.Model.extend({

  defaults: {
    id: 1,
    hasSeenIntro: false
  },

  localStorage: new LocalStorage("SessionStore"),

});

var sessionStore = new SessionStore();

module.exports = sessionStore;