<!DOCTYPE html>
<html>
<head>
	<title>homepage</title>
	<link rel="stylesheet" type="text/css" href="landing.css">
</head>

<body>
  <div class="nav">
  <nav>
    <ul type="none">
    	<li onclick="changeMain('../gproject/news.php')">News</li>
    	<li onclick="changeMain('../gproject/events.php')">events</a></li>
    	<li onclick="changeMain('')">forums</a></li>
    	<li onclick="changeMain('organisations.php')">organisations</a></li>
    	<li onclick="changeMain('departments.php')">departments</a></li>
    	<li onclick="changeMain('suggestion.php')">suggestions</a></li>
    	<li onclick="changeMain('')">I.L.S</a></li>
    	<li onclick="changeMain('../gproject/stuleaders.php')">student leaders</a></li>
    	<li onclick="changeMain('index.php')">login</a></li>
    </ul>
  </nav>
  </div>
  <div id="news" style="top:20%;position:absolute;"></div>
  
  <div id="content" class="Slideshow_container">
    <div id="slidess" class="mySlides fade">
       <img src="40f5a7f63-1.jpg" width="124%">
       <img src="74d372ba0-1.jpg"  width="124%">
       <img src="1588374.jpg"width="124%">
    </div>
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
   </div>
  <script type="text/javascript">
  
   var slideIndex=1;
   showSlides(slideIndex);
   function changeMain(file){
      document.getElementById("content").style.display="none";
        var request=new XMLHttpRequest();
        request.open("GET",file,true);
        //request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.onreadystatechange=function(){
            var div=document.getElementById("news");
            if(this.readyState==4 && this.status==200){
                div.innerHTML=this.responseText;
            }
        }
        request.send(null);
   }
   function plusSlides(n){
   	showSlides(slideIndex +=n);
   }
   function currentSlides(n){
   	showSlides(slideIndex =n);
   }
   function showSlides(n){
   	var i;
   	var slides= document.getElementsByClassName("mySlides");
   	var dots= document.getElementsByClassName("dot");
   	if (n>slides.length) {slideIndex=1};
   	if (n<1) {slideIndex=slides.length};
   	for (var i = 0; i < slides.length; i++) {
   		slides[i].style.display="none";
   	};
   	for (var i = 0; i < dots.length; i++) {
   		dots[i].className=dots[i].className.replace("active","");
   	};
   	slides[slideIndex-1].style.display="block";
   	dots[slideIndex-1].className+="active";
   }
   
  
  </script>
</body>
<footer id="footer"><i>designed by three idiots <br>all rights reserved @2017</i></footer>
</html>
