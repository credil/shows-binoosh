
<!DOCTYPE html>
<html>
<head>
	<title>FullScreen API</title>
	
	<style>
	html, body {
	height: 100%;
	text-align: center; 
	}
	#container {
		/*
		width: 600px;
		padding: 30px;
		background: #F8F8F8;
		border: solid 1px #ccc;
		color: #111;
		margin: 20px auto;
		border-radius: 3px;
		*/
	}
	
	#specialstuff {
		/*
		background: #33e;
		padding: 20px;
		margin: 20px;
		color: #fff;
		*/
	}
	#specialstuff a {
		color: #eee;
	}
	
	#fsstatus {
		background: #e33;
		color: #111;
	}
	
	#fsstatus.fullScreenSupported {
		background: #3e3;
	}
	</style>
	<meta http-equiv="refresh" content="120">
<script type="text/javascript" src="js/jquery.js"></script>    
<script type="text/javascript" src="js/jquery.imagefit.js"></script>
<script type="text/javascript" src="js/fullScreen.js"></script>

</head>
<body>
	<div id="container">
		<div id="specialstuff">
			<?php
				$imagePath = file_get_contents('fetchThis.txt');
				echo "<div id='slide'><img src=\"$imagePath\" id=\"main\"></div>";
			?>
		</div>
		
		<input type="button" value="Go Fullscreen" id="fsbutton" />
	</div>


<script>

/* 
Native FullScreen JavaScript API
-------------
Assumes Mozilla naming conventions instead of W3C for now
*/

(function() {
	var 
		fullScreenApi = { 
			supportsFullScreen: false,
			isFullScreen: function() { return false; }, 
			requestFullScreen: function() {}, 
			cancelFullScreen: function() {},
			fullScreenEventName: '',
			prefix: ''
		},
		browserPrefixes = 'webkit moz o ms khtml'.split(' ');
	
	// check for native support
	if (typeof document.cancelFullScreen != 'undefined') {
		fullScreenApi.supportsFullScreen = true;
	} else {	 
		// check for fullscreen support by vendor prefix
		for (var i = 0, il = browserPrefixes.length; i < il; i++ ) {
			fullScreenApi.prefix = browserPrefixes[i];
			
			if (typeof document[fullScreenApi.prefix + 'CancelFullScreen' ] != 'undefined' ) {
				fullScreenApi.supportsFullScreen = true;
				
				break;
			}
		}
	}
	
	// update methods to do something useful
	if (fullScreenApi.supportsFullScreen) {
		fullScreenApi.fullScreenEventName = fullScreenApi.prefix + 'fullscreenchange';
		
		fullScreenApi.isFullScreen = function() {
			switch (this.prefix) {	
				case '':
					return document.fullScreen;
				case 'webkit':
					return document.webkitIsFullScreen;
				default:
					return document[this.prefix + 'FullScreen'];
			}
		}
		fullScreenApi.requestFullScreen = function(el) {
			return (this.prefix === '') ? el.requestFullScreen() : el[this.prefix + 'RequestFullScreen']();
		}
		fullScreenApi.cancelFullScreen = function(el) {
			return (this.prefix === '') ? document.cancelFullScreen() : document[this.prefix + 'CancelFullScreen']();
		}		
	}

	// jQuery plugin
	if (typeof jQuery != 'undefined') {
		jQuery.fn.requestFullScreen = function() {
	
			return this.each(function() {
				var el = jQuery(this);
				if (fullScreenApi.supportsFullScreen) {
					fullScreenApi.requestFullScreen(el);
				}
			});
		};
	}

	// export api
	window.fullScreenApi = fullScreenApi;	
})();

</script>

<script>

// do something interesting with fullscreen support
var fsButton = document.getElementById('fsbutton'),
	fsElement = document.getElementById('specialstuff'),
	fsStatus = document.getElementById('fsstatus');


if (window.fullScreenApi.supportsFullScreen) {
	//fsStatus.innerHTML = 'YES: Your browser supports FullScreen';
	//fsStatus.className = 'fullScreenSupported';
	
	// handle button click
	fsButton.addEventListener('click', function() {
		window.fullScreenApi.requestFullScreen(fsElement);
	}, true);
	
	fsElement.addEventListener(fullScreenApi.fullScreenEventName, function() {
		if (fullScreenApi.isFullScreen()) {
			fsStatus.innerHTML = 'Whoa, you went fullscreen';
		} else {
			fsStatus.innerHTML = 'Back to normal';
		}
	}, true);
	
} else {
	fsStatus.innerHTML = 'SORRY: Your browser does not support FullScreen';
}

</script>



<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount','UA-3734687-9']);
_gaq.push(['_trackPageview'],['_trackPageLoadTime']);
(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
	
	
<script type="text/javascript">
	var clicky = { log: function(){ return; }, goal: function(){ return; }};
	var clicky_site_id = 117587;
	(function() {
		var s = document.createElement('script');
		s.type = 'text/javascript'; s.async = true;
		s.src = '//static.getclicky.com/js';
		( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
	})();
</script>

<script type="text/javascript">                                         
var displayedUrl  = '';
 $(document).ready(function() {
	refresh();
	window.setInterval(refresh, 500);

	if (fullScreenApi.supportsFullScreen) {
		fsElement = document.getElementById('specialstuff');
		fullScreenApi.requestFullScreen(fsElement);
	}
	
 });
$(window).load(function(){
    $('body').imagefit();
});
function refresh() {
	$.get("http://localhost/shows-binoosh/fetchThis.txt", function(data){
		var currentUrl = data;
		if(currentUrl != displayedUrl) {
			displayedUrl = currentUrl;
			$("#main").attr("src", displayedUrl);

			$('body').imagefit();
			
		}
		//Use for debug
		//displayLastRefresh();
	});
}

function displayLastRefresh() {
	var d = new Date();
	tstr = d.getHours() +':'+ d.getMinutes() +':'+ d.getSeconds();
	$('#feedback').text("Last refresh check: " + tstr);
}
	

function output(string) {
	var d = new Date();
	tstr = d.getHours() +':'+ d.getMinutes() +':'+ d.getSeconds();
	$('body').append("<p>"+ tstr + ": " +string+"</p>");
}



 </script>  


</body>
</html>


