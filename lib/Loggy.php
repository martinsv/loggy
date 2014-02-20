<?php
 namespace Loggy;

/**
 * Loggy is a class to create and manage log file
 * @author Igor Carvalho
 */
class Loggy {

	const DEBUG = 'debug';

	const ERROR = 'error';

	const INFO

	private $file = null;

	private $fileName = '';

	private static $instance = null;
	
	private $format_date = '';
	
	private $log_path = '';
	
	/**
	 * Contructor of object, setting the configuration of format date and path of log
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->format_date = date('D M d H:i:s Y');
		$this->log_path = realpath('log');
	}

	/**
	 * Static function get fetch loggy instance
	 *
	 * @param {string} $fileName File name to log with full path
	 * @access static
	 * @return {object} instance
	 */
	public static function getLogger($fileName = '/var/log/applog.log') {
		if(!self::$instance) {
			$class = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance->createLog();
	}

	/**
	 * Method to create log file and open to write log
	 *
	 * @access private
	 * @param {string} $fileName File name to log with full path
	 * @return object
	 */
	private function createLog($fileName = '/var/log/applog.log') {
		$this->fileName = $fileName;
		if(!$this->file) $this->open();
		return $this;
	}

	/**
	 * Method to open file
	 *
	 * @access private
	 * @return object
	 */ 
	private function open() {
		$this->file = fopen($this->fileName, 'a');
		return $this;
	}

	/**
	 * Method to close file
	 * 
	 * @access private 
	 * @return object
	 */
	private function close() {
		fclose($this->file);
		$this->file = null;
		return $this;
	}

	/**
	 * Static method to open and write log to file
	 *
	 * @access static
	 * @param {string|object} Message to be logged, can be string or object
	 * @param {string} Type of log, can be [debug, log, notice, error]
	 * @return {object} Instance of Loggy
	 */
	public static function write($message, $type = 'debug') {
		$log = self::getLogger();
		if(!$log->file) $log->open();
		
		if(!is_string($message)) $message = var_export($message, true);
		
		fwrite($log->file, '['.$log->format_date.'] ['.$type.'] '.$message."\n");
		$log->close();
		return $log;
	}

	/**
	 * Static method to log message
	 * 
	 * @param {string|object} Message to be logged
	 * @return {object} Instance of Loggy
	 */
	public static function log($message) {
		return self::write($message, 'log');
	}

	/**
	 * Static method to notice message
	 *
	 * @param {string|object} Message to be logged
	 * @return {object} Instance of Loggy
	 */
	public static function notice($message) {
		return self::write($message, 'notice');
	}

	/**
	 * Static method to notice an info message
	 *
	 * @param {string|object} Message to be logged
	 * @return {object} Instance of Loggy
	 */
	public static function info($message) {
		return self::write($message, 'info');
	}

	/**
	 * Static method to debug string or variable
	 *
	 * @param {string|object} Message to be logged
	 * @return {object} Instance of Loggy
	 */ 
	public static function debug($message) {
		return self::write($message, 'debug');
	}

	/**
	 * Static method to log an error 
	 *
	 * @param {string|object} Message to be logged
	 * @return {object} Instance of Loggy
	 */
	public static function error($message) {
		return self::write($message, 'error');
	}
	
	/**
	 * Static method to customize error message
	 *
	 * @param {object} Instance of \Exception
	 * @return {string} Custom message
	 */ 
	public static function getErrorMessage(\Exception $error) {
		$message = $error->getMessage().' in File: '.$error->getFile().' at Line: '.$error->getLine();
		return $message;
	}
}