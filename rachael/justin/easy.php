<!DOCTYPE html>
<html>
<head>
	<title>trial</title>
</head>
<body>
<div id="slideshow">
  <div><img src="40f5a7f63-1.jpg"></div>
  <div><img src="74d372ba0-1.jpg"></div>
  <div><img src="1588374.jpg"></div>
	
</div>
<style type="text/css">
 #slideshow{
 	margin: 50px auto;
 	position: relative;
 	width: 240px;
 	height: 240px;
 	padding: 10px;
 	box-shadow: 0 0 20px rgba(0,0,0,0.4);
 }
 #slideshow img{
 	position: absolute;
 	top: 10px;
 	left: 10px;
 	right: 10px;
 	bottom: 10px;
 }
	
</style>
<script type="text/javascript">
alert("trying");
	$("#slideshow > div:gt(0)").hide();
	setInterval(function(){
		$('#slideshow > div:first').fadeOut(1000).next().fadeIn(1000).end().appendTo('#slideshow');
	},3000);
</script>

</body>

</html>
 <span class="dot" onclick="currentSlide(1)"></span>
 <span class="dot" onclick="currentSlide(2)"></span>
 <span class="dot" onclick="currentSlide(3)"></span>
  	 	var dots= document.getElementsByClassName("dot");