<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

echo file_get_contents('./messages.json');
?>