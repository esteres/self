<?php

/*
* 2017 Esteban Restrepo Ramirez
*  @author Esteban Restrepo Ramirez <esteban.desarrollado@gmail.com>
*/

	class SQLConection {

		protected $_server;
		
		protected $driver;
		
		protected $port;
		
		protected $_user;

		protected $_password;

		protected $_database;
		
		protected $_dbc;
		
		public $table;

		public $fields;

		public function __construct ($table){
			$this->_server = _DB_SERVER_;
			$this->_driver = _DB_DRIVER_;
			$this->_port =_DB_PORT_;
			$this->_database = _DB_NAME_;
			$this->_user = _DB_USER_;
			$this->_password = _DB_PASSWD_;
			
			$this->table =$table;
			$this->fields =array();
			$this->connect();
		} 

		private function connect()
		{
			if ($this->_dbc == NULL) {
				$dsn = "" .
					$this->_driver .
					":host=" . $this->_server .
					";port=" . $this->_port .
					";dbname=" . $this->_database .
					";charset=utf8mb4";
				try {
					$this->_dbc = new PDO( $dsn, $this->_user, $this->_password, array(PDO::ATTR_PERSISTENT => true));
				} catch( PDOException $e ) {
					echo __LINE__.$e->getMessage();
				}
			}
		}
				
		public function __destruct()
		{
			$this->_dbc = NULL;
		}
		
		public function getRecords ($where_str=false, $value_params=false, $count=false, $order_str=false, $start=0){
			$where =$where_str ? "WHERE $where_str" : "";
			$order =$order_str ? "ORDER BY $order_str" : "";
			$limit = $count ? "LIMIT $start, $count" : "";
			$fields =implode (', ', $this->fields);
			$query ="SELECT $fields FROM {$this->table} $where $order $limit";
			if($value_params && $where_str){
				return $this->getQuery($query, $value_params);
			}
			return;
		}
		
		public function insertRecord ($value_params){
			$fields =implode (', ', $this->fields);
			$fields_as_key_values = $this->fields;
			foreach ($fields_as_key_values as &$field) {
				$field = ':'.$field;
			}
			unset($field);
			$query ="INSERT INTO {$this->table} ($fields) VALUES (".join(',', $fields_as_key_values).")";
			return $this->runQuery($query, $value_params);
		}
		
		private function preparaQuery($sql, $value_params, $types = false){
			$stmt = $this->_dbc->prepare( $sql );
			foreach($value_params as $key => &$value) {
				if($types) {
					$stmt->bindParam(":$key",$value,$types[$key]);
				} else {
					if(is_int($value))        { $param = PDO::PARAM_INT; }
					elseif(is_bool($value))   { $param = PDO::PARAM_BOOL; }
					elseif(is_null($value))   { $param = PDO::PARAM_NULL; }
					elseif(is_string($value)) { $param = PDO::PARAM_STR; }
					else { $param = FALSE;}
					if($param) $stmt->bindParam(":$key",$value,$param);
				}
			}
			return $stmt;
		} 
		private function runQuery($sql, $value_params, $types=false) {
			try {
				
				$stmt = $this->preparaQuery($sql, $value_params, $types);
				$count = $stmt->execute() or print_r($this->_dbc->errorInfo());
				echo $count;
			} catch(PDOException $e) {
				echo __LINE__.$e->getMessage();
			}
			return $count;
		}

		private function getQuery( $sql, $value_params, $types=false) {
			$stmt = $this->preparaQuery($sql, $value_params);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
		}
	}
?>