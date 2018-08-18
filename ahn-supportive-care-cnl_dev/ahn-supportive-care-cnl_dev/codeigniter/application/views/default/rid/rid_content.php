<div id="mr-col-middle">
  <?php get_player(array("control" => true)); ?>
  <a style="margin-top:5px;" href="javascript:MR.utils.link('#/LRQ/<?php echo $data['response']['id']; ?>');" class="mr-widget btn btn-primary btn-lg btn-block">Click to View in Program</a>
  <?php get_video_text(array("noAjax" => array('title' => $data['response']['name'], 'video_text' => $data['response']['video_text']))); ?>
  <a id="mr-video-mask" title="Click to View in Program" href="javascript:MR.utils.link('#/LRQ/<?php echo $data['response']['id']; ?>');"></a>
</div>

