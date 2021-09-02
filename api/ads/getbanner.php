<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

echo 'https://d2ph5fj80uercy.cloudfront.net/01/cat'.random_int(1, 5000).'.jpg';
?>