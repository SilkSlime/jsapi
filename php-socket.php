<?php
date_default_timezone_set('Europe/Moscow');
define('HOST_NAME',"0.0.0.0"); 
define('PORT',"8080");
$null = NULL;
$id = 0;
require_once("class.chathandler.php");
$chatHandler = new ChatHandler();

$socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socketResource, 0, PORT);
socket_listen($socketResource);

$names = [];

$clientSocketArray = array($socketResource);
while (true) {
	$newSocketArray = $clientSocketArray;
	socket_select($newSocketArray, $null, $null, 0, 10);
	
	if (in_array($socketResource, $newSocketArray)) {
		$newSocket = socket_accept($socketResource);
		$clientSocketArray[] = $newSocket;
		
		$header = socket_read($newSocket, 1024);
		$chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT);
		
		socket_getpeername($newSocket, $client_ip_address);
		$connectionACK = $chatHandler->newConnectionACK($client_ip_address, $id);
		$id = $id+1;
		
		$chatHandler->send($connectionACK);
		
		$newSocketIndex = array_search($socketResource, $newSocketArray);
		unset($newSocketArray[$newSocketIndex]);
	}
	
	foreach ($newSocketArray as $newSocketArrayResource) {	
		while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
			socket_getpeername($newSocketArrayResource, $client_ip_address);
			$socketMessage = $chatHandler->unseal($socketData);
			
			$chatHandler->sendChat($newSocketArrayResource, $socketMessage, $id);
			$id = $id+1;
			break 2;
		}
		
		$socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
		if ($socketData === false) { 
			socket_getpeername($newSocketArrayResource, $client_ip_address);
			$connectionACK = $chatHandler->connectionDisconnectACK($client_ip_address);
			$chatHandler->send($connectionACK);
			$newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
			unset($clientSocketArray[$newSocketIndex]);			
		}
	}
}
socket_close($socketResource);