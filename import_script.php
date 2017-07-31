<?php
/*
* 2017 Esteban Restrepo Ramirez
*  @author Esteban Restrepo Ramirez <esteban.desarrollado@gmail.com>
*/
mb_internal_encoding('UTF-8');

mb_http_output('UTF-8');

require(dirname(__FILE__).'/config/config.inc.php');
require(_CLASS_DIR_.'City.php');

try {
	$fields = array('id', 'name', 'country', 'coord');
	$city = new City($fields);
	$city->import();
		
} catch (Exception $e) {
    echo 'Excepción catched: ',  $e->getMessage(), "\n";
}