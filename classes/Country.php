<?php
	require_once ("SQLConnection.php");

	class Country extends SQLConection
	 {
		public function __construct ($fields)
		{
			parent::__construct ("country");
			$this->fields = $fields;
		}
		
		public function getRecords ($where_str=false, $value_params=false, $count=false, $order_str=false, $start=0){
			$countries = parent::getRecords($where_str, $value_params);
			return $countries;
		}
	}
?>
	