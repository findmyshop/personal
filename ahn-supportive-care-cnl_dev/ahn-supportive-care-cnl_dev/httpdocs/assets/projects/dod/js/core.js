DOD = DOD || {};
var DOD = DOD || {};
(function($){
  var Video = function(){
    this.bound = false;
    $(document).ready(function(){
      var scope = angular.element("#base_controller").scope();
      scope.$on("$locationChangeStart",function(){
        var vId = scope.response.id;
        MR.modal.hide('#test-instructions-modal');
      });
      scope.$on("videoReady",function(){
        if (!DOD.video.bound){
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
            if (vId == "asb3_mod2_1"){
              if (Math.round(t) === 836){
               if (!s[836]){
                  p.pause();
                  MR.modal.show('#asb3_did024-modal');
                  $('#asb3_did024-modal').on('hidden.bs.modal', function () {
                    p.play();
                  })
                  s[836] = true;
                }
              }
            }else if (vId == "asb3_mod11_2"){
              if (Math.round(t) === 37){
               if (!s[37]){
                  p.pause();
                  MR.modal.show('#test-instructions-modal');
                  $('#test-instructions-modal').on('hidden.bs.modal', function () {
                    p.play();
                  })
                  s[37] = true;
                }
              }
            }else if (vId == "asb0_9"){
              if (Math.round(t) === 517){
               if (!s[517]){
                  p.pause();
                  MR.modal.show('#test-instructions-modal');
                  $('#test-instructions-modal').on('hidden.bs.modal', function () {
                    p.play();
                  })
                  s[517] = true;
                }
              }
            }
          });
          this.bound = true;
        }
      });
    });
  };//Core
  DOD.video = new Video();
})(jQuery);
