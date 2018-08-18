var CNL = CNL || {};
(function($){
var Core = function(){
  $(document).ready(function(){
    $(window).trigger("resize");
    CNL.core.cssFixes();
    CNL.core.flowHandler();
  });
  $(window).on("resize",function(){
    CNL.core.cssFixes();
  });
  this.cssFixes = function(){

  };
  this.flowHandler = function(){
    /* Latch on to the scope to see if the user has left the flow (Q signifies a USER QUERY) */
    var scope = angular.element("#base_controller").scope();
        scope.$on("responseLoading",function(e,vars){
          console.log(vars.type, 'type')
          if (vars.type == "Q" || vars.type == "RELATED" || vars.type == "LRQ"){
            console.log('show show last response')
            scope.skip_last_response_save = true;
          }else{
            scope.skip_last_response_save = false;
          }
        });
  };
}//Core
CNL.core = new Core();
})(jQuery);