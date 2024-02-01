<?php
function memorizzaDatiMp4($filename, $dato) {
    $iniFileName = 'videos/' . pathinfo($filename, PATHINFO_FILENAME) . '.ini';
    file_put_contents($iniFileName, $dato);
}

function ottieniDatiMp4() {
    $videoFolder = "videos/";
    $files = scandir($videoFolder);
    $data = '';

    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $file_parts = pathinfo($file);
            if ($file_parts['extension'] == "ini") {
                $data .= file_get_contents($videoFolder . $file) . "\n";
            }
        }
    }

    return $data;
}

function memorizzaStatoPlayer($statoPlayer) {
    $iniFileName = 'videos/statoPlayer.ini';
    file_put_contents($iniFileName, $statoPlayer);
}

function ottieniStatoPlayer() {
    $iniFileName = 'videos/statoPlayer.ini';
    return file_get_contents($iniFileName);
}

if (isset($_GET['statoPlayer'])) {
    $statoPlayer = $_GET['statoPlayer'];
    memorizzaStatoPlayer($statoPlayer);
}

if (isset($_GET['getStatoPlayer'])) {
    echo ottieniStatoPlayer();
}
?>