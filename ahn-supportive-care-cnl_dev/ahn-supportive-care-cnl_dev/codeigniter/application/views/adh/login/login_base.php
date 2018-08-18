<div id="mr-ct-login-area">
<div id="mr-ct-login-video-col" class="col-xs-7 align-center col-1 mr-col ct-login-col">
    <div class="row">
        <h4>I'll be answering your questions about the NODE-1 study.</h4>
    </div>

    <!-- Leave the speaker selection radio button in even though there's only one option -->
    <div style="display:none;">
        <input name="speaker" id="r-doctor" type="radio" value="a" checked="checked"/>
    </div>

    <div>
        <?php get_player(array("control" => true)); ?>

        <!--<div style="padding:10px 15px 10px 15px;margin:5px 0 10px 0;text-align:left;">-->
        <div id="mr-ct-login-instructions-wrapper" class="mr-is-wrapper">
            <div class="mr-is-scroller">
                <p>
                    Thank you for your interest in the Shire ADHD clinical research study.
                    I'm here to answer any questions you may have about clinical trials and participating in this study.
                    Check the box on the right to accept the terms of use and then click the enter site button to access the question area.
                    Let's get started!
                </p>
            </div>
        </div>

        <script type ="text/javascript">
            $(document).ready(function(){
                var playlist = [
                    {type: "video/mp4", src: "https://dlgbztmu5t05i.cloudfront.net/msp_login_512k.mp4"},
                    {type: "rtmp/mp4", src: "https://s2ynnn5q0ulz4i.cloudfront.net/msp_login_512k.mp4"}
                ];

                MR.video.init(playlist);
            });
        </script>
    </div>

</div><!--/.mr-col-->
<div class="col-xs-5 align-center col-2 mr-col ct-login-col">

    <div id="agreement-text" class="mr-is-wrapper">
        <div class="mr-is-scroller">
            <h4>Terms of Use</h4>
            <p><strong>PLEASE READ THESE TERMS OF USE CAREFULLY BEFORE USING THIS SITE.</strong></p>
            <p>By using this site, you signify your agreement to these terms of use. If you do not agree to these terms of use, please do not use this site.</p>
            <p>The videos on this site portray actors and actresses, not actual medical personnel. The content of the pages of this website, including questions and answers is for your general information and use only. It is subject to change without notice. Any answers provided on this site are not intended to replace a conversation with your personal doctor or the study doctor. Any specific questions about your health or participation in this clinical research study should be directed to the study doctor or another member of the study team.</p>
        </div>
    </div>
    <span class="btn btn-lg btn-purple btn-block btn-square btn-phat"><input name="agree" id="r-agree" type="checkbox" value="agree" /> I agree to the terms</span>

    <form autocomplete="off" class="form-signin panel-body" method="POST" onsubmit="return false">
        <!--prevent autocomplete-->
        <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
        <input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />
        <!--/prevent autocomplete-->

        <div class="row" style="text-align:center;">
            <div style="display:inline-block; vertical-align:middle;" class="form-group">
                <button style="padding-left:50px;padding-right:50px;" title="Sign In" class="btn btn-lg btn-primary" type="submit" id="mr-sign-in" onclick="MMG.login.checkOptions(true);">Enter Site</button>
            </div>
        </div>
    </form>


</div><!--/.mr-col-->

</div><!--#mr-ct-login-area-->