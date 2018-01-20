<?php

namespace Allice\Storage;

class Pudding {
    private $_COOKIE;
    private $_GET;
    private $_POST;
    private $_SERVER;

    private static $instance = null;
    private function __clone() {}
    private function __sleep(){}
    private function __wakeup(){}
    public function __isset($name) {}
    public function __unset($name) {}
    public function __set($name, $value) {}
    public function __get($name) {}
    

    private $_domain_request = NULL;
    
    private $EventDispatcher 	= NULL;
    private $Event		= NULL;
    
    public static function getInstance(String $_CONFIG) {
	if (self::$instance == NULL)
	{
	    $_class = __CLASS__;
	    self::$instance = new $_class($_CONFIG);
	}
	return self::$instance;
    }

    private function __construct(String $_CONFIG) {

        $this->EventDispatcher 	= $_CONFIG::EventDispatcher;
	$this->Event		= $_CONFIG::Event;

	$this->_COOKIE	= $_COOKIE;
	$this->_GET	= $_GET;
	$this->_POST	= $_POST;
	$this->_SERVER	= $_SERVER;

    }
    public function _get_host() {
	return sprintf("[%s]/[%s-%s]/[%s]",($ip=$this->_server('REMOTE_ADDR')),(geoip_country_code_by_name($ip)??'Not yet set'),(geoip_country_name_by_name($ip)??'Not yet set'),(geoip_asnum_by_name($ip) ?? 'Not yet set'));
    }
    public function auth_replace($pwd) {
	return htmlspecialchars(str_replace(array("{", "}", "&", "|", "*", ">", "<", "=", "(", ")","^",";","\"","'","\\","/","//",".."), "", $pwd), ENT_QUOTES);
    }
    public function html_replace($html) {
	$c = str_replace(' ', '%20', $html);
	return htmlentities($c);
    }
    public function html_dereplace($html) {
	$c = str_replace('%20', ' ', $html);
	return html_entity_decode($c);
    }
    public function parser($id,$size) {
	return substr($id,0,$size);
    }
    public function _get($id) {
	if(isset($this->_GET[$id])) return $this->auth_replace($this->parser($this->_GET[$id],254));
	return NULL;
    }
    public function _unset_get($id) {
	unset($_GET[$id]);
    }
    public function _unset_post($id){
	unset($_POST[$id]);
    }
    public function _unset_server($id){
	unset($_SERVER[$id]);
    }
    public function _post($id) {
	if(isset($this->_POST[$id])) return $this->auth_replace($this->parser($this->_POST[$id],254));
	return NULL;
    }
    public function _cookie($id) {
        if(isset($this->_COOKIE[$id])) return $this->auth_replace($this->parser($this->_COOKIE[$id],254));
	return NULL;
    }
    public function _server($id) {
	if(isset($this->_SERVER[$id])) return $this->_SERVER[$id]; // return $this->auth_replace($this->parser($this->_SERVER[$id],254));
	return NULL;
    }
    public function _get_input() {
	return file_get_contents('php://input');
    }
    
    /**
     * Parses a user agent string into its important parts
     *
     * @author Jesse G. Donat <donatj@gmail.com>
     * @link https://github.com/donatj/PhpUserAgent
     * @link http://donatstudios.com/PHP-Parser-HTTP_USER_AGENT
     * @param string|null $u_agent User agent string to parse or null. Uses $_SERVER['HTTP_USER_AGENT'] on NULL
     * @throws \InvalidArgumentException on not having a proper user agent to parse.
     * @return string[] an array with browser, version and platform keys
     */
    private function parse_user_agent( $u_agent = null ) {
	if( is_null($u_agent) ) {
	    if( isset($this->_SERVER['HTTP_USER_AGENT']) ) {
	        $u_agent = $this->_SERVER['HTTP_USER_AGENT'];
	    } else {
    		throw new Exception('parse_user_agent requires a user agent');
	    }
	}

        $platform = null;
	$browser  = null;
        $version  = null;

	$empty = array( 'platform' => $platform, 'browser' => $browser, 'version' => $version );

        if( !$u_agent ) return $empty;

	if( preg_match('/\((.*?)\)/im', $u_agent, $parent_matches) ) {
	    preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(New\ )?Nintendo\ (WiiU?|3?DS)|Xbox(\ One)?)
		(?:\ [^;]*)?
		(?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);

	    $priority = array( 'Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android', 'CrOS', 'X11' );

	    $result['platform'] = array_unique($result['platform']);
	    if( count($result['platform']) > 1 ) {
    		if( $keys = array_intersect($priority, $result['platform']) ) {
		    $platform = reset($keys);
    		} else {
		    $platform = $result['platform'][0];
    		}
	    } elseif( isset($result['platform'][0]) ) {
    		$platform = $result['platform'][0];
	    }
	}

