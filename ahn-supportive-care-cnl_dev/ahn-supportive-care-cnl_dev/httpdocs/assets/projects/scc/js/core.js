var SCC = SCC || {};
(function($){
var Core = function(){
  $(document).ready(function(){
    $(window).trigger("resize");
    SCC.core.cssFixes();
    SCC.core.flowHandler();
  });
  $(window).on("resize",function(){
    SCC.core.cssFixes();
  });
  this.cssFixes = function(){

  };
  this.flowHandler = function(){
    /* Latch on to the scope to see if the user has left the flow (Q signifies a USER QUERY) */
    var scope = angular.element("#base_controller").scope();
        scope.$on("responseLoaded",function(e,vars){
          if (vars.response.id == "scc129"){
            window.setTimeout(function(){
              $(".left-rail-direct-link a").each(function(){
                var me = $(this);
                if (me.data("rid") == "scc213"){
                    me.attr("title","");
                    MR.utils.popover({
                      element: me[0],
                      type: 'warning',
                      placement:'right',
                      trigger:'manual',
                      title: false,
                      content: 'Click here if you would like to review the three main options for care.'
                    });
                    return false;
                }
              });
            },2000);
          }
        });
  };
}//Core
SCC.core = new Core();
})(jQuery);