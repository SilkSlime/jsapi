<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$last = date('Y-m-d H:i:s', 0);
if (isset($_GET["last"])) {
    $last = date($_GET["last"]);
}


$wait = time()+100;
while(true) {
    $file = file_get_contents('./messages.json', FILE_USE_INCLUDE_PATH);
    $messages = json_decode($file, true);
    $new_messages = [];
    if (!empty($messages)) {
        foreach ($messages as $message) {
            if (date($message["datetime"]) > $last) {
                array_push($new_messages, $message);
            }
        }
    }
    
    if (count($new_messages) != 0) {
        echo json_encode($new_messages);
        break;
        return;
    }
    if(time() >= $wait){
        echo '[]';
        break;
        return;
    }
    sleep(0.2);
}
?>