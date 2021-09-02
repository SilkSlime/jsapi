<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$ch = curl_init('api.openweathermap.org/data/2.5/weather?q=Moscow&appid=61ede31797b8686afceeb035d1724b86&units=metric');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$jsn = json_decode($response, true);
$json = [
    "temp" => $jsn["main"]["temp"],
    "feel" => $jsn["main"]["feels_like"],
    "humidity" => $jsn["main"]["humidity"],
    "wind" => $jsn["wind"]["speed"],
    "img" => 'http://openweathermap.org/img/wn/'.$jsn["weather"][0]["icon"].'@2x.png',
];
echo json_encode($json, JSON_UNESCAPED_SLASHES);
?>