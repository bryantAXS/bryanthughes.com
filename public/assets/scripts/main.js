
"use strict";

global.$ = global.jQuery = require('jquery');
global._ = window._ = require('underscore');

require("./foundation-init");
require("jquery.transit");

/**
 * Some high-level JS includes
 */
var SessionStore = require('./stores/SessionStore');

/**
 * All our Components
 */
var Sitewide = require('./classes/sitewide.js');
var Intro = require('./classes/intro.js');
var FeaturedArticle = require('./classes/featured-article.js');
var BlueHeader = require('./classes/blue-header.js');

//
// CONSTANTS
//
var LOAD_INTRO = false;
var NO_ANIMATION = false;

/**
 * Starting things up!
 */

var sessionLoaded = SessionStore.fetch();

$(document).foundation();

$(window).ready(function(){

  Sitewide.init();

  // 1) load in intro
  var introLoaded = $.Deferred();

  sessionLoaded.always(function(){

    // if our constant is set to false, we'll resolve it ourself and skip the intro
    if(SessionStore.get("hasSeenIntro") && LOAD_INTRO !== true){
      introLoaded = Intro.showBorder();
    }else{
      introLoaded = Intro.load();
      SessionStore.set("hasSeenIntro", true);
      SessionStore.save();
    }

    // Getting things going
    introLoaded.done(function(){

      if(NO_ANIMATION){

        // getting everything in place at ONCE -- just for slicing
        $("[intro]").addClass("is-hidden");
        $("[content]").addClass("is-shown");
        FeaturedArticle.noAnimation();
        BlueHeader.noAnimation();
        $("[articles-container]").addClass("animated-in");

      }else{

        $("body").addClass("intro-animated-in");
        $("[intro]").addClass("is-hidden");
        $("[content]").addClass("is-shown");

        setTimeout(function(){

          // 2) transition in grey box
          FeaturedArticle.load();

          // 3) animate in blue header / mountains
          var done = BlueHeader.load();

          done.done(function(){

            var featuredArticleDone = FeaturedArticle.loadContent();

            featuredArticleDone.done(function(){
              $("body").addClass("content-animated-in");
            });

          });

        }, 100);

      }

    });

  });

});
