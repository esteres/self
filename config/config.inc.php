<?php

define('__BASE_URI__', '/weather/');

$currentDir = dirname(__FILE__);
define('_ROOT_DIR_',             realpath($currentDir.'/..'));
define('_CLASS_DIR_',            _ROOT_DIR_.'/classes/');
define('_CONTROLLER_DIR_',       _ROOT_DIR_.'/controllers/');
define('_JS_DIR_',               __BASE_URI__.'js/');
define('_CSS_DIR_',              __BASE_URI__.'css/');
define('_IMG_DIR_',              _ROOT_DIR_.'/images/');
define('_VENDOR_DIR_',           _ROOT_DIR_.'/vendor/');
define('_CITY_JSON_', 'city.json');
define('_DB_SERVER_', 'localhost');
define('_DB_DRIVER_', 'mysql');
define('_DB_PORT_', 3307);
define('_DB_NAME_', 'weather');
define('_DB_USER_', 'root');
define('_DB_PASSWD_', 'este1037');

/*rabbit properties*/

define('_RABBIT_SERVER_', 'localhost');
define('_RABBIT_PORT_', 5672);
define('_RABBIT_USER_', 'guest');
define('_RABBIT_PASSWD_', 'guest');
define('_RABBIT_QUEUE_NAME_', 'process_weather');

/*openweathermap api properties*/

define('_API_URL', 'http://api.openweathermap.org/data/2.5/weather?');
define('_API_TOKEN_', '4a704e068c30b8c35c88c2bd6c903f4b');
define('_API_ICONS_URL', 'http://openweathermap.org/img/w/');