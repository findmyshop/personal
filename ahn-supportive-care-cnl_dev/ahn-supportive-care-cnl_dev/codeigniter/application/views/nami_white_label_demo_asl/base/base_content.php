<div id="mr-col-left" class="col-xs-3 mr-col">
	<div class="mr-widget">
		<div ng-switch="show_asl_video">
			<div ng-switch-when="false">
				<div style="font-size:12px;" class="panel-heading">American Sign Language Videos Available</div>
			</div>
			<div ng-switch-when="true">
				<div style="font-size:12px;" class="panel-heading">English Videos Available</div>
			</div>
		</div>
		<div class="panel-body">
			<table id="video-language-instructions-table">
				<tr>
					<td><div id="american-sign-language-interpreting-icon-wrapper"><i id="american-sign-language-interpreting-icon" class="fa fa-american-sign-language-interpreting"></i></div></td>
					<td>To switch between ASL and English videos, click on the ASL icon below the video.</td>
				</tr>
			</table>
		</div>
	</div>
	<?php get_left_rail(); ?>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true, "overlay_player_controls" => false)); ?>
		<?php get_ask_controls(array("navigation" => true, "ui" => true, "size" => 'medium')); ?>
	<?php get_video_text(array("share" => true)); ?>
</div><!--/#middle-col-->
<div id="mr-col-right" class="col-xs-3 mr-col">
	<div id="related-questions" class="mr-is-wrapper">
		<div class="mr-is-scroller">
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
			<div class="mr-widget">
				<div class="panel-heading">License ASLanswers for your Organization</div>
					<div class="panel-body">
						<p style="padding:10px;">
							To learn how your organization can license this program, please contact Charlie Hearn at <a href="mailto:charlieh@aslconversations.com">charlieh@aslconversations.com</a> or <a href="tel:+19494388825">949-438-8825</a>.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!--/.mr-col-->
