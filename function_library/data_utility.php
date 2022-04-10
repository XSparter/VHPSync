<?php
session_start();
include "../settings.php";
global $DatabaseName_DB;
global $Server_DB;
global $Password_DB;
global $Username_DB;
global $file_location;
$dbconnection = mysqli_connect($Server_DB, $Username_DB, $Password_DB, $DatabaseName_DB);
$identification_code = $_GET['video_code'];
$ip_session = $_GET['sessionip'];
$timeplaycode = $_GET['timeplaycode'];
$query = 'SELECT `counter`, `file_name`, `identificator` FROM `vhp_file_list` WHERE identificator=' . $identification_code;
$query_execution = mysqli_query($dbconnection, $query);
$row = mysqli_fetch_array($query_execution);
$counter[] = $row[0];
$file_name[] = $row[1];
$identificator[] = $row[2]; //convert database output to multiple array
if($_GET['command'] == "put"){
echo($file_location . "/" . $file_name[0]);
$query = 'UPDATE `session` SET `file_play_code`="'.$identification_code .'",`time_play_code`="0" WHERE ip_session="'.$ip_session.'"';}
else if($_GET['command'] == "update"){
    $query='UPDATE `session` SET `time_play_code`= '.$timeplaycode.' WHERE ip_session="'.$ip_session.'"';
}
$query_execution = mysqli_query($dbconnection, $query);



?>