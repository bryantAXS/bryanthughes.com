

/**
 * The class controlling our "Thanks for stopping by text"
 * @type {Object}
 */
var Intro = {

  timings: {
    initialWait: 2000,
    renderText: 4000,
    removeText: 5000,
    pauseBeforeResolving: 500
  }

};

Intro.load = function(){

  var self = this;
  var animationComplete = $.Deferred();
  var introLoaded = $.Deferred();

  if(! $("[intro]").length){
    return;
  }

  setTimeout(function(){

    $("[intro]").addClass("animate-in");

    setTimeout(function(){

      $("[intro]").addClass("animated-in");
      $("[intro]").removeClass("animate-in");
      $("[intro]").addClass("animate-out");

      setTimeout(function(){

        $("[intro]").addClass("show-border");

        setTimeout(function(){

          animationComplete.resolve();

        }, self.timings.pauseBeforeResolving);

      }, self.timings.removeText);

    }, self.timings.renderText);

  }, self.timings.initialWait);

  animationComplete.done(function(){

    $("[intro]").addClass("is-hidden");
    introLoaded.resolve();

  });

  return introLoaded;

};

module.exports = Intro;