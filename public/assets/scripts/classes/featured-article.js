
var FeaturedArticle = {

};

FeaturedArticle.load = function(){

  var loaded = $.Deferred();

  setTimeout(function(){

    $("body").addClass("containers-animated-in");

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


/**
 * Getting things configured for having no animation
 * @return {[type]} [description]
 */
FeaturedArticle.noAnimation = function(){

  $("[featured-article]").addClass("animated-in");
  $("[featured-article] .content").addClass("animated-in");

};

module.exports = FeaturedArticle;