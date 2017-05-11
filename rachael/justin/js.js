function loadRequest(url){
	var request=new XMLHttpRequest();
	request.open("GET",url,true);
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.onreadystatechange=function(){
		var div=document.getElementById('render');
		if(this.readyState==4 && this.status==200){
			div.innerHTML=this.responseText;
		}
	}
	request.send(null);
}
function login(username,password,errordiv){
	if(username!="" || password!=""){
		var request=new XMLHttpRequest();
		request.open("POST","processlogin.php",true);
		request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		request.onreadystatechange=function(){
			if(this.readyState==4 && this.status==200){
				if(this.responseText=="True"){
					if(username=="SUPERUSER" && password !="welcome"){
						window.location="admin.php";
					}else if(username !="SUPERUSER" && password !="welcome"){
						window.location="mainpage.php";
					}
					else{
						window.location="changepass.php";
					}
				}else{
					errordiv.innerHTML=this.responseText;
				}
			}
		}
	request.send("username="+username+"&pass="+password);
	}else{
		errordiv.innerHTML="Please fill all fields";
	}
}
function displayAnyHiddenDiv(div){
	div.style.display="block";
}
function load(url){
	var div=document.getElementById('render');
	div.innerHTML="";
	var request=new XMLHttpRequest();
	request.open("POST","admin/"+url,true);
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.onreadystatechange=function(){
		var div=document.getElementById('render');
		if(this.readyState==this.DONE && this.status==200){
			div.innerHTML=this.responseText;
		}
	}
	request.send(null);
}
//WARNING: THIS CODE IS FORM ANOTHER FILE
function loadsuggestions(){
	var request=new XMLHttpRequest();
	request.open("GET","php.php",true);
	request.onreadystatechange=function(){
		var div=document.getElementById('suggestions');
		if(this.readyState==this.DONE && this.status==200){
			div.innerHTML=this.responseText;
		}
	}
	request.send(null);
}
function comment(id){
	var div=document.getElementById(id*5);
	div.style.display="block";
	var textarea=document.getElementById(id*2);
	textarea.addEventListener("blur",function(event){
		var div=document.getElementById(id*5);
		if(this.value==""){
			div.style.display="none";
		}
	});
}
function sendCommend(id){
	// the id is thrice what i want so be careful
	var textarea=document.getElementById((id/3)*2).value;
	var request=new XMLHttpRequest();
	request.open("POST","comments.php",true);
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.onreadystatechange=function(){
		if(this.readyState==4 && this.status==200){
			
		}
	}
	suggestion_id=id/3;
	request.send("suggestion_id="+suggestion_id+"&comment="+textarea);
	document.getElementById((id/3)*5).style.display="none";
	document.getElementById((id/3)*2).value="";
}
function previousComments(id){
	var request=new XMLHttpRequest();
	request.open("POST","prevoiuscomments.php",true);
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.onreadystatechange=function(){
		var div=document.getElementById(id*4);
		if(this.readyState==4 && this.status==200){
			div.innerHTML=this.responseText;
		}
	}
	request.send("suggestion_id="+id);
}
function handleSeconds(id){
	var request=new XMLHttpRequest();
	request.open("POST","second.php",true);
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.onreadystatechange=function(){
		var div=document.getElementById(id);
		if(this.readyState==4 && this.status==200){
			div.innerHTML=this.responseText;
		}
	}
	request.send("id="+id);
}
function loader(){
	var title=document.getElementById('title').value;
	var suggestion=document.getElementById('suggestion').value;
	var owner=document.getElementById('owner').value;
	if(title.length==0||suggestion.length==0||owner.length==0){

	}
	else{
		var request=new XMLHttpRequest();
		request.open("POST","suggestionprocessor.php");
		request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		request.onreadystatechange=function(){
			var topmost=document.getElementById('topmost');
			if(this.readyState==this.DONE && this.status==200){
			topmost.innerHTML=this.responseText;
			}
		}
		request.send("title="+title+"&suggestion="+suggestion+"&owner="+owner);
		document.getElementById('title').value="";
		document.getElementById('suggestion').value="";
		document.getElementById('owner').value="";
	}
	
}