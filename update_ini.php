<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recupera i dati inviati dalla richiesta POST
    $iniPath = $_POST['ini_path'];
    $timestamp = $_POST['timestamp'];

    // Aggiorna il file .ini con il nuovo timestamp
    $iniContent = "playback_time = $timestamp\n";
    file_put_contents($iniPath, $iniContent);

    // Risponde con un messaggio di successo
    echo "Il file .ini è stato aggiornato con successo!";
} else {
    // Risponde con un errore se la richiesta non è di tipo POST
    http_response_code(405);
    echo "Metodo non consentito";
}
?>
