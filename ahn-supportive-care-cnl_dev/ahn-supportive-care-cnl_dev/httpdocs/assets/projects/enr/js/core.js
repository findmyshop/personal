var ENS = ENS || {};
(function($){
var Core = function(){
  $(document).ready(function(){
    $(window).trigger("resize");
    ENS.core.cssFixes();
    ENS.core.flowHandler();
  });
  $(window).on("resize",function(){
    ENS.core.cssFixes();
  });
  this.cssFixes = function(){

  };
  this.flowHandler = function(){
    /* Latch on to the scope to see if the user has left the flow (Q signifies a USER QUERY) */
    var scope = angular.element("#base_controller").scope();
        scope.$on("responseLoading",function(e,vars){
          if (vars.type == "Q" || vars.type == "RELATED" || vars.response.id == "enr3001"){
            scope.skip_last_response_save = true;
          }else{
            scope.skip_last_response_save = false;
          }
        });
        scope.$on("responseLoaded",function(e,vars){
          if (!(MR.browser.mobile)){
            //make sure we are mobile
          }else{
            if (vars.response.ask_controls.action == 'comment' || vars.response.ask_controls.action == 'multiple_choice'){
              MR.modal.show("#mobile-tests-modal");
            }else{
              MR.modal.hide("#mobile-tests-modal");
            }
          }
          window.setTimeout(function(){
            MR.utils.popover({
              element: "#enr-finish-section",
              type: 'warning',
              placement:'left',
              trigger:'manual',
              title: false,
              content: 'Click to finish this section.'
            });
          }, 1000);
          window.setTimeout(function(){
            MR.utils.popover({
              element: "#mr-return-button",
              type: 'warning',
              placement:'left',
              trigger:'manual',
              title: false,
              content: 'Return to program flow.'
            });
          }, 1000);
          if (vars.response.id == "enr0370" ||
              vars.response.id == "enr0564" ||
              vars.response.id == "enr0469" ||
              vars.response.id == "enr0604"
            ){
            window.setTimeout(function(){
              $(".left-rail-response-list-item a").each(function(){
                var me = $(this);
                if (me.data("rid") == "enr0401" ||
                    me.data("rid") == "enr0501" ||
                    me.data("rid") == "enr0601" ||
                    me.data("rid") == "enr0702"
                    ){
                  if (!me.hasClass("passed")){
                    me.attr("title","");
                    MR.utils.popover({
                      element: me[0],
                      type: 'warning',
                      placement:'right',
                      trigger:'manual',
                      title: false,
                      content: 'Click on another topic.'
                    });
                    return false;
                  }
                }
              });
            },2000);
          }
        });
  };
}//Core
ENS.core = new Core();
})(jQuery);