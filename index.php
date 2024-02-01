<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Management</title>
    <style>
        body {
            background-color: black;
            color: white;
        }
        a.dependent {
            color: red;
        }
        a.master {
            color: green;
        }
    </style>
</head>
<body>
<?php
$videoFolder = "videos/";
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';

// Scansiona la cartella dei video
$files = scandir($videoFolder);

// Verifica ogni file nella cartella
foreach ($files as $file) {
    // Ignora le directory correnti e precedenti
    if ($file != "." && $file != "..") {
        // Verifica se il file è un video
        $file_parts = pathinfo($file);
        if ($file_parts['extension'] == "mp4") {
            // Stampa a video la lista dei file con due link ipertestuali
            echo "<p>";
            echo $file;
            echo " <a href='index.php?videoname=$file&mode=dependent' class='dependent'>Dipendente</a>";
            echo " <a href='index.php?videoname=$file&mode=master' class='master'>Master</a>";
            echo "</p>";
        }
    }
}

// Se filename contiene qualcosa, crea un player video HTML5
if (isset($_GET['videoname'])) {
    $videoName = $_GET['videoname'];
    echo "<video id='videoPlayer' controls><source src='$videoFolder$videoName' type='video/mp4'></video>";
}
?>
<script>
    // Crea una variabile JavaScript e assegna il valore della variabile PHP mode
    var mode = "<?php echo $mode; ?>";
    var videoPlayer = document.getElementById('videoPlayer');

    if (mode == "master") {
        setInterval(memorizzaStatoPlayer, 1000);
    } else if (mode == "dependent") {
        setInterval(sincronizzaStatoPlayer, 1000);
    }

    function memorizzaStatoPlayer() {
        var tempoDiRiproduzione = videoPlayer.currentTime;
        var isPaused = videoPlayer.paused;
        var statoPlayer = tempoDiRiproduzione + "##" + isPaused;

        // Memorizza lo stato del player in un file .ini
        // Nota: Questa parte del codice richiede una chiamata AJAX a un file PHP per scrivere effettivamente il file .ini
        // Poiché JavaScript non può scrivere direttamente i file sul server
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "iniupdater.php?statoPlayer=" + encodeURIComponent(statoPlayer), true);
        xhr.send();
    }

    function sincronizzaStatoPlayer() {
        // Fai una chiamata AJAX a un file PHP che legge il file .ini e restituisce lo stato del player
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "iniupdater.php?getStatoPlayer=true", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var statoPlayer = xhr.responseText.split('##');
                var tempoDiRiproduzione = parseFloat(statoPlayer[0]);
                var isPaused = statoPlayer[1] == 'true';

                // Sincronizza lo stato del player locale con lo stato del player nel file .ini
                videoPlayer.currentTime = tempoDiRiproduzione;
                if (isPaused) {
                    videoPlayer.pause();
                } else {
                    videoPlayer.play();
                }
            }
        }
        xhr.send();
    }
</script>
</body>
</html>