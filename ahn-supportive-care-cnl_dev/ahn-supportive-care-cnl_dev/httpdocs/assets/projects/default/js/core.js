ACC = ACC || {};
var ACC = ACC || {};
(function($){
  var Video = function(){
    this.bound = false;
    $(document).ready(function(){
      var scope = angular.element("#base_controller").scope();
      scope.$on("flowplayerReady",function(){
        if (!ACC.video.bound){
          var f = flowplayer();
          var s = [];
          f.bind("seek",function(e,api){
            s = [];
          });
          f.bind("progress",function(e,api,t){
            /* Get current Video */
            var vId = scope.response.id;
            /* Reset cuepoints if video is at 0s */
            if (Math.round(t) === 0){
              s = [];
            }
            /*Videos and their cuepoints*/
            if (vId == "acc002"){
              if (Math.round(t) === 7){
                if (!s[7]){
                  $("#mr-col-left").find(".left-rail-response-link:first-child").popover({animation:true,
                    title: "FAQ's",
                    content:"Please click on 'Test Subject Index' link.",
                    placement:"right",
                    trigger:"manual",
                    delay:100,
                    container:'body'
                  }).popover('show');
                  s[7] = true;
                }
              }
              if (Math.round(t) === 13){
                if (!$("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  $("#resources_dropdown").parent().find(".dropdown-menu > li:nth-child(3)").popover({animation:true,
                    content:"Bug Report Icon",
                    placement:"left",
                    trigger:"manual",
                    delay:100,
                    container:'body'
                  }).popover('show');
                }
                $('#input_question').focus();
              }
              if (Math.round(t) === 15){
                if ($("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  /* Reset all popovers and shit */
                  $("html").trigger("mouseup");
                  $("#resources_dropdown").blur();
                }
                $('#input_question').focus();
              }
            }
            if (vId == "acc003"){
              if (Math.round(t) === 6){
                if (!s[6]){
                  $("#related-questions").find(".related-q:first-child .btn").popover({animation:true,
                    title: "Related Questions",
                    content:"Please click on 'Test Related Questions'",
                    placement:"left",
                    trigger:"manual",
                    delay:100,
                    container:'body'
                  }).popover('show');
                  s[6] = true;
                }
              }
              if (Math.round(t) === 9){
                $("html").trigger("mouseup");
              }
              if (Math.round(t) === 14){
                if (!$("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  $("#resources_dropdown").parent().find(".dropdown-menu > li:nth-child(3)").popover({animation:true,
                    content:"Bug Report Icon",
                    placement:"left",
                    trigger:"manual",
                    delay:100,
                    container:'body'
                  }).popover('show');
                }
                $('#input_question').focus();
              }
              if (Math.round(t) === 16){
                if ($("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  /* Reset all popovers and shit */
                  $("html").trigger("mouseup");
                  $("#resources_dropdown").blur();
                }
                $('#input_question').focus();
              }
            }
            if (vId == "acc005"){
              if (Math.round(t) === 9){
                if (!$("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  $("#resources_dropdown").parent().find(".dropdown-menu > li:nth-child(2)").popover({animation:true,
                    content:"Resources Area",
                    placement:"left",
                    trigger:"manual",
                    delay:1000,
                    container:'body'
                  }).popover('show');
                }
              }
              if (Math.round(t) === 13){
                if ($("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  /* Reset all popovers and shit */
                  $("html").trigger("mouseup");
                  $("#resources_dropdown").blur();
                }
                $('#input_question').focus();
              }
            }
            if (vId == "acc001"){
              if (Math.round(t) === 15){
                if (!$("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  $("#resources_dropdown").parent().find(".dropdown-menu > li:nth-child(3)").popover({animation:true,
                    content:"Bug Report Icon",
                    placement:"left",
                    trigger:"manual",
                    delay:100,
                    container:'body'
                  }).popover('show');
                }
                $('#input_question').focus();
              }
              if (Math.round(t) === 19){
                if ($("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  /* Reset all popovers and shit */
                  $("html").trigger("mouseup");
                  $("#resources_dropdown").blur();
                }
                $('#input_question').focus();
              }
              if (Math.round(t) === 28){
                if (!s[28]){
                  $('#input_question').focus();
                  $("#input_question").popover({animation:true,
                    title:"Attention",
                    content:"Please type 'Am I connected?' into the box.",
                    placement:"top",
                    trigger:"manual",
                    delay:100,
                    container:'body'
                  }).popover('show');
                  s[28] = true;
                }
                $('#input_question').focus();
              }
              if (Math.round(t) === 32){
                /* Reset all popovers and shit */
                if (!$("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                  $("#resources_dropdown").parent().find(".dropdown-menu > li:nth-child(3)").popover({animation:true,
                    content:"Bug Report Icon",
                    placement:"left",
                    trigger:"manual",
                    delay:100,
                    container:'body'
                  }).popover('show');
                }
                $('#input_question').focus();
              }
              if (Math.round(t) === 35){
                if ($("#resources_dropdown").parent(".dropdown").hasClass("open")){
                  $("#resources_dropdown").dropdown("toggle");
                }
                $("html").trigger("mouseup");
                $("#resources_dropdown").blur();
              }
            }
          });
          this.bound = true;
        }
      });
    });
  };//Core
  ACC.video = new Video();
})(jQuery);
