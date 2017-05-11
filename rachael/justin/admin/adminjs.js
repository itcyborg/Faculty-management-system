function newStaff(lec_id,lec_name,department,contact,email,pass){
	alert(lec_id);
	var request=new XMLHttpRequest();
	request.open();
	request.setRequestHeader("POST","processadminactions.php",true);
	request.onreadystatechange=function(){
		var div=document.getElementByTagName('body');
		if (this.readyState==this.DONE && this.status==200){
			div.innerHTML=this.responseText;
		}
	}
	request.send("submit_lec="+"submit_lec"+"&lec_id="+lec_id+"&lec_name="+lec_name+"&department="+department+"&contact="+contact+"&email="+email+"&pass="+pass);
}