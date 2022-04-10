<?php
function generate_video_list($dbconnection, $type_output)
{
    //if typeoutput is 0, function generate a full link for html5 player
    $query = 'SELECT `counter`, `file_name`, `identificator` FROM `vhp_file_list` WHERE 1';
    $query_execution = mysqli_query($dbconnection, $query);
    if (mysqli_num_rows($query_execution) == 0) {
        return "No file founded.";
    } else {
        $output = "";
        while ($row = mysqli_fetch_array($query_execution)) {
            $counter[] = $row[0];
            $file_name[] = $row[1];
            $identificator[] = $row[2];
        }

        for ($i = 0; count($counter) > $i; $i++) {
            if ($type_output == 1) {
                $output .= '<a class="file_select" onclick="set_video_session(' . $identificator[$i] . ')">' . $file_name[$i] . "</a> <br>";
            }
        }
        return $output;
    }
}

function update_video_list($dbconnection, $directory)
{
    $query = 'SELECT `counter`, `file_name`, `identificator` FROM `vhp_file_list` WHERE 1'; //sql command
    $query_execution = mysqli_query($dbconnection, $query); //execute query
    $correttore = 0; //this variable is used in case db is empty to correct population of database
    if (mysqli_num_rows($query_execution) == 0) {
        $isnew = "###"; //add this to array counter of db beacuse arrey search can't work with an empty array.
        $counter[] = $isnew;
        $file_name[] = $isnew;
        $identificator[] = $isnew;
        $correttore = -1;
    } else {
        while ($row = mysqli_fetch_array($query_execution)) {
            $counter[] = $row[0];
            $file_name[] = $row[1];
            $identificator[] = $row[2];
        }
    }
    $files = array_slice(scandir($directory), 2);
    $counter_added_to_db_counter = 0;
    for ($i = 0; count($files) > $i; $i++) {
        //this variable is used to count the new file added to db.
        $key_search = in_array($files[$i], $file_name); //check if there is another entry in db with the same name, if not, i generate a new entry.
        if ($key_search == false) {
            $counter_added_to_db_counter++;
            while (true) {
                $new_file_identificator = rand(); //generate random number for make a numeric identificator for the file.
                if (!in_array($new_file_identificator, $identificator)) {
                    break; //exit from loop and go with the script.
                }
            } //end of while loop
            $new_file_counter = count($counter);
            $query = 'INSERT INTO `vhp_file_list`(`counter`, `file_name`, `identificator`) VALUES (' . ($new_file_counter + $counter_added_to_db_counter + $correttore) . ',"' . $files[$i] . '",' . $new_file_identificator . ')';
            echo($query . "<br>");
            $query_execution = mysqli_query($dbconnection, $query); //execute query
        }
    }
//write_php_ini($files,$ini_location);
}
function set_ip_Session($dbconnection,$token)
{
//there i generate a session for ip of connected client
    if ($_SESSION["client_ip"] == "") {
        global $remote_relay_server;
        $remote_url = $remote_relay_server.'get_ip.php?action=get&token='.$token;
        $ip_address = file_get_contents($remote_url);
        //echo ($remote_url);
        echo $ip_address;
        $query = 'SELECT `ID`, `ip_session`, `control_code`, `login_code`, `file_play_code` , `time_play_code` FROM `session` WHERE 1';
        $query_execution = mysqli_query($dbconnection, $query); //execute query
        $correttore = 0; //this variable is used in case db is empty to correct population of database
        if (mysqli_num_rows($query_execution) == 0) {
            $isnew = "###"; //add this to array counter of db beacuse arrey search can't work with an empty array.
            $id[] = $isnew;
            $ip_session[] = $isnew;
            $control_code[] = $isnew;
            $login_code[] = $isnew;
            $file_play_code[] = $isnew;
            $time_play_code[] = $isnew;
            $correttore = -1;
        } else {
            while ($row = mysqli_fetch_array($query_execution)) {
                $id[] = $row[0];
                $ip_session[] = $row[1];
                $control_code[] = $row[2];
                $login_code[] = $row[3];
                $file_play_code[] = $row[4];
                $time_play_code[] = $row[5];
            }
        }
//in first place, i check if i have a session with that IP in my DB
        $key_search = in_array($ip_address, $ip_session); //check if there is another entry in db with the same name, if not, i generate a new entry.
        if ($key_search == false) {
            $login_code_new = 0;
            $control_code_new = 0;
            //then i generate the session code for remote play and remote controll
            while (true) {
                $login_code_new = rand(0, 5000);
                $key_search = in_array($login_code_new, $login_code);
                if ($key_search == false) {
                    break;
                }
            }
            while (true) {
                $control_code_new = rand(0, 5000);
                $key_search = in_array($control_code_new, $control_code);
                if ($key_search == false) {
                    break;
                }
            }
            $query = 'INSERT INTO `session`(`ID`, `ip_session`, `control_code`, `login_code`) VALUES (' . count($control_code) . ',"' . $ip_address . '",' . $control_code_new . ',' . $login_code_new . ')';
            $query_execution = mysqli_query($dbconnection, $query); //execute query

            $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
            $txt = $query;


            //echo($query);
        } else {
        }
        return $ip_address;
    }
}
function recovery_session($dbconnections, $ip, $control_code,$login_code,$file_play_code,$time_play_code,$command_type){
    //$query = 'SELECT `counter`, `file_name`, `identificator` FROM `vhp_file_list` WHERE 1';
    //$query_execution = mysqli_query($dbconnections, $query);
    $query = 'SELECT `ID`, `ip_session`, `control_code`, `login_code`, `file_play_code`, `time_play_code` FROM `session` WHERE ip_session="'.$ip.'"';
    $query_execution = mysqli_query($dbconnections, $query);
    $output = 0;
    if($command_type == 0){

        while ($row = mysqli_fetch_array($query_execution)) {
            $output = $row[4];
        }

    } else if ($command_type == 1){
        while ($row = mysqli_fetch_array($query_execution)) {
            $output = $row[5];
        }
    }
    return $output;

}
?>
