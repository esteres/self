<?php	 
	class ApiAccess
	 {
		protected $_api_url;
		
		protected $_api_token;
		
		public function __construct ()
		{
			$this->_api_url = _API_URL;
			$this->_api_token = _API_TOKEN_;
		}
		
		public function getWeatherByCity($city_id){
			$weather_set = file_get_contents($this->_api_url."id=".$city_id."&appid=".$this->_api_token);
			$json = json_decode($weather_set);
			return $this->extractData($json);
		}
		
		private function extractData($json){
			$weather_response_set = array();
			$node = $json->main;
			$weather_response_set['temp_c'] =  round($node->temp - 273.15, 0, PHP_ROUND_HALF_DOWN) .'°C';
			$weather_response_set['temp_f'] = round(1.8 * ($node->temp - 273.15) + 32, 0, PHP_ROUND_HALF_DOWN) .'°F';
			$weather_response_set['pressure'] = $node->pressure.' hpa';
			$weather_response_set['humidity'] = $node->humidity.' %';
			$node = $json->weather[0];
			$weather_response_set['weather_main'] = $node->main;
			$weather_response_set['weather_description'] = $node->description;
			$weather_response_set['icon_url'] = _API_ICONS_URL.$node->icon.'.png';
			$node = $json->wind;
			$weather_response_set['wind_speed'] =  $node->speed.' m/s';
			$weather_response_set['wind_deg'] =  $node->deg.' °';
			$node = $json->sys;
			$weather_response_set['sunset'] =  date_sunset($node->sunset);
			$weather_response_set['sunrise'] = date_sunrise($node->sunrise);
			$weather_response_set['country'] = $node->country;
			$weather_response_set['city'] =  $json->name;
			$weather_response_set['city_id'] =  $json->id;
			$weather_response_set['dt'] = $json->dt; 
			return $weather_response_set;
		}
	}
?>


