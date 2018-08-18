var MR = MR || {};
(function($){
	var Login = function(){
		$(document).ready(function(){
			if (MR.login.getParameterByName('m') == "inactive"){
				MR.utils.alert({type:"warning",message:"You have been logged out due to inactivity."});
			}
			if (MR.login.getParameterByName('m') == "speaker"){
				MR.utils.alert({type:"warning",message:"Please select a speaker before trying to access the site."});
			}
			if (MR.browser.name == 'internet-explorer' && (MR.browser.version <= 8) && $('body').hasClass('login')){
				if (MR.browser.trident == "true" && MR.browser.version <= 7){
					//IE10 Compat Mode
				}else{
					$('#mr-content').prepend('<div id="browser-status"></div>');
					$('#browser-status').load( "/assets/medrespond/html/browser_upgrade.html?ajax #browsers" , function( response, status, xhr ) {
						$('#browsers').prepend('<p class="browser-note"><strong>*Note:</strong> You are using an older version of Internet Explorer.<br/><small>For an optimal experience, please download and install one of the following browsers:</small>')
					});
				}
			}
		});
		this.forgot_password_callback = function(data){
			if (data.status == 'success'){
				MR.utils.alert({type:'success',message: data.message});
			}else{
				MR.utils.alert({type:'error',message: data.message});
			}
		}
		this.forgot_password = function(form_source){
			var post_vars = {};
			post_vars.email = $('#email').val();
			if (form_source == 'admin'){
				$.post('/'+MR.core.base_url+'login/ajax_forgot_password', post_vars, MR.login.forgot_password_callback, 'json');
			}else{
				$.post('/'+MR.core.base_url+'login/ajax_forgot_password', post_vars, MR.login.forgot_password_callback, 'json');
			}
		}
		this.do_login_callback = function(data, form_source){
			if (form_source == 'admin' || form_source == 'modal') {
				window.location='/'+MR.core.base_url+'admin';
			} else {
				window.location='/'+MR.core.base_url;
			}
		}
		this.do_login = function(form_source, cb){
			/* Prevent concurrent login requests */
			if($('#mr-sign-in').length) {
				$('#mr-sign-in').prop('disabled', true);
			}

			/* Post variables sent to the controller */
			var post_vars = {};
			if (form_source === "modal"){
				post_vars.username = $('#modal_username').val();
				post_vars.password = $('#modal_password').val();
			}else if (form_source === "email_login"){
				post_vars.email = $('#email').val();
			}else if (form_source === "email_register"){
				post_vars.email = $('#email').val();
				post_vars.first_name = $('#first_name').val();
				post_vars.last_name = $('#last_name').val();
				post_vars.postal_code = $('#postal_code').val();
				//post_vars.agree = $('#r-agree').is(":checked");
			}else{
				post_vars.username = $('#username').val();
				post_vars.password = $('#password').val();
			}
			/* CAPTCHA */
			if ($('#g-recaptcha-response').exists()){
				post_vars.captcha = $('#g-recaptcha-response').val();
			}

			var callback = function(data) {
				/* Re-enable login requests */
				if($('#mr-sign-in').length) {
					$('#mr-sign-in').prop('disabled', false);
				}

				if (data.status == 'success'){
					if (cb){
						cb();
					}else{
						MR.login.do_login_callback(data, form_source);
					}
				}else{
					/* Reset the captcha because it has become invalid */
					if ($('#g-recaptcha-response').exists()){
						grecaptcha.reset();
					}
					MR.utils.alert({type:'error',message: data.message});
				}
			};
			/* What controller to route the form to */
			if (form_source == 'admin') {
				$.post('/'+MR.core.base_url+'login/ajax_login', post_vars, callback, 'json');
			} else if (form_source == 'new_user') {
				// Update angular model
				var scope =	 angular.element("#base_controller").scope();
				scope.$apply(function(){ scope.showDisclaimer = true });
			} else if (form_source == 'create_user'){
				$.post('/'+MR.core.base_url+'login/ajax_create_user', post_vars, callback, 'json');
			} else if (form_source == 'guest_user'){
				window.location='/'+MR.core.base_url;
			} else if (form_source == 'email_login') {
				$.post('/'+MR.core.base_url+'login/ajax_email_login', post_vars, callback, 'json');
			} else if (form_source == 'email_register') {
											console.log('arf');
				$.post('/'+MR.core.base_url+'login/ajax_email_register', post_vars, callback, 'json');
			} else {
				$.post('/'+MR.core.base_url+'login/ajax_login', post_vars, callback, 'json');
			}
		}


		this.do_logout_callback = function(data, form_source){
			if (data.status == 'success'){
				if (form_source == 'admin'){
					window.location='/'+MR.core.base_url+'login?u=admin';
				}else if (form_source == 'inactive'){
					window.location='/'+MR.core.base_url+'login?m=inactive';
				}else{
					window.location='/'+MR.core.base_url+'login';
				}
			}else{
				alert(data.message);
			}
		}
		this.do_logout = function(form_source){
			var post_vars = {};

			var callback = function(data) {
				MR.login.do_logout_callback(data, form_source)
			};

			if (form_source == 'admin'){
				$.post('/'+MR.core.base_url+'login/ajax_logout', post_vars, callback, 'json');
			}else{
				$.post('/'+MR.core.base_url+'login/ajax_logout', post_vars, callback, 'json');
			}
		}

		this.is_logged_in_callback = function(data, form_source){
			if (data.status == 'success'){
				// setTimeout('ajax_is_logged_in();', 1000 * 60);
			}else{
				alert('Session has timed-out');

				if (form_source == 'admin'){
					window.location='/'+MR.core.base_url+'login';
				}else{
					window.location='/'+MR.core.base_url+'login';
				}
			}
		}

		this.is_logged_in = function(form_source){
			var post_vars = {};

			var callback = function(data) {
				MR.login.is_logged_in_callback(data, form_source)
			};

			$.post('/'+MR.core.base_url+'login/ajax_is_logged_in', post_vars, callback, 'json');
		}

		this.reset_password_callback = function(data) {
			if (data.status == 'success') {
				MR.utils.alert({type:'success',message:'Your password has been reset. You may sign-now sign in.'},function(){
					window.location='/'+MR.core.base_url+'login';
				});
			}
			else {
				MR.utils.alert({type:'error',message:data.message});
			}
		}

		this.reset_password = function(form_source){
			var post_vars = {};
			post_vars.hash = $('#hash').val();
			post_vars.username = $('#username').val();
			post_vars.password = $('#password').val();
			post_vars.confirm_password = $('#confirm_password').val();

			if (form_source == 'admin'){
				$.post('/'+MR.core.base_url+'login/ajax_reset_password', post_vars, MR.login.reset_password_callback, 'json');
			}
			else{
				$.post('/'+MR.core.base_url+'login/ajax_reset_password', post_vars, MR.login.reset_password_callback, 'json');
			}
		}

		this.getParameterByName = function(name) {
				name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
				var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
						results = regex.exec(location.search);
				return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		}
	};//Login
	MR.login = new Login();
})(jQuery);
