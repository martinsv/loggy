<?php
/**
 *
 * Simple logger ...
 * @author Igor Carvalho
 *
 */
class Loggy {

	private $file = null;

	private $fileName = '';

	private static $instance = null;
	
	private $format_date = '';
	
	private $log_path = '';
	
	public function __construct() {
		$this->format_date = date('D M d H:i:s Y');
		$this->log_path = realpath('log');
	}

	public static function getLogger($fileName = 'log.log') {
		if(!self::$instance) {
			$class = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance->createLog();
	}

	private function createLog($fileName = 'log.log') {
		$this->fileName = $fileName;
		if(!$this->file) $this->open();
		return $this;
	}

	private function open() {
		$this->file = fopen($this->log_path.'/'.$this->fileName, 'a');
	}

	private function close() {
		fclose($this->file);
		$this->file = null;
	}

	public static function write($message, $type = 'debug') {
		$log = self::getLogger();
		if(!$log->file) $log->open();
		
		if(!is_string($message)) $message = var_export($message, true);
		
		fwrite($log->file, '['.$log->format_date.'] ['.$type.'] '.$message."\n");
		$log->close();
		return $log;
	}

	public static function log($message) {
		return self::write($message, 'log');
	}

	public static function notice($message) {
		return self::write($message, 'notice');
	}

	public static function debug($message) {
		return self::write($message, 'debug');
	}

	public static function error($message) {
		return self::write($message, 'error');
	}
	
	public static function getErrorMessage(Exception $error) {
		$message = $error->getMessage().' in File: '.$error->getFile().' at Line: '.$error->getLine();
		return $message;
	}
}