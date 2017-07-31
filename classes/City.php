<?php
	require_once ("SQLConnection.php");
	 
	class City extends SQLConection
	 {
		protected $country_code;
		
		protected $city_initials;
		
		protected $_json_file;
		
		public function __construct ($fields)
		{
			parent::__construct ("city");
			$this->fields = $fields;
			$this->_json_file = _CITY_JSON_;
		}
		
		public function getRecords ($where_str=false, $value_params=false, $count=false, $order_str=false, $start=0){
			$cities = parent::getRecords($where_str, $value_params);
			return $cities;
		}
		
		public function import(){
			$json = $this->getCitiesFromJsonFile();
			foreach ($json as $id=>$row) {
				$value_params = array();
				foreach ($row as $key=>$val) {
					$value_params[$key] = $key == 'coord' ? json_encode($val) : $val;
				}
				
				$result = $this->insertRecord($value_params);
			}
		}
		
		private function getCitiesFromJsonFile(){
			$cities = file_get_contents($this->_json_file);
			$json = json_decode($cities, true);
			return $json;
		}
	}
?>