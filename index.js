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
