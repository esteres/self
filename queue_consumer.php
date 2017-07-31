<?php
/*
* 2017 Esteban Restrepo Ramirez
*  @author Esteban Restrepo Ramirez <esteban.desarrollado@gmail.com>
*/
mb_internal_encoding('UTF-8');

mb_http_output('UTF-8');

require(dirname(__FILE__).'/config/config.inc.php');
require(_CLASS_DIR_.'Queue.php');
require(_CLASS_DIR_.'WeatherRequest.php');
try {
	$queue = new Queue();
	$callback = function($msg){
		echo " * Message received", "\n", $msg->body;
		$data = json_decode($msg->body, true);
		$request = new WeatherRequest();
		$request->insertRecord($data);
	};
	
	$queue = new Queue();
	$queue->execute_consumer(_RABBIT_QUEUE_NAME_, $callback);
} catch (Exception $e) {
    echo 'Excepción catched: ',  $e->getMessage(), "\n";
}