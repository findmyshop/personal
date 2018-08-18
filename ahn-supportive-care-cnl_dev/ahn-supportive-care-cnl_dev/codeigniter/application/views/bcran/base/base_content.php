<div id="mr-col-left" class="col-xs-3 mr-col">
	<div class="mr-widget mr-button-widget">
		<a class="btn btn-primary btn-block" target="_blank" href="http://www.upmccancercenter.com/research/clinTrials.cfm">Clinical Trials at UPMC CancerCenter</a>
	</div>
	<?php get_left_rail(); ?>
	<div class="mr-widget mr-button-widget">
		<div class="panel-heading">Our Sponsors:</div>

		<ul class="panel-body">
			<li class="list-group-item">
				<span class="sponsor-content">
					<img src="/assets/projects/bcran/images/susan-g-komen-pittsburgh-logo.jpg" height="50" />
				</span>
			</li>
		</ul>


	</div>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
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
			<div class="mr-widget mr-button-widget">
				<a class="btn btn-primary btn-block" href="mailto:steelbx@upmc.edu">Contact UPCI About <br/ >Joining a Clinical Trial</a>
			</div>
			<div class="mr-widget">
				<div class="panel-heading">Five Trials Actively Recruiting</div>
					<div class="panel-body">
						<ul>
							<li>
								<a href="https://clinicaltrials.gov/ct2/show/NCT02296801" target="_blank">HER2-, ER- (Neo-adjuvant)</a>
							</li>
							<li>
								<a href="https://clinicaltrials.gov/ct2/show/NCT02206984" target="_blank">Invasive Lobular Cancer (ILC)</a>
							</li>
							<li>
								<a href="https://clinicaltrials.gov/ct2/show/NCT02555657" target="_blank">Metastatic Triple Negative Breast Cancer</a>
							</li>
							<li>
								<a href="https://clinicaltrials.gov/ct2/show/NCT02032823" target="_blank">Metastatic Triple Negative Breast Cancer, BRCA+</a>
							</li>
							<li>
								<a href="https://clinicaltrials.gov/ct2/show/NCT02236000" target="_blank">Metastatic HER2-Positive Breast Cancer</a>
							</li>
						</ul>
				</div>
			</div>
		</div>
	</div>
</div><!--/.mr-col-->
