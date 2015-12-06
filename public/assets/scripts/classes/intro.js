

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
  },

  $loaded: $.Deferred()

};

Intro.load = function(){

  var self = this;

  // initial wait
  setTimeout(function(){

    $("[intro]").addClass("animate-in");

    // time to render in all the text
    setTimeout(function(){

      $("[intro]").addClass("animated-in");
      $("[intro]").removeClass("animate-in");
      $("[intro]").addClass("animate-out");

      // time to remove all the text
      setTimeout(function(){

        self.showBorder();

      }, self.timings.removeText);

    }, self.timings.renderText);

  }, self.timings.initialWait);

  return this.$loaded;

};

Intro.showBorder = function(){

  var self = this;
  $("body").addClass("show-border");

  // time to animate the border and resolve the intro animation
  setTimeout(function(){

    self.$loaded.resolve();

  }, self.timings.pauseBeforeResolving);

  return self.$loaded;

};

module.exports = Intro;