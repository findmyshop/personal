<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rid_Controller extends Base_Controller {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

  /* Pretending the RID slug is a method */
  public function _remap($method, $params = array()) {
    if(!USER_AUTHENTICATION_REQUIRED) {
      $this->auth_library->login_anonymous_guest_user();
    }
    $this->index($method);
  }

  public function index($rid) {
    if (!DYNAMIC_META_TAGS){
      show_404();
    }
    log_info(__FILE__, __LINE__, __METHOD__, 'Request');

    if ($rid == 'sitemap.xml'){
      header('Content-type: text/xml');
      /* Sitemap */
      $video_domains = $this->property_model->get_video_domains(MR_PROJECT);
      $responses = $this->index_library->list_responses(MR_PROJECT);
      ob_get_clean();
      echo '<?xml version="1.0" encoding="UTF-8"?>';
      echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
                    xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';
      foreach ($responses as $r){

        if (strlen($r->Content) > 20 && strlen($r->BaseQuestion) > 10){
          echo '<url>';
          echo '<loc>'.site_url().MR_DIRECTORY."rid/".$r['id'].'</loc>';
          if (isset($r->ActorDefaultRelativeStillPath)){
            echo '<image:image>';
              echo '<image:loc>https://'.$video_domains['web_video_domain'].$r->ActorDefaultRelativeStillPath.'</image:loc>';
              echo '<image:caption>'.$r->BaseQuestion.'</image:caption>';
            echo '</image:image>';
          }
          echo '<video:video>';
            echo '<video:content_loc>https://'.$video_domains['web_video_domain'].'/'.$r['id'].'_512k.mp4</video:content_loc>';
            echo '<video:title>'.$r->BaseQuestion.'</video:title>';
            echo '<video:description>'.preg_replace('#<[^>]+>#', ' ', $r->Content).'</video:description>';
          echo '</video:video>';
          echo '</url>';
        }

      }
      echo '</urlset>';
      die;
    }
    if ($rid != 'index'){
      /* Each Response */
      $this->_data['response'] = $this->index_library->get_response($rid);
      if (!$this->_data['response']){
        show_404();
      }else{
        $project_title = $this->property_model->get_title(MR_PROJECT);

        $this->template_library
          ->set_title($project_title)
          ->set_module('Home')
          ->set_using_angularjs(TRUE, 'userApp')
          ->set_timeout_check_interval(60)
          ->build('base/base_index', $this->_data, 'rid/rid_header', 'rid/rid_content');
      }
    }else{
      show_404();
    }


  }

}