
var FeaturedArticle = {

};

FeaturedArticle.load = function(){

  var loaded = $.Deferred();

  setTimeout(function(){

    $("[featured-article]").addClass("animated-in");

    loaded.resolve();

  }, 500);

  return loaded;

};

FeaturedArticle.loadContent = function(){

  var loaded = $.Deferred();

  setTimeout(function(){

    $("[featured-article] .content").addClass("animated-in");
    loaded.resolve();

  }, 300);

  return loaded;

};

module.exports = FeaturedArticle;