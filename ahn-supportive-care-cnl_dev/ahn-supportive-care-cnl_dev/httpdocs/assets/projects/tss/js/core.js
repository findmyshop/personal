var TSS = TSS || {};
(function($){

var Core = function(){
  $(document).ready(function() {
    $(window).trigger("resize");
    TSS.core.cssFixes();
  });
  $(window).on("resize",function() {
    TSS.core.cssFixes();
  });
  /* Used for options buttons in flow */
  this.setChoice = function(t) {
    $(".mr-decision button").each(function() {
      $(this).removeClass('active');
      $(this).find("i").removeClass("glyphicon-ok").addClass("glyphicon-chevron-right");
    });
    $(t).find("i.glyphicon-chevron-right").addClass("glyphicon-ok").removeClass("glyphicon-chevron-right");
    var choice = $(t).attr('data-href');
    $(t).addClass('active');
    $("#mr-choice-submit").attr("href",choice);
    $("#mr-choice-submit").attr("disabled",false);
  }
  this.cssFixes = function(videoTextNumCharacters) {
    var winHeight = $(window).height();
    var winWidth = $(window).width();
    if (winWidth > 767){
      $("#tss-right-col").css("height",$("#tss-left-col").height()+"px");
      $("#tss-right-col").find(".mr-is-wrapper").css("height",$("#tss-left-col").height()+"px");
    }else{
      var availableViewbaleHeight = winHeight -
        $("#mr-header").outerHeight(true) -
        $("#tss-left-col").outerHeight(true) -
        $("#mr-input-row").outerHeight(true) -
        $("#comments-box").outerHeight(true) -
        $(".prev-next-controls").outerHeight(true) -
        $("#mr-footer").outerHeight(true) - 50;

      if(availableViewbaleHeight <= 50) {
        videoTextHeight = "50px";
      } else {
        var videoTextAverageCharacterWidth = 6.9;
        var videoTextLineHeight = 18;
        var videoTextAvailableWidth = $("#video-text-div").width();
        var videoTextNumCharacters = videoTextNumCharacters || $("#video-text-div > .mr-is-scroller > p").text().length;
        var videoTextNumLines = Math.ceil(videoTextNumCharacters * videoTextAverageCharacterWidth / videoTextAvailableWidth);
        var videoTextHeightNeeded = videoTextNumLines * videoTextLineHeight;

        if(videoTextHeightNeeded <= availableViewbaleHeight) {
          videoTextHeight = 30 + videoTextHeightNeeded + "px";
        } else {
          videoTextHeight = 30 + availableViewbaleHeight + "px";
        }
      }
      /*
      console.log(
        "availableViewbaleHeight", availableViewbaleHeight,
        "videoTextAvailableWidth", videoTextAvailableWidth,
        "videoTextNumCharacters", videoTextNumCharacters,
        "videoTextNumLines", videoTextNumLines,
        "videoTextHeightNeeded", videoTextHeightNeeded,
        "videoTextHeight", videoTextHeight
      );
      */
      $("#tss-right-col").css("height", videoTextHeight);
      $("#tss-right-col").find(".mr-is-wrapper").css("height", videoTextHeight);
    }
    var footHeight = 0;
    if (!$("#mr-footer").hasClass("mr-panel-footer")) {
      footHeight = $("#mr-footer").outerHeight(true);
    }

    if($('body').hasClass("base")) {
      var conHeight = winHeight - $("#mr-header").outerHeight(true) - footHeight;
      $("#mr-col-middle").height(conHeight - $("#mr-col-middle").css('marginTop').replace('px', ''));
    }
  }

}//Core
TSS.core = new Core();
})(jQuery);