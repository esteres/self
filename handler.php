<?php
/*
* 2017 Esteban Restrepo Ramirez
*  @uthor Esteban Restrepo Ramirez <esteban.desarrollado@gmail.com>
*/
mb_internal_encoding('UTF-8');

mb_http_output('UTF-8');

require(dirname(__FILE__).'/config/config.inc.php');
require(_CLASS_DIR_.'Country.php');
require(_CLASS_DIR_.'City.php');
require(_CLASS_DIR_.'Queue.php');
require(_CLASS_DIR_.'ApiAccess.php');
require(_CLASS_DIR_.'WeatherRequestphp');
.
try {
	if(isset($_GET['resource_param'])){
		$resource = $_GET['resource_param'];
		$initials = $_GET['term'];
	}		
	else
		$resource = $_POST['resource_param'];
	$result = null;
	
	if($resource === 'country'){
        $fields = array('country_code', 'country_name');
		$country = new Country($fields);
		$params = array( 'country_initials' => $initials.'%');
		$result = $country->getRecords("country_name LIKE :country_initials", $params);
    }else if($resource === 'city'){
        $fields = array('id', 'name');
		$city = new City($fields);
		$params = array(
					'country_code' => $_GET['country_code'],
					'city_initials' => $initials.'%'
				);
		$result = $city->getRecords("country = :country_code and name LIKE :city_initials", $params);
    }else if($resource === 'weather'){
        $city_param = $_POST['city'];
		$country_code = $_POST['country_code'];
		if (isset($city_param) && isset($country_code)) {
			$fields = array('id', 'name');
			$city = new City($fields);
			$params = array(
						'country_code' => $country_code,
						'city_param' => $city_param
					);
			$result_db = $city->getRecords("country = :country_code and name = :city_param", $params);
			while ($city_name = current($result_db)) {
				if ($city_name == $city_param) {
					$result = key($result_db);
				}
				next($result_db);
			}
			$api_access = new ApiAccess();
			$result = $api_access->getWeatherByCity($result);
			
			$request = array(
							'country' => $result['country'],
							'city' => $result['city_id'],
							'weather' => $result['temp_c'].'|'.$result['temp_f'],
							'local_time' => $result['dt'],
							'request_date_time'	=> date('Y-m-d H:i:s')
						);
			$result['dt'] = date('l jS \of F', $result['dt']); 
			$queue = new Queue();
			$data = json_encode($request);
			$queue->execute_sender(_RABBIT_QUEUE_NAME_, $data); 
		}
	}	
	
	$request_history = new WeatherRequest();
	$request_history->getRecords($data);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Excepción catched: ',  $e->getMessage(), "\n";
}
