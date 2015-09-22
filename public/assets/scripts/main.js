window.$ = window.jQuery = require('jquery');
var _ = window._ = require('underscore');
var foundation = require('foundation');

var Sitewide = require('./classes/sitewide.js');
var Intro = require('./classes/intro.js');
var FeaturedArticle = require('./classes/featured-article.js');
var BlueHeader = require('./classes/blue-header.js');

$(document).foundation();

$(window).ready(function(){

  Sitewide.init();

  // 1) load in intro
  var introLoaded = Intro.load();

  introLoaded.done(function(){

    $("[content]").addClass("is-shown");

    // 2) transition in grey box
    FeaturedArticle.load();

    // 3) animate in blue header / mountains
    var done = BlueHeader.load();

    done.done(function(){
      console.log("asdf");
      FeaturedArticle.loadContent();
    });

  });

});