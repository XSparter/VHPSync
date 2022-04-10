function set_video_session(video_code) {
    console.log(video_code);

    get_video_link_after_session_update(video_code,0)

}

var timer_is_on = false;

function set_video_playback(url,time_Start) {
    var video_link = url
    var object_to_work = document.getElementById('call_video');
    object_to_work.src = video_link;
    object_to_work.load();
    object_to_work.play();
    object_to_work.currentTime(time_Start)
    if (!timer_is_on) {
        timer_is_on = true;
        updateTimeServer();
    }
}

var execution_controller = false //use this for check if callback of http request is coming
function get_video_link_after_session_update(video_code,time_code) {
    execution_controller = true;
    const Http = new XMLHttpRequest();
    const url = '../function_library/data_utility.php?video_code=' + video_code + "&sessionip=" + local_ip + "&command=put";
    console.log(url);
    Http.open("GET", url);
    Http.send();

    Http.onreadystatechange = (e) => {
        set_video_playback(Http.responseText,time_code)


    }
}

function updateTimeServer() {
    var video_frame = document.getElementById('call_video');
    timer_counter(video_frame);
    setTimeout('updateTimeServer()', 2000);


}

function timer_counter(video_frame) {
    var video_timestamp = video_frame.currentTime;
    console.log(video_timestamp);
    //comunicate to server video position
    const Http = new XMLHttpRequest();
    const url = '../function_library/data_utility.php?sessionip=' + local_ip + '&command=update&timeplaycode=' + video_timestamp;
    Http.open("GET", url);
    Http.send();

    Http.onreadystatechange = (e) => {
        //console.log(Http.responseText);


    }
}

function ip_sync(){
    if (local_ip != "" && file_code_play != ""){
        get_video_link_after_session_update(file_code_play,time_code_play);
    }
}
function comunicate_ip(token) {
    if (!reloaderbreaker) {
        if (local_ip == "") {
            var url_location = "../index.php?get_ip=" + token;
        } else {
            var url_location = "../index.php";
        }
        window.location.href = url_location;
        console.log(url_location);
    }
}

function getUserIP() {
    const Http = new XMLHttpRequest();
    const url = 'http://xsparter.altervista.org/get_ip.php';
    console.log(url);
    Http.open("GET", url);
    Http.send();
    Http.onreadystatechange = (e) => {
        set_video_playback(Http.responseText)


    }
}