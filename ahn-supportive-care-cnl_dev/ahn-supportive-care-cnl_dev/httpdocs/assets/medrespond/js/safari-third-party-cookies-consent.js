$(document).ready(function () {
	var is_framed = self != top;

	if(is_framed) {
		var is_safari = ($('html').attr('data-ua-name') === 'safari');

		if(is_safari) {
			var third_party_cookies_consent_given = document.cookie.indexOf('safari_third_party_cookies_consent_given=true') > -1;

			if(!third_party_cookies_consent_given) {
				var referrer = encodeURIComponent(document.referrer);
				var url = self.location.protocol + '//' + self.location.host + '/safari_third_party_cookies_consent_redirect.html?referrer=' + referrer;
				$('#safari-third-party-cookies-consent-button').attr('href', url);
				$('#safari-third-party-cookies-consent-modal').modal({backdrop: 'static', keyboard: false});
				$('#safari-third-party-cookies-consent-modal').modal('show');

			}
		}
	}
});