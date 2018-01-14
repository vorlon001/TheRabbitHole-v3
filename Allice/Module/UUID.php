<?php

namespace Allice\Module;

/**
 * UUID class
 *
 * The following class generates VALID RFC 4122 COMPLIANT
 * Universally Unique IDentifiers (UUID) version 3, 4 and 5.
 *
 * UUIDs generated validates using OSSP UUID Tool, and output
 * for named-based UUIDs are exactly the same. This is a pure
 * PHP implementation.
 *
 * @author Andrew Moore
 * @link http://www.php.net/manual/en/function.uniqid.php#94959
 */
class UUID
{
    /**
     * Generate v3 UUID
     *
     * Version 3 UUIDs are named based. They require a namespace (another 
     * valid UUID) and a value (the name). Given the same namespace and 
     * name, the output is always the same.
     * 
     * @param	uuid	$namespace
     * @param	string	$name
     */
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
    private function __construct() {}

    public static function getInstance()
    {
	if (null === self::$instance) {
            //date_default_timezone_set('Asia/Yekaterinburg');
            //defined('SITE_ROOT_PATH') OR header('Location: /500.html'); 

	    try {
    		self::$instance =  new self(SITE_ROOT_PATH.FILE_EVENT_LOG);
    	        self::$instance ->open();
	    } catch(Throwable $e) {
		throw new \Allice\Exception\Knave_of_Hearts("Knave of Hearts say. Fail:".__NAMESPACE__."/".__METHOD__." L:".__LINE__);
		}
	}
	return self::$instance;
    }

    public static function v3(String $namespace, String $name): String
    {
	if(!self::is_valid($namespace)) return false;

	// Get hexadecimal components of namespace
	$nhex = str_replace(array('-','{','}'), '', $namespace);

	// Binary Value
	$nstr = '';

	// Convert Namespace UUID to bits
	for($i = 0; $i < strlen($nhex); $i+=2) 
	{
	    $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
	}

	// Calculate hash value
	$hash = md5($nstr . $name);

	return sprintf('%08s-%04s-%04x-%04x-%12s',

	// 32 bits for "time_low"
	substr($hash, 0, 8),

	// 16 bits for "time_mid"
	substr($hash, 8, 4),

	// 16 bits for "time_hi_and_version",
	// four most significant bits holds version number 3
	(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

	// 16 bits, 8 bits for "clk_seq_hi_res",
	// 8 bits for "clk_seq_low",
	// two most significant bits holds zero and one for variant DCE1.1
	(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

	// 48 bits for "node"
	substr($hash, 20, 12)
	);
    }

    /**
     * 
     * Generate v4 UUID
     * 
     * Version 4 UUIDs are pseudo-random.
     */
    public static function v4(): String
    {
	return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

	// 32 bits for "time_low"
	mt_rand(0, 0xffff), mt_rand(0, 0xffff),

	// 16 bits for "time_mid"
	mt_rand(0, 0xffff),

	// 16 bits for "time_hi_and_version",
	// four most significant bits holds version number 4
	mt_rand(0, 0x0fff) | 0x4000,

	// 16 bits, 8 bits for "clk_seq_hi_res",
	// 8 bits for "clk_seq_low",
	// two most significant bits holds zero and one for variant DCE1.1
	mt_rand(0, 0x3fff) | 0x8000,

	// 48 bits for "node"
	mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
	);
    }

    /**
     * Generate v5 UUID
     * 
     * Version 5 UUIDs are named based. They require a namespace (another 
     * valid UUID) and a value (the name). Given the same namespace and 
     * name, the output is always the same.
     * 
     * @param	uuid	$namespace
     * @param	string	$name
     */
    public static function v5( String $namespace, String $name): String
    {
	if(!self::is_valid($namespace)) return false;

	// Get hexadecimal components of namespace
	$nhex = str_replace(array('-','{','}'), '', $namespace);

	// Binary Value
	$nstr = '';

	// Convert Namespace UUID to bits
	for($i = 0; $i < strlen($nhex); $i+=2) 
	{
	    $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
	}

	// Calculate hash value
	$hash = sha1($nstr . $name);

	return sprintf('%08s-%04s-%04x-%04x-%12s',

	// 32 bits for "time_low"
	substr($hash, 0, 8),

	// 16 bits for "time_mid"
	substr($hash, 8, 4),

	// 16 bits for "time_hi_and_version",
	// four most significant bits holds version number 5
	(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

	// 16 bits, 8 bits for "clk_seq_hi_res",
	// 8 bits for "clk_seq_low",
	// two most significant bits holds zero and one for variant DCE1.1
	(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

	// 48 bits for "node"
	substr($hash, 20, 12)
	);
    }

    public static function is_valid(String $uuid) {
	return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                      '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
    }
}

?>