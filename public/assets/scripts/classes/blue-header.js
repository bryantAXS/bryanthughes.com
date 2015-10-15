
var BlueHeader = {

};

BlueHeader.load = function(){

  var loaded = $.Deferred();

  setTimeout(function(){

    $("[blue-header]").addClass("animated-in");

    setTimeout(function(){
      loaded.resolve();
    }, 500);

  }, 1500);

  return loaded;

};

/**
 * Gettings things configured for no animation
 * @return {[type]} [description]
 */
BlueHeader.noAnimation = function(){

  $("[blue-header]").addClass("animated-in");

};

module.exports = BlueHeader;