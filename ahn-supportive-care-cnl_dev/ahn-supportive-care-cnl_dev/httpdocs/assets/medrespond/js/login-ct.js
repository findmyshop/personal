var MMG = MMG || {};
(function($){
  var Login = function(){
    var $checkAgree = $('#r-agree');
    var $checkDoc = $('#r-doctor');
    var $checkCoo = $('#r-coordinator');
    $(document).ready(function(){
      MMG.login.cssFixes();
      MMG.login.formStuff();
    });
    $(window).on("resize",function(){
      MMG.login.cssFixes();
    });
    this.cssFixes = function(){
      var winHeight = $(window).height();
      var headHeight = $("#mr-header").outerHeight(true);
      var signHeight = $(".row-sign-in").outerHeight(true);
      var footHeight = $('#mr-footer').outerHeight(true);
      var colPad = $(".col-1").outerHeight(true) - $(".col-1").height();
      var newHeight = winHeight - headHeight - signHeight - colPad - footHeight;
      if (newHeight > 500){
        $(".col-1, .col-2").height(newHeight);
      }
    };
    this.formStuff = function(){
      $(".portrait-col input").each(function(){
        $(this).change(function(){
          $(this).parents(".portrait-col").addClass("active");
          $(this).parents(".portrait-col").siblings(".portrait-col").removeClass("active")
        });
      });
      $(".portrait-col, .btn-phat").click(function(e){
        /* We only want to target the parent buttons. Inputs inside function normally */
        if ($(e.target).is("input") || $(this).hasClass("active")){
          return;
        }
        var btn = $(this);
        var input = btn.find("input");
        if (input.prop("checked")){
          input.prop("checked", false );
        }else{
          input.prop("checked", true );
        }
        if ($checkDoc.prop("checked")){
          $checkDoc.parents(".portrait-col").addClass("active");
          $checkCoo.parents(".portrait-col").removeClass("active");
        }
        if ($checkCoo.prop("checked")){
          $checkCoo.parents(".portrait-col").addClass("active");
          $checkDoc.parents(".portrait-col").removeClass("active");
        }
      });
      if ($(".portrait-col").length == 1){
        $(".portrait-col input").click();
      }
    };
    this.checkOptions = function(isGuest){
      if ($checkAgree.prop("checked")){
        if ($checkDoc.prop("checked") || $checkCoo.prop("checked")){
          /* Set Session to know what speaker they chose. */
          var speaker = $('input[name=speaker]:checked').val()
          $.ajax({ type: "POST",
            url: '/'+MR.core.base_url+'login/ajax_set_session_speaker',
            data: {value: speaker},
            dataType: 'json'
          }).success(function(data){
            if (isGuest){
              MR.login.do_login('guest_user');
            }else{
              MR.login.do_login('user');
            }
          });
        }else{
          return MR.utils.alert({type:'error',message:'Please select which speaker you would like to hear from'});
        }
      }else{
        return MR.utils.alert({type:'error',message:'To use this site, you must accept the "Terms of Use"'});
      }
    };
  };
  if ($('body').hasClass('login')){
    MMG.login = new Login();
  }
})(jQuery);