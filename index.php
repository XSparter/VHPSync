<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Player</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<h1>Video Player</h1>
<div>
    <?php
    // Funzione per ottenere il tempo di riproduzione dal file .ini
    function getPlaybackTimeFromIni($videoName) {
        $iniPath = 'videos/' . $videoName . '.ini';
        if (file_exists($iniPath)) {
            $iniData = parse_ini_file($iniPath);
            if (isset($iniData['playback_time'])) {
                return intval($iniData['playback_time']);
            }
        }
        return 0; // Ritorna 0 se il file .ini non esiste o non contiene il tempo di riproduzione
    }

    // Verifica se il parametro videoname è stato passato
    if (isset($_GET['videoname'])) {
        // Recupera il nome del video dalla query string
        $videoName = $_GET['videoname'];

        // Costruisci il percorso del file video
        $videoPath = 'videos/' . $videoName . '.mp4';

        // Verifica se il file video esiste
        if (file_exists($videoPath)) {
            // Ottieni il tempo di riproduzione dal file .ini
            $playbackTime = getPlaybackTimeFromIni($videoName);

            // Stampare il video con il tempo di riproduzione ottenuto
            echo "<video id='videoPlayer' controls autoplay>";
            echo "<source src='$videoPath' type='video/mp4'>";
            echo "Il tuo browser non supporta la riproduzione di video HTML5.";
            echo "</video>";

            // Script JavaScript per aggiornare il file .ini
            echo "<script>";
            echo "$(document).ready(function() {";
            echo "    var video = document.getElementById('videoPlayer');";
            echo "    setInterval(function() {";
            echo "        var currentTime = Math.floor(video.currentTime);";
            echo "        $.ajax({";
            echo "            type: 'POST',";
            echo "            url: 'update_ini.php',";
            echo "            data: {";
            echo "                videoname: '$videoName',";
            echo "                playback_time: currentTime";
            echo "            }";
            echo "        });";
            echo "    }, 1000);"; // Ogni secondo
            echo "});";
            echo "</script>";
        } else {
            echo "Il video non esiste.";
        }
    } else {
        echo "Il parametro videoname non è stato fornito.";
    }
    ?>
</div>
</body>
</html>
