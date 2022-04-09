<?php
include "../function_library/data_utility.php";

function create_video_list($directory,$ini_location){
    $files = scandir($directory);
    write_php_ini($files,$ini_location);
}

?>