	if( $platform == 'linux-gnu' || $platform == 'X11' ) {
	    $platform = 'Linux';
	} elseif( $platform == 'CrOS' ) {
	    $platform = 'Chrome OS';
	}

	preg_match_all('%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|IceCat|Safari|MSIE|Trident|AppleWebKit|
	    TizenBrowser|Chrome|Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|CriOS|UCBrowser|
	    Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
	    Valve\ Steam\ Tenfoot|
    	    NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
	    (?:\)?;?)
	    (?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
	    $u_agent, $result, PREG_PATTERN_ORDER);

	// If nothing matched, return null (to avoid undefined index errors)
	if( !isset($result['browser'][0]) || !isset($result['version'][0]) ) {
	    if( preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result) ) {
    		return array( 'platform' => $platform ?: null, 'browser' => $result['browser'], 'version' => isset($result['version']) ? $result['version'] ?: null : null );
	    }
	    return $empty;
	}

	if( preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $u_agent, $rv_result) ) {
	    $rv_result = $rv_result['version'];
	}

	$browser = $result['browser'][0];
	$version = $result['version'][0];

	$lowerBrowser = array_map('strtolower', $result['browser']);

	$find = function ( $search, &$key, &$value = null ) use ( $lowerBrowser ) {
	    $search = (array)$search;

	    foreach( $search as $val ) {
    		$xkey = array_search(strtolower($val), $lowerBrowser);
    		if( $xkey !== false ) {
		    $value = $val;
		    $key   = $xkey;

		    return true;
    		}
	    }

	    return false;
	};

	$key = 0;
	$val = '';
	if( $browser == 'Iceweasel' || strtolower($browser) == 'icecat' ) {
	    $browser = 'Firefox';
	} elseif( $find('Playstation Vita', $key) ) {
	    $platform = 'PlayStation Vita';
	    $browser  = 'Browser';
	} elseif( $find(array( 'Kindle Fire', 'Silk' ), $key, $val) ) {
		$browser  = $val == 'Silk' ? 'Silk' : 'Kindle';
		$platform = 'Kindle Fire';
		if( !($version = $result['version'][$key]) || !is_numeric($version[0]) ) {
    		    $version = $result['version'][array_search('Version', $result['browser'])];
		}
	} elseif( $find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS' ) {
		$browser = 'NintendoBrowser';
		$version = $result['version'][$key];
	} elseif( $find('Kindle', $key, $platform) ) {
		$browser = $result['browser'][$key];
		$version = $result['version'][$key];
	} elseif( $find('OPR', $key) ) {
		$browser = 'Opera Next';
		$version = $result['version'][$key];
	} elseif( $find('Opera', $key, $browser) ) {
		$find('Version', $key);
		$version = $result['version'][$key];
	} elseif( $find(array( 'IEMobile', 'Edge', 'Midori', 'Vivaldi', 'Valve Steam Tenfoot', 'Chrome' ), $key, $browser) ) {
		$version = $result['version'][$key];
	} elseif( $rv_result && $find('Trident', $key) ) {
		$browser = 'MSIE';
		$version = $rv_result;
	} elseif( $find('UCBrowser', $key) ) {
		$browser = 'UC Browser';
		$version = $result['version'][$key];
	} elseif( $find('CriOS', $key) ) {
		$browser = 'Chrome';
		$version = $result['version'][$key];
	} elseif( $browser == 'AppleWebKit' ) {
		if( $platform == 'Android' && !($key = 0) ) {
    		    $browser = 'Android Browser';
		} elseif( strpos($platform, 'BB') === 0 ) {
    		    $browser  = 'BlackBerry Browser';
    		    $platform = 'BlackBerry';
		} elseif( $platform == 'BlackBerry' || $platform == 'PlayBook' ) {
    		    $browser = 'BlackBerry Browser';
		} else {
    		    $find('Safari', $key, $browser) || $find('TizenBrowser', $key, $browser);
		}

		$find('Version', $key);
	        $version = $result['version'][$key];
	} elseif( $pKey = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser'])) ) {
		$pKey = reset($pKey);

		$platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $pKey);
	        $browser  = 'NetFront';
	}

	return array( 'platform' => $platform ?: null, 'browser' => $browser ?: null, 'version' => $version ?: null );
    }

    public function _ua() {
	$UA=$this->parse_user_agent(substr($this->_SERVER['HTTP_USER_AGENT'],0,255));
	return $UA['platform'].' '.$UA['browser'].' '.$UA['version'];
    }
    public function _ua_browser() {
	$UA = $this->parse_user_agent(substr($this->_SERVER['HTTP_USER_AGENT'],0,255));
	return $UA['browser'];
    }	
}

?>
