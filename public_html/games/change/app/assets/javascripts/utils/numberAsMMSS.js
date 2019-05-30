Number.prototype.toMMSS = function () {
    var seconds = Math.floor(this);
    var minutes = Math.floor(seconds / 60);
    seconds -= minutes*60;

    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return minutes+':'+seconds;
}