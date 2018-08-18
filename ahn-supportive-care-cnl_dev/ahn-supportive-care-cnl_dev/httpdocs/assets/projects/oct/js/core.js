var OCT = OCT || {};
(function($){
  var Video = function(){
    this.bound = false;
    $(document).ready(function(){
      var scope = angular.element("#base_controller").scope();
      scope.$on("$locationChangeStart",function(){
        var vId = scope.response.id;
      });
      scope.$on("videoReady",function(){
        if (!OCT.video.bound){
          var p = MR.video.player;
          var ct = p.currentTime();
          var s = [];
          p.on("seek",function(e){
            s = [];
          });
          p.on("timeupdate",function(e){
            /* Get current Video */
            var t = p.currentTime();
            var vId = scope.response.id;
            /* Reset cuepoints if video is at 0s */
            if (Math.round(t) === 0){
              s = [];
            }
            /*Videos and their cuepoints*/
            if (vId == "oct001"){
              //console.log(Math.round(t));
              if (Math.round(t) === 82){
                MR.utils.popover({
                  element: "#input_question",
                  type: 'warning',
                  placement:'top',
                  trigger:'manual',
                  title: false,
                  content: 'Are you ready to get started?'
                });
              }
            }else if (vId == "oct004"){
              //console.log(Math.round(t));
              if (Math.round(t) === 7){
                MR.utils.popover({
                  element: "#input_question",
                  type: 'warning',
                  placement:'top',
                  trigger:'manual',
                  title: false,
                  content: 'Type in the topic you are interested in learning about.'
                });
              }
            }
          });
          this.bound = true;
        }
      });
    });
  };//Video
  var Core = function(){
    $(document).ready(function(){
      $(window).trigger("resize");
      OCT.core.cssFixes();
      OCT.core.flowHandler();
    });
    $(window).on("resize",function(){
      OCT.core.cssFixes();
    });
    this.cssFixes = function(){

    };
    this.flowHandler = function(){
      /* Latch on to the scope to see if the user has left the flow (Q signifies a USER QUERY) */
      var scope = angular.element("#base_controller").scope();
          scope.$on("responseLoading",function(e,vars){
            if (vars.type == "RELATED" || vars.type == "LRQ" || vars.type == "Q" || vars.response.id == 'offtopic'){
              scope.skip_last_response_save = true;
            }else{
              scope.skip_last_response_save = false;
            }
          });
    };
  }//Core
  OCT.core = new Core();
  OCT.video = new Video();
})(jQuery);