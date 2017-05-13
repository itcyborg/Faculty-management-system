setInterval(timed, 1000);
function timed() {
    var time = document.getElementById('time');
    time.style.background = "rgb(4,5,200)";
    time.style.color = "white";
    time.innerHTML = Date();
}
function toggle(div_id) {
    var div = document.getElementById(div_id);
    if (div.style.display == "none") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
}
function info(id) {
    var request = new XMLHttpRequest();
    request.open("POST", "functions.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        var maindiv = document.getElementById('content');
        if (this.readyState == 4 && this.status == 200) {
            maindiv.innerHTML = this.responseText;
        }
    }
    request.send(id);
}
function setupuser(username, password) {
    var request = new XMLHttpRequest();
    request.open("POST", "setup.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        var errordiv = document.getElementById('errordiv');
        if (this.readyState == this.DONE && this.status == 200) {
            if (username == "" || password == "") {
                errordiv.innerHTML = "All fields are required for successful login";
            } else {
                if (this.responseText == "True" && password != "welcome") {
                    window.location = "index.php";
                } else if (this.responseText == "Change") {
                    window.location = "changepass.php";
                }
                else {
                    errordiv.innerHTML = this.responseText;
                }
            }
        }
    }
    request.send("login=" + "login" + "&username=" + username + "&password=" + password);
}
function views(suggestion_id) {
    var request = new XMLHttpRequest();
    request.open("POST", "functions.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        var viewsDisplay = document.getElementById(suggestion_id * 2);
        if (this.readyState == this.DONE && this.status == 200) {
            viewsDisplay.innerHTML = this.responseText;
        }
    }
    request.send("views=" + "views" + "&id=" + suggestion_id);
}
function logout() {
    var request = new XMLHttpRequest();
    request.open("POST", "functions.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        if (this.readyState == this.DONE && this.status == 200) {
            window.location = "login.php";
        }
    }
    request.send("logout=" + "logout");
}
function search(text) {
    var div = document.getElementById('search_sugg');
    div.innerHTML = text;
}
function printDiv(div) {
    var printContent = document.getElementById(div).innerHTML;
    var wholepage = document.body.innerHTML;
    wholepage = printContent;
    window.print();
    document.body.innerHTML = wholepage;
}
function check(complain, title) {
    if (document.getElementById('title').value == "" || document.getElementById('complain').value == "") {
        alert("Please fill the form before submitting")
    } else {
        var request = new XMLHttpRequest();
        request.open("POST", "functions.php", true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.onreadystatechange = function () {
            if (this.readyState == this.DONE && this.status == 200) {
                alert("Querry sent successfully.");
                document.getElementById('title').value = "";
                document.getElementById('complain').value = "";
            }
        }
        request.send("sendComplain=" + "sendComplain" + "&title=" + title + "&complain=" + complain);
    }
}
function vote(id, aspirant, position) {
    var request = new XMLHttpRequest();
    request.open("POST", "functions.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        var votebut = document.getElementById(id);
        if (this.readyState == this.DONE && this.status == 200) {
            votebut.innerHTML = this.responseText;
            votebut.style.background = "white";
            votebut.style.color = "black";
            votebut.style.border = "none";
            votebut.setAttribute("disabled", null);
        }
    }
    request.send("vote=" + "vote" + "&aspirant=" + aspirant + "&position=" + position);
}
function candidature(adm, name, position) {
    var request = new XMLHttpRequest();
    request.open("POST", "functions.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        var votebut = document.getElementById(id);
        if (this.readyState == this.DONE && this.status == 200) {
            if (this.responseText == "True") {
                alert("You have been enrolled successfully!!");
            } else {
                alert("There was a problem. The system could not enroll you");
            }
        }
    }
    request.send("requestCandidature=" + "requestCandidature" + "&adm=" + adm + "&name=" + name + "&position=" + position);
}
function newSuggestion(title, body) {
    var request = new XMLHttpRequest();
    request.open("POST", "functions.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        if (this.readyState == this.DONE && this.status == 200) {
            document.getElementById('response').innerHTML = this.responseText;
        }
    }
    request.send("newSuggestion=" + "newSuggestion" + "&title=" + title + "&suggestion=" + body);
}