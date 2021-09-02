<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

date_default_timezone_set('Europe/Moscow');

if(isset($_GET['author']) && isset($_GET['text'])) {
    $author = $_GET["author"];
    $text = $_GET["text"];
    $file = file_get_contents('./messages.json', FILE_USE_INCLUDE_PATH);
    $messages = json_decode($file, true);

    $message = [
        "id" => count($messages),
        "author" => $author,
        "text" => $text,
        "datetime" => date("Y-m-d H:i:s"),
    ];

    array_push($messages, $message);
    file_put_contents('./messages.json', json_encode($messages));
}
if (filesize('./messages.json') > 5242880) {
    file_put_contents('./messages.json','[]');
}
?>