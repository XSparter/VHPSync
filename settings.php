<?php
//setting and other information about software.
//Version Alpha 0.0.1
$db_type = 0; //db type is used to specific what type of database you want to use. 0 is local ini db, for small configuration 1 is for mysql, but not improved for now.
$DatabaseName_DB = "Vhpdb";  //local database file
$Server_DB = "127.0.0.1";
$Password_DB = "vhppassword";
$Username_DB = "vhpuser";
$remote_relay_server = "http://xsparter.altervista.org/github_interface/";


$file_location = "video_folder/video_data"; //file location
$error_debug = true; //for debug if you want full php error print

function print_error(){
    global $error_debug;
    if($error_debug){
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
    }
}
?>
