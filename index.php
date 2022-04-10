<?php
session_start();
include "settings.php";
//print_error(); //for printing error in case of problem
include "function_library/loader.php";
global $DatabaseName_DB;
global $Server_DB;
global $Password_DB;
global $Username_DB;
$dbconnection = mysqli_connect($Server_DB, $Username_DB, $Password_DB, $DatabaseName_DB);
global $file_location;
$ip_session_memory = $_SESSION["client_ip"];
//update file list at every load of index.php
update_video_list($dbconnection, $file_location); //from video_folder/loader.php
$token = rand(0, 99999);
if ($_GET['get_ip'] != "") {
    $ip_value_client = set_ip_Session($dbconnection, $_GET['get_ip']);
    $_SESSION["client_ip"] = $ip_value_client;
}
if($ip_session_memory != ""){ //recupero la sessione verificando se l'ip è stato trovato
    $file_code_play = recovery_session($dbconnection,$ip_session_memory,"","","","",0);
    $time_code_play = recovery_session($dbconnection,$ip_session_memory,"","","","",1);
}
?>
<html>
<head>
    <link rel="stylesheet" href="skin.css?time=<?php echo(time()); ?>">
    <script src="function_library\player_support.js?time=<?php echo(time()); ?>" language="JavaScript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script language="JavaScript">
        <?php
        global $remote_relay_server;
        echo('var remote_server = "' . $remote_relay_server . '";');
        echo(' var local_ip = "' . $_SESSION["client_ip"] . '"; ');
        if($file_code_play != ""){
            echo ('var file_code_play='.$file_code_play.'; var time_code_play = '.$time_code_play.';');
        }
        if ($_GET['get_ip'] == "" && $_SESSION["client_ip"] != "") {
            echo(' var reloaderbreaker = true');
        } else {
            echo(' var reloaderbreaker = false');
        }
        ?>
    </script>
</head>
<body onload="ip_sync()">
<div>
    <input type="button" onclick="getUserIP()">
    <video class="video_player" id="call_video" width="320" height="240" controls>
        <source type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
<div>Session code <input type="number" name="session_code"><input type="button" value="Go" name="startsession"></div>
<div>File list</div>
<div><?php
    echo(generate_video_list($dbconnection, 1));
    ?></div>
</body>
<iframe src="<?php global $remote_relay_server; if($_SESSION["client_ip"] == ""){
echo($remote_relay_server); ?>get_ip.php?action=put&token=<?php echo($token); }?>" style="display: none" id="ip_show"
        onload="comunicate_ip(<?php echo($token); ?>)"></iframe>
</html>
