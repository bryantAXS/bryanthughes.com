
var FeaturedArticle = {

};

FeaturedArticle.load = function(){

  var loaded = $.Deferred();

  setTimeout(function(){

    console.log("vv");

    $("[featured-article]").addClass("animated-in");

    loaded.resolve();

  }, 500);

  return loaded;

};

FeaturedArticle.loadContent = function(){

  var loaded = $.Deferred();

  setTimeout(function(){

    console.log("aa");

    $("[featured-article] .content").addClass("animated-in");

  }, 300);

  return loaded;

};

module.exports = FeaturedArticle;