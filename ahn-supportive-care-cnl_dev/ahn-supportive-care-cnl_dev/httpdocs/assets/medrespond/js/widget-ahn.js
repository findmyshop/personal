(function(){
	/*!
	 * jQuery-ajaxTransport-XDomainRequest - v1.0.3 - 2014-06-06
	 * https://github.com/MoonScript/jQuery-ajaxTransport-XDomainRequest
	 * Copyright (c) 2014 Jason Moon (@JSONMOON)
	 * Licensed MIT (/blob/master/LICENSE.txt)
	 */
	(function(a){if(typeof define==='function'&&define.amd){define(['jquery'],a)}else if(typeof exports==='object'){module.exports=a(require('jquery'))}else{a(jQuery)}}(function($){if($.support.cors||!$.ajaxTransport||!window.XDomainRequest){return}var n=/^https?:\/\//i;var o=/^get|post$/i;var p=new RegExp('^'+location.protocol,'i');$.ajaxTransport('* text html xml json',function(j,k,l){if(!j.crossDomain||!j.async||!o.test(j.type)||!n.test(j.url)||!p.test(j.url)){return}var m=null;return{send:function(f,g){var h='';var i=(k.dataType||'').toLowerCase();m=new XDomainRequest();if(/^\d+$/.test(k.timeout)){m.timeout=k.timeout}m.ontimeout=function(){g(500,'timeout')};m.onload=function(){var a='Content-Length: '+m.responseText.length+'\r\nContent-Type: '+m.contentType;var b={code:200,message:'success'};var c={text:m.responseText};try{if(i==='html'||/text\/html/i.test(m.contentType)){c.html=m.responseText}else if(i==='json'||(i!=='text'&&/\/json/i.test(m.contentType))){try{c.json=$.parseJSON(m.responseText)}catch(e){b.code=500;b.message='parseerror'}}else if(i==='xml'||(i!=='text'&&/\/xml/i.test(m.contentType))){var d=new ActiveXObject('Microsoft.XMLDOM');d.async=false;try{d.loadXML(m.responseText)}catch(e){d=undefined}if(!d||!d.documentElement||d.getElementsByTagName('parsererror').length){b.code=500;b.message='parseerror';throw'Invalid XML: '+m.responseText;}c.xml=d}}catch(parseMessage){throw parseMessage;}finally{g(b.code,b.message,c,a)}};m.onprogress=function(){};m.onerror=function(){g(500,'error',{text:m.responseText})};if(k.data){h=($.type(k.data)==='string')?k.data:$.param(k.data)}m.open(j.type,j.url);m.send(h)},abort:function(){if(m){m.abort()}}}})}));

	/* AHN Widget */
	var script = $('script').last();
	var domain = 'https://www.postpartumconversations.com/'; //POST PARTUM MR URL
	var opts = { color: $(script).attr("data-color-scheme"),
									rid: $(script).attr("data-video-id"),
									link: $(script).attr("data-link"),
									link_text: $(script).attr("data-link-text")
								};
	/* iframe or no iframe? */
	var use_iframe = true;
	if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
		use_iframe = false;
	}

	/* Stylesheet Include */
	var c = document.createElement('link');
	c.setAttribute('rel','stylesheet');
	c.setAttribute('type','text/css');
	c.setAttribute('href',domain+'assets/medrespond/css/widget.css');
	$('head').append($(c));

	/* Write widget */
	var preview = document.createElement('img');
	preview.src = domain+'assets/medrespond/images/mr-video-placeholder.png';
	preview.id = 'mr-video-preview';

	var btnPlay = document.createElement('img');
	btnPlay.src = domain+'assets/video-js/img/play-small.png';
	btnPlay.id = 'mr-video-play-button';

	document.write('<div id="mr-video-widget" class="'+opts.color+'"><div id="mr-video-caption"></div></div>');
	if (opts.link && opts.link_text){
		document.write('<a target="_blank" id="mr-bottom-link" href="'+opts.link+'">'+opts.link_text+'</a>');
	}
	var $widget = $("#mr-video-widget");
	var $caption = $("#mr-video-caption");

	$widget.append($(preview));
	$widget.attr("title","Click to view video");

	$caption.append($(btnPlay));
	$widget.append($caption);

	if (use_iframe){
		var ifrm = document.createElement('iframe');
		ifrm.setAttribute('frameBorder','0');
		ifrm.id = "mr-iframe";
		var ifrm_wrap = document.createElement('div');
		ifrm_wrap.id = "mr-iframe-wrapper";
		var ifrm_hold = document.createElement('div');
		ifrm_hold.id = "mr-iframe-holder";
		var ifrm_close = document.createElement('div');
		ifrm_close.id = "mr-button-close";

		$(ifrm_hold).append($(ifrm));
		$(ifrm_hold).append($(ifrm_close));
		if (opts.link && opts.link_text){
			$(ifrm_hold).append('<a target="_blank" id="mr-video-bottom-link" href="'+opts.link+'">'+opts.link_text+' &raquo;</a>');
		}
		$(ifrm_wrap).append($(ifrm_hold));
		$('body').append($(ifrm_wrap));

		$("#mr-button-close").on("click touchstart",function(){
			$("#mr-iframe-wrapper").stop(false,true).fadeOut('fast',function(){
				$("#mr-iframe").attr("src",'');
			});
		});
	}
	/* Get the video info */
	$.support.cors = true;
	$.ajax({
		type: "POST",
		url: domain+'video/get_response?response_id='+opts.rid,
		dataType: "json",
		crossDomain: true,
		cache: false,
		success: function(data){
			if (data.status == 'success'){
				$widget.on("click touchstart",function(e){
					if (use_iframe){
						$("#mr-iframe-holder").css({top:$(window).height()/2-$("#mr-iframe-holder").height()/2,left:$(window).width()/2-$("#mr-iframe-holder").width()/2});
						$("#mr-iframe-wrapper").stop(false,true).fadeIn('fast');
						$("#mr-iframe").attr("src",domain+'video/#/LRQ/'+opts.rid);
					}else{
						window.open(domain+'#/LRQ/'+opts.rid);
					}
				});
				$caption.append('<span>'+data.response.name+'</span>');
				var still = document.createElement('img');
				still.src = 'https://'+data.response['web_domain']+'/stills/'+opts.rid+'.png?cb='+Math.round(new Date().getTime() / 1000);
				still.id = 'mr-video-still';
				still.onload = function(){
					$caption.stop(false,true).fadeIn('fast');
					$widget.append($(still).fadeIn("fast"));
				}
			}
		}
	});

})();