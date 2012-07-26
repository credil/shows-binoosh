<html>
<head>
<style>
html, body {
height: 100%;
text-align: center; 
}
</style>
<meta http-equiv="refresh" content="120">
<script type="text/javascript" src="js/jquery.js"></script>    
<script type="text/javascript" src="js/jquery.imagefit.js"></script>
<script type="text/javascript" src="js/fullScreen.js"></script>
<script type="text/javascript">                                         
var displayedUrl  = '';
 $(document).ready(function() {
	refresh();
	window.setInterval(refresh, 500);

	if (fullScreenApi.supportsFullScreen) {
		fsElement = document.getElementById('slide');
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
</head>
<body>
<?php
	$imagePath = file_get_contents('fetchThis.txt');
	echo "<div id='slide'><img src=\"$imagePath\" id=\"main\"></div>";
?>
<!-- <div id="feedback"></div> -->
</body>
</html>
