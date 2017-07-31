<?php
	require_once ("SQLConnection.php");
	require_once ("Country.php");
	class WeatherRequest extends SQLConection
	 {
		public function __construct ()
		{
			parent::__construct ("request");
			$this->fields = array('country', 'city', 'weather', 'local_time', 'request_date_time');
		}
		
		public function getRecords ($where, $value_params){
			$requests = parent::getRecords($where, $value_params);
			return $requests;
		}
		
		public function insertRecord ($value_params){
			$fields = array('id', 'country_name');
			$country = new Country($fields);
			$value_params['country'] = key($country->getRecords("country_code = :country_code", array('country_code' => $value_params['country']), 1));
			$insert = parent::insertRecord($value_params);
			return $insert;
		}
	}
?>