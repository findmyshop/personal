var NSD = NSD || {};
(function($){
var Core = function(){
  $(document).ready(function(){
    $(window).trigger("resize");
    NSD.core.cssFixes();
    NSD.core.flowHandler();
  });
  $(window).on("resize",function(){
    NSD.core.cssFixes();
  });
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