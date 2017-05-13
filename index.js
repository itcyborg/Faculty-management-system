window.onload = setInterval(displayTime, 1000);
function displayTime() {
    var time = new Date();
    document.getElementById('time').innerHTML = time;
}
function images() {
    var args = images.arguments;
    var imagesArray = new Array();
    for (i = 0; i < args.length; i++) {
        imagesArray[i] = args[i];
    }
    var img = document.getElementsByTagName('img');
    imageId = Math.ceil(Math.random() * (args.length - 1));
    img[0].setAttribute('src', "site_photos/" + imagesArray[imageId]);
}
setInterval(images("1588374.jpg", "40f5a7f63-1.jpg", "74d372ba0-1.jpg", "85a1bf7ab-1.jpg", "vlcsnap-2017-03-26-22h29m33s954.png"), 10000);