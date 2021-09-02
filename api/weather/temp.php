<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$ch = curl_init('api.openweathermap.org/data/2.5/weather?q=Moscow&appid=61ede31797b8686afceeb035d1724b86&units=metric');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$jsn = json_decode($response, true);

echo $jsn["main"]["temp"];
?>