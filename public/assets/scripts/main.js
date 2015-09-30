

/**
 * Some high-level JS includes
 */
window.$ = window.jQuery = require('jquery');
var _ = window._ = require('underscore');
var foundation = require('foundation');



/**
 * Loading in our settings which we're sharing with SCSS
 */
var Settings = require('./built/variables.js');
window.settings = Settings["_variables"];


/**
 * Converting a speed specified in "XXXms" into a number
 * @param  {[type]} speed [description]
 * @return {[type]}       [description]
 */
window.speedToNumber = function(speed){
  return Number(speed.replace("ms", ""));
};


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

/**
 * Starting things up!
 */

$(document).foundation();

$(window).ready(function(){


  Sitewide.init();

  // 1) load in intro
  var introLoaded = $.Deferred();

  // if our constant is set to false, we'll resolve it ourself and skip the intro
  if(! LOAD_INTRO){

    introLoaded.resolve();

  }else{

    introLoaded = Intro.load();

  }

  // Getting things going
  introLoaded.done(function(){

    setTimeout(function(){

      $("[intro]").addClass("is-hidden");
      $("[content]").addClass("is-shown");

      // 2) transition in grey box
      FeaturedArticle.load();

      // 3) animate in blue header / mountains
      var done = BlueHeader.load();

      done.done(function(){

        var featuredArticleDone = FeaturedArticle.loadContent();

        featuredArticleDone.done(function(){
          console.log("aaaa");
          $("[articles-container]").addClass("animated-in");
        });

      });

    }, 1000);

  });

});