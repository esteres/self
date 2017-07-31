<?php

/*
* 2017 Esteban Restrepo Ramirez
*  @uthor Esteban Restrepo Ramirez <esteban.desarrollado@gmail.com>
*/
	require_once (_VENDOR_DIR_.'autoload.php');
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	use PhpAmqpLib\Message\AMQPMessage;
	
	class Queue {

		protected $_server;
		
		protected $_port;
		
		protected $_user;

		protected $_password;
		
		protected $channel;

		public function __construct (){
			$this->_server = _RABBIT_SERVER_;
			$this->_port =_RABBIT_PORT_;
			$this->_user = _RABBIT_USER_;
			$this->_password = _RABBIT_PASSWD_;
			$this->connect();
		} 

		private function connect()
		{
			if ($this->channel == NULL) {
				try {
					$connection = new AMQPStreamConnection($this->_server, $this->_port, $this->_user, $this->_password);
					$this->channel = $connection->channel();
					$this->channel->queue_declare(_RABBIT_QUEUE_NAME_, false, false, false, false);
				} catch( Exception $e ) {
					echo __LINE__.$e->getMessage();
				}
			}
		}
				
		public function __destruct()
		{
			$this->channel = NULL;
		}
		
		public function execute_consumer($queue_name, $callback){
			$this->channel->basic_consume($queue_name, '', false, true, false, false, $callback);
			while(count($this->channel->callbacks)) {
				$this->channel->wait();
			}
		}
		
		public function execute_sender($queue_name, $msg){
			$msg = new AMQPMessage($msg, array('delivery_mode' => 2));
			$this->channel->basic_publish($msg, '', $queue_name);
		}
	}
?>