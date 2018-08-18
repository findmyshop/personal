	<div class="panel panel-default registration-panel" ng-model="disclaimer_accepted" load-active-course>
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-12">
					<h1 class="panel-title">Disclosure</h1>
				</div>
			</div>
		</div>
			<div class="panel-body" style="overflow-y:auto;">
						<div class="row">
						<div class="col-xs-1 text-center">
						</div>
						<div class="col-xs-10 text-left">
							<h3>Welcome to the {{active_course.course_name}} program!</h3>
							<p>AlcoholSBIRT (Screening, Brief Intervention and Referral to Treatment) training is part of an initiative within the Department of Defense to identify and address risky alcohol use and provide health care for the whole person in the Patient Centered Medical Home.</p>
							<p ng-show="active_course.course_id==1">This AlcoholSBIRT training teaches primary care practitioners to comfortably screen individuals for risky alcohol use, briefly counsel patients about the health consequences of risky use, and link individuals needing additional services to their Internal Behavioral Health Consultant.</p>
							<p ng-show="active_course.course_id==2">This in-depth AlcoholSBIRT training teaches providers to comfortably screen individuals for risky alcohol use, briefly counsel patients about the health consequences of risky use, and link individuals needing additional services to Specialty Care.</p>
							<h4>Program Description:</h4>
							<p>The AlcoholSBIRT program:</p>
							<ul>
								<li>provides opportunity credits towards a CE or CME accreditation</li>
								<li>allows you to learn online, on your schedule, 24/7</li>
								<li>simulates real-world clinical scenarios in a military setting</li>
								<li>applies evidence-based screening instruments</li>
							</ul>
							<div>
								<h4>Learning Objectives:</h4>
							<p>Upon completion of this course, the learner will be able to:</p>
							<ul>
								<li>Define AlcoholSBIRT and identify its main components.</li>
								<li>Differentiate between levels of risk based on the alcohol screen.</li>
								<li>Identify recommended level of intervention based on level of risk.</li>
								<li>Identify key motivational interviewing skills used in delivering brief intervention and referral to treatment.</li>
							</ul>
							</div>
							<!-- CE Specific -->
							<div ng-show="active_course.accreditation_type_id==1">
								<h4>Accreditation Statement: </h4>
								<p>UPMC is accredited as a provider of continuing nursing education by the American Nursing Credentialing Center's Commission on Accreditation.</p>
							</div>
							<!-- CME Specific -->
							<div ng-show="active_course.accreditation_type_id==2">
								<h4>Accreditation Statement: </h4>
								<p>This activity has been planned and implemented in accordance with the Essential Areas and Policies of the Accreditation Council for Continuing Medical Education (ACCME) through the joint sponsorship of the University of Pittsburgh School of Medicine and MedRespond, LLC. The University of Pittsburgh School of Medicine is accredited by the ACCME to provide continuing medical education for physicians.</p>
							</div>
							<!-- Social Work Specific -->
							<div ng-show="active_course.accreditation_type_id==3">
								<h4>Accreditation Statement: </h4>
								<p>This program is offered for 3.0 hours of social work continuing education through co-sponsorship of the University of Pittsburgh’s School of Social Work, a Council on Social Work Education-accredited school and, therefore, a PA pre-approved provider of social continuing education. These credit hours satisfy requirements for LSW/LCSW, LPC and LMFT biennial license renewal.	 For information on social work continuing education call (412) 624-3711.</p>
							</div>
							<!-- APA Specific -->
							<div ng-show="active_course.accreditation_type_id==4">
								<h4>Accreditation Statement: </h4>
								<p>This program is co-sponsored by MedRespond LLC and the Pennsylvania Psychological Association. The Pennsylvania Psychological Association is approved by the American Psychological Association to sponsor continuing education for psychologists. PPA maintains responsibility for the program and its content. The Pennsylvania Psychological Association is an approved provider for Act 48 Continuing Professional Education Requirements as mandated by the Pennsylvania Department of Education.</p>
								<p>Social Workers, Marriage and Family Therapists and Professional Counselors can receive continuing education credits from continuing education providers approved by the American Psychological Association. Since the Pennsylvania Psychological Association is approved by the American Psychological Association to sponsor continuing education, licensed social workers, licensed clinical social workers, licensed marriage and family therapists, and licensed professional counselors will be able to fulfill their continuing education requirement by attending PPA continuing education programs. For further information please visit the State Board of Social Workers, Marriage &amp; Family Therapists and Professional Counselors Web site: <a href="http://www.dos.state.pa.us/social" target="_blank">www.dos.state.pa.us/social.</a></p>
							</div>
							<div>
								<h4>Disclosure Statement:</h4>
								<p>All individuals in a position to control the content of this education activity are required to disclose all relevant financial relationships with any proprietary entity producing, marketing, re‐selling, or distributing health care goods or services, used on, or consumed by, patients. <u>No relevant financial relationships were disclosed by: Jennifer Bell, Daniel Evatt, Eric Goplerud, Caitlin Kozicki, Tracy L. McPherson, Kendra McLaughlin, Virginia Pribanic.</u></p>
							</div>
						</div>
						<div class="col-xs-1 text-center">
						</div>
					</div>
				<div class="row ">
					<div class="col-xs-12">
					<div class="col-xs-12 text-center" style="padding:40px 60px;">
						<button type="button" class="btn btn-primary btn-lg" style="padding:	10px 40px" accept-disclaimer><i class="glyphicon glyphicon-share-alt"></i> Start Program</button>
								<p style="clear:both;"></p>
						<div class="alert alert-warning">* By clicking the START PROGRAM button I acknowledge that I have read the information above.</div>
					</div>
					</div>
				</div>
			</div>
		</div>


