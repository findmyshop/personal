var NSD = NSD || {};
(function($){
var Core = function(){
  $(document).ready(function(){
    $(window).trigger("resize");
    NSD.core.triggerHelp();
    NSD.core.cssFixes();
    NSD.core.flowHandler();
  });
  $(window).on("resize",function(){
    NSD.core.cssFixes();
  });
  /* Popup for ASL */
  this.triggerHelp = function(){
    $('#mr-video-controls').css('display','table');
    var helpTimer = setTimeout(function(){
      MR.utils.popover({
        element: '#mr-button-asl',
        type: 'info',
        title: 'American Sign Language',
        content: 'Click this button to toggle American Sign Language videos.'
      });
    }, 1500);
    var helpTimer2 = setTimeout(function(){
      $('#mr-video-controls').removeAttr('style');
      $('.popover').each(function(){
        $(this).popover('destroy');
      });
    },6000);
  };
  this.cssFixes = function(){

  };
  this.flowHandler = function(){
    /* Latch on to the scope to see if the user has left the flow (Q signifies a USER QUERY) */
    var scope = angular.element("#base_controller").scope();
        scope.$on("responseLoading",function(e,vars){
          if (vars.type == "Q"){
            scope.skip_last_response_save = true;
          }else{
            scope.skip_last_response_save = false;
          }
        });
  };
}//Core
NSD.core = new Core();
})(jQuery);