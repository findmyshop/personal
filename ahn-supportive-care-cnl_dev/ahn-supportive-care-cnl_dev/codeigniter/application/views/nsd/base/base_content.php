<div id="mr-col-left" class="col-xs-3 mr-col">
<div class="mr-widget mr-phone-widget">
		<div class="panel-heading">Important Numbers</div>
		<div class="panel-body">
			<ul>
				<li>
					<strong>OptumHealth Crisis Line</strong>
					<br/><a class="tel" href="tel://1-888-724-7240">1-888-724-7240</a>
					<br/><a href="http://www.suicidepreventionlifeline.org/GetHelp/LifelineChat.aspx" target="_blank">OptumHealth Live Crisis Chat</a>
				</li>
				<li>
					<strong>Suicide Prevention Lifeline</strong>
					<br/><a class="tel" href="tel://1-800-273-TALK">1-800-273-TALK (8255)</a>
				</li>
				<li>
					<strong>211 San Diego</strong>
					<br/><a class="tel" href="tel://211">Dial 211</a>
				</li>
			</ul>
		</div>
	</div>
	<?php get_left_rail(); ?>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
		<?php get_ask_controls(array("navigation" => true, "ui" => true, "size" => 'medium')); ?>
	<?php get_video_text(array("share" => true)); ?>
</div><!--/#middle-col-->
<div id="mr-col-right" class="col-xs-3 mr-col">
	<div id="related-questions" class="mr-is-wrapper">
		<div class="mr-is-scroller">
			<?php /* <div class="mr-widget mr-options-widget" class="returning-user-buttons" ng-show="returningUser != 'false' || skip_last_response_save == true">
				<div class="panel-heading">Options:</div>
				<div class="panel-body">
					<button class="btn btn-primary btn-block" type="button" ng-click="load_returning_user_state();">Return where you left off</button>
					<a href="#/LRQ/<?php get_welcome_video(); ?>" class="btn btn-primary btn-block">Return to the beginning</a>
				</div>
			</div> */ ?>
			<?php get_related_questions(array('button' => false)); ?>
			<div class="mr-widget mr-playlist-widget" ng-hide="response.playlists < 1">
				<div class="panel-heading">Related Conversations</div>
				<div class="panel-body">
					<div class="playlist-c" ng-repeat="playlist in response.playlists" title="{{ playlist.display_text }}">
						<a href="#/RELATED/{{playlist.id}}/{{response.id}}/{{response.video_controls.next_id}}" class="mr-playlist-thumbnail-loader">
							<img title="{{ playlist.actor_name }}" alt="{{ playlist.actor_name }}" class="mr-playlist-thumbnail" ng-src="{{playlist.actor_image}}"/>
							<div class="mr-icon-play"></div>
							<div class="mr-icon-film"></div>
						</a>
						<p class="mr-playlist-text">{{ playlist.display_text }}</p>
						<div style="clear:both;"></div>
					</div>
				</div>
			</div>
			<?php get_survey(); ?>
		</div>
	</div>
</div><!--/.mr-col-->
