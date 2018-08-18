$(document).ready(function () {
	anti_click_Jack();
});

function anti_click_Jack() {
	var is_framed = self != top;
	var current_domain = window.location.host;
	var navigate_within_domain = document.referrer.toString().indexOf(current_domain) != -1;
	if(navigate_within_domain == true) {
		$('#anti_click_jack').remove();
		return;
	}

	if(is_framed) {
		var url = document.referrer;
		var accepted_host_frame = is_host_frame_allowed(url);
		if (accepted_host_frame) {
			$('#anti_click_jack').remove();
		} else {
			alert('IFraming Disabled');
		}
	} else {
		$('#anti_click_jack').remove();
	}
}

function is_host_frame_allowed(target_host_frame) {;
	if (iframe_whitelist.length == 0) {
		return true;
	}
	var hosts = iframe_whitelist.split(",");
	for (var i = 0; i < hosts.length; i++) {
		if (target_host_frame.indexOf(hosts[i]) > -1) {
			return true;
		}
	}
	return false;
}