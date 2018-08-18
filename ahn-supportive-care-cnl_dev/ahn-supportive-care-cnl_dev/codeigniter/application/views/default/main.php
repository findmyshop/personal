<!DOCTYPE html>
<html
        data-ua-name="<?php echo get_ua('name'); ?>"
        data-ua-version="<?php echo get_ua('version'); ?>"
        data-ua-trident="<?php echo get_ua('trident'); ?>"
        data-ua-mobile="<?php echo get_ua('mobile'); ?>"
        data-mr-ask-length="<?php echo MR_ASK_LENGTH; ?>"
        data-mr-base-url="<?php echo MR_DIRECTORY; ?>"
        data-mr-url="<?php echo base_url(); ?>"
        data-mr-idle-time="<?php echo MR_IDLE_TIME; ?>"
        data-mr-project="<?php echo MR_PROJECT; ?>"
        data-mr-type="<?php echo MR_TYPE; ?>"
        data-mr-rid="<?php echo $data['response']['id']; ?>"
        data-mr-title="<?php echo $page['title']; ?>"
        data-mr-seo="<?php echo DYNAMIC_META_TAGS; ?>"
        data-mr-title="<?php echo $page['title']?>"
        data-facebook-app-id="<?php echo FACEBOOK_APP_ID; ?>"
        lang="en"<?php echo (!empty($page['using_angularjs'])) ? (' ng-app' . (!empty($page['angularjs_app']) ? ('="' . $page['angularjs_app'] . '" id="ng-app"') : '')) : ''?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <meta name="description" content="<?php get_meta_description($data['response']['id']); ?>" />
        <meta name="author" content="" />

        <?php if(!USER_AUTHENTICATION_REQUIRED && FACEBOOK_APP_ID && $page['body_class'] == 'rid'): ?>
            <?php
                $facebook_title = get_base_question($data['response']['id']);
                $facebook_description = get_question_content($data['response']['id']);

                if(empty($facebook_title)) {
                    $facebook_title = $page['title'];
                }

                if(empty($facebook_description)) {
                    $facebook_description = '';
                }
            ?>

            <meta property="fb:app_id" content="<?php echo FACEBOOK_APP_ID; ?>" />
            <meta property="og:type" content="website" />
            <meta property="og:site_name" content="<?php echo $page['title']?>" />
            <meta property="og:title" content="<?php echo $facebook_title; ?>" />
            <meta property="og:description" content="<?php echo $facebook_description; ?>" />
            <meta property="og:url" content="<?php echo base_url(); ?>rid/<?php echo $data['response']['id']; ?>" />
            <meta property="og:image" content="<?php echo config_item('facebook_share_image'); ?>" />
            <meta property="og:locale" content="en_US" />
        <?php endif; ?>


        <?php if(SITE_VERIFICATION): ?>
            <meta name="google-site-verification" content="<?php echo SITE_VERIFICATION; ?>" />
        <?php endif; ?>

        <title>
        <?php
         if ($data['response']['name']) {
            echo $data['response']['name'] . " - ";
         }else{
            echo !empty($page['module']) ? $page['module'] . ' - ' : "";
         }
            echo $page['title'];
        ?>
        </title>

        <?php if(IFRAME_WHITELIST_DEFINED): ?>
        <script type="text/javascript">
            iframe_whitelist = '<?php echo implode(',', $iframe_whitelist); ?>';
        </script>
        <?php endif; ?>

        <?php get_assets($page['assets'], array("position" => "header", "show" => $page['body_class'])); ?>

        <?php if(IFRAME_WHITELIST_DEFINED): ?>
        <style id="anti_click_jack">
            body { display:none !important; }
        </style>
        <?php endif; ?>

    </head>
    <body class="<?php echo preg_replace('!\s+!', ' ', $page['body_class'].' '.get_environment(false).' '.get_ua('class').' '.get_ua('mobile').' '.MR_TYPE); ?>">

        <?php if(!USER_AUTHENTICATION_REQUIRED && FACEBOOK_APP_ID && $page['body_class'] == 'base'): ?>
            <div id="fb-root"></div>
            <script>
                window.fbAsyncInit = function() {
                    FB.init({
                        appId      : '<?php echo FACEBOOK_APP_ID; ?>',
                        status     : false,
                        xfbml      : false,
                        version    : 'v2.7'
                    });
                };

                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
        <?php endif; ?>

        <?php
        /* Get the Stage from template */
        echo $this->load->view("/$stage");
        ?>

        <?php
        /* Load Global Modals */
        echo $this->load->view("/default/global_modals");
        /* Load default modals */
        if (file_exists(APPPATH."views/default/".strtolower($this->router->fetch_class())."/".strtolower($this->router->fetch_class())."_modals.php")){
            echo $this->load->view("/default/".strtolower($this->router->fetch_class())."/".strtolower($this->router->fetch_class())."_modals");
        }
        if (file_exists(APPPATH."views/default_".MR_TYPE."/".strtolower($this->router->fetch_class())."/".strtolower($this->router->fetch_class())."_modals.php")){
            echo $this->load->view("/default_".MR_TYPE."/".strtolower($this->router->fetch_class())."/".strtolower($this->router->fetch_class())."_modals");
        }
        /* Load project specific modals */
        if (file_exists(APPPATH."views/$project/".strtolower($this->router->fetch_class())."/".strtolower($this->router->fetch_class())."_modals.php")){
            echo $this->load->view("/$project/".strtolower($this->router->fetch_class())."/".strtolower($this->router->fetch_class())."_modals");
        }
        ?>

        <?php
        /* Indexer Area Icon */
        if (is_admin() && $page['body_class'] == 'admin') : ?>
            <a id="mr-indexer-icon" href="javascript:MR.modal.show('#about-modal');"><i class="glyphicon glyphicon-info-sign"></i></a>

        <?php endif;
        /* Footer JS */
        get_assets($page['assets'], array("position" => "footer", "show" => $page['body_class']));
        ?>

        <?php if(ENVIRONMENT === 'production' &&  is_medrespond_ip_address() === false && ANALYTICS_ID !== false) : ?>
        <script type="text/javascript">
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', '<?php echo ANALYTICS_ID ?>', 'auto');
            ga('send', 'pageview');

        </script>
        <?php endif; ?>
    </body>
</html>
