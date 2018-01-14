<?php

namespace Allice\Caterpillar;

class log
{
	private $date_format = "Y-m-d H:i:s";
	
	private $log_filename;
	private $log_file_ptr;
	private $log_file_write_mode = 'a' ;

	private $UUID; 
	

	private static $instance = null;
	private function __clone() {}
	private function __sleep(){}
        private function __wakeup(){}
        public function __isset($name) {}
        public function __unset($name) {}
        public function __call($name, $arguments) {} 
        public static function __callStatic($name, $arguments) {}
	public function __set($name, $value) {}
        public function __get($name) {}

	public static function getInstance()
	{
    	    if (null === self::$instance)
    	    {
	        //date_default_timezone_set('Asia/Yekaterinburg');
	        //defined('SITE_ROOT_PATH') OR header('Location: /500.html'); 

		try {
	    	    self::$instance =  new self(SITE_ROOT_PATH.FILE_EVENT_LOG);
	    	    self::$instance ->open();
		} catch(Throwable $e) {
		    throw new \Allice\Exception\Knave_of_Hearts("Knave of Hearts say. Fail:".__NAMESPACE__."/".__METHOD__." L:".__LINE__." logfile:".$this->log_filename);
		}
    	    }
    	    return self::$instance;
	}

	private function __construct($_log_filename) 
	{

	    try {
		$this->UUID = \Allice\Module\UUID::getInstance()->v4();
	    } catch(Throwable $e) {
		throw new \Allice\Exception\Knave_of_Hearts("Knave of Hearts say. Fail:".__NAMESPACE__."/".__METHOD__." L:".__LINE__." logfile:".$_log_filename);
	    }    
	    try {
		/* Set params */
		$this->log_filename = $_log_filename;
		
		/* Check destination */
		if( is_dir($this->log_filename) ) {
			throw new \Allice\Exception\Knave_of_Hearts("Knave of Hearts say. Fail:".__NAMESPACE__."/".__METHOD__." L:".__LINE__."It is not a logfile:".$this->log_filename);
		}
		
		/* Try to create log file */
		if( ! file_exists ($this->log_filename) ) {
			try {
				$touch_result = @touch($this->log_filename);
			} catch(Throwable $e) {
	    		    throw new \Allice\Exception\Knave_of_Hearts(
		    					"Knave of Hearts say. Fail:".__NAMESPACE__.":/".__METHOD__." L:".__LINE__.
		    					" logfile:".$this->log_filename.
		    					" data:[".
							    "Message :{" . $e->getMessage()."}".
							    "Code :{" . $e->getCode()."}".
							    "File :{" . $e->getFile()."}".
							    "Line :{" . $e->getLine()."}".
							    "Dump :{" . $e->getTraceAsString()."}".
		    					"]"
		    					);
			}
			if( $touch_result == FALSE ) {
			    throw new \Allice\Exception\Knave_of_Hearts(
				        		"Knave of Hearts say. Fail:".__NAMESPACE__.":/".__METHOD__." L:".__LINE__.
		    					" logfile:".$this->log_filename
		    					);
			}
		}
			
		if( ! is_writable($this->log_filename) ) {
			throw new \Allice\Exception\Knave_of_Hearts(
		    				    "Knave of Hearts say. Fail:".__NAMESPACE__.":/".__METHOD__." L:".__LINE__.
		    				    " logfile:".$this->log_filename
		    				    );
		}
	    } catch(Throwable $e) {
		throw new \Allice\Exception\Knave_of_Hearts(
					    "Knave of Hearts say. Fail:".__NAMESPACE__.":/".__METHOD__." L:".__LINE__.
					    " logfile:".$this->log_filename.
					    " data:[".
						"Message :{" . $e->getMessage()."}".
						"Code :{" . $e->getCode()."}".
						"File :{" . $e->getFile()."}".
						"Line :{" . $e->getLine()."}".
						"Dump :{" . $e->getTraceAsString()."}".
					    "]"
					    );
	    }
	}
	
	/**
	 * Class destructor
	 */
	public function __destruct() 
	{
		$close_file_result = FALSE;
		
		if( is_resource($this->log_file_ptr) ) {
			$close_file_result = fclose($this->log_file_ptr);
		}
		
		return $close_file_result;
	}

	private function format_message(String $_domain, Int $_code, String $_event_name, String $_event_id, String $_event_value): String
	{
		$timestamp = $this->get_current_timestamp();
		$message  = " [".$timestamp."]".
			    " [".$this->UUID."]".
			    " [".$_domain."]".
			    " [".$_code."]".
			    " [".$_event_id."]".
			    " [".$_event_name."]".
			    " [".$_event_value."]".PHP_EOL;

		return $message;
	}
	
	/**
	 * Return date/time in preset format
	 */
	private function get_current_timestamp(): String
	{
		
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		
		return date( $this->date_format.".".$micro, $t); 
	}

	/**
	 * @throws Knave_of_Hearts
	 */
	private function open()
	{
		$this->log_file_ptr = fopen($this->log_filename, $this->log_file_write_mode);
				
		if( !$this->log_file_ptr ) {
			throw new \Allice\Exception\Knave_of_Hearts("Knave of Hearts say. Fail:".__NAMESPACE__."/".__METHOD__." L:".__LINE__." logfile:".$this->log_filename);
		}
	}
	
	public function write_message(...$arg)
	{
		$log_message = $this->format_message(...$arg);
		$fwrite_result = fwrite($this->log_file_ptr, $log_message);
		if( $fwrite_result ==FALSE) {
			throw new \Allice\Exception\Knave_of_Hearts("Knave of Hearts say. Fail:".__NAMESPACE__."/".__METHOD__." L:".__LINE__." logfile:".$this->log_filename." arg:".json_encode($arg));
		}
	}
	
}

?>