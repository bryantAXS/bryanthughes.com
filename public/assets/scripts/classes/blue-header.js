
var BlueHeader = {

};

BlueHeader.load = function(){

  var loaded = $.Deferred();

  setTimeout(function(){

    console.log("go");

    $("[blue-header]").addClass("animated-in");

    setTimeout(function(){
      loaded.resolve();
    }, 500);


  }, 1900);

  return loaded;

};

module.exports = BlueHeader;