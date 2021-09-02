<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

function random_color_part() {
    return str_pad(dechex(mt_rand(0,255)), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return '#'.random_color_part().random_color_part().random_color_part();
}

if(isset($_GET['x']) && isset($_GET['y'])) {
    $x = $_GET["x"];
    $y = $_GET["y"];
    $file = file_get_contents('./points.json', FILE_USE_INCLUDE_PATH);
    $points = json_decode($file, true);

    $point = [
        "x" => $x,
        "y" => $y,
        "color" => random_color(),
    ];

    array_push($points, $point);
    file_put_contents('./points.json', json_encode($points));
}
if (filesize('./points.json') > 5242880) {
    file_put_contents('./points.json','[]');
}
?>