<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Copyright (c) 2014, wangdali <wangdali@qq.com>
 */

// ------------------------------------------------------------------------

/**
 * URI Class
 *
 * 解析 URI 和决定路由
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	URI
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/uri.html
 */
class CI_URI {

	/**
	 * 缓存 URI 段到链表
	 *
	 * @var array
	 * @access public
	 */
	var	$keyval			= array();
	/**
	 * 当前 URI 字符串
	 *
	 * @var string
	 * @access public
	 */
	var $uri_string;
	/**
	 * URI 段的链表
	 *
	 * @var array
	 * @access public
	 */
	var $segments		= array();
	/**
	 * Re-indexed list of uri segments
	 * Starts at 1 instead of 0
	 *
	 * @var array
	 * @access public
	 */
	var $rsegments		= array();

	/**
	 * 构造函数
	 *
	 * Simply globalizes the $RTR object.  The front
	 * loads the Router class early on so it's not available
	 * normally as other classes are.
	 *
	 * @access	public
	 */
	function __construct()
	{
		$this->config =& load_class('Config', 'core'); // 加载配置文件
		log_message('debug', "URI Class Initialized");
	}


	// --------------------------------------------------------------------

	/**
	 * 获取 URI 字符串
	 *
	 * @access	private
	 * @return	string
	 */
	function _fetch_uri_string()
	{
		if (strtoupper($this->config->item('uri_protocol')) == 'AUTO') // 协议类型设置位自动
		{
			// 是否请求来之命令行？
			if (php_sapi_name() == 'cli' or defined('STDIN'))
			{
				$this->_set_uri_string($this->_parse_cli_args()); // 将命令行参数作为URI
				return;
			}

			// 先让我们试下 REQUEST_URI，大多数情况在这下面工作。
			if ($uri = $this->_detect_uri())
			{
				$this->_set_uri_string($uri); // 设置URI
				return;
			}

			// 是否是一个 PATH_INFO 变量？
			// 注意：有些服务器系统似乎使用 getenv() 比较麻烦。所以我们将测试下面两种
			// trim($path,'/') 表示删除 $path 字符串两端的 '/' 符号
			$path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
			if (trim($path, '/') != '' && $path != "/".SELF)
			{
				$this->_set_uri_string($path); // 设置 URI
				return;
			}

			// 没有 PATH_INFO？... 将使用 QUERY_STRING？
			$path =  (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
			if (trim($path, '/') != '')
			{
				$this->_set_uri_string($path); // 设置 URI
				return;
			}

			// 作为最后的努力我们试着用 $_GET
			if (is_array($_GET) && count($_GET) == 1 && trim(key($_GET), '/') != '')
			{
				$this->_set_uri_string(key($_GET)); // 设置 URI
				return;
			}

			// We've exhausted all our options...
			$this->uri_string = '';
			return;
		}

		$uri = strtoupper($this->config->item('uri_protocol')); // 转换位大写

		if ($uri == 'REQUEST_URI')
		{
			$this->_set_uri_string($this->_detect_uri()); // 检查URI并设置
			return;
		}
		elseif ($uri == 'CLI')
		{
			$this->_set_uri_string($this->_parse_cli_args()); // 将命令行参数设置为URI
			return;
		}

		$path = (isset($_SERVER[$uri])) ? $_SERVER[$uri] : @getenv($uri);
		$this->_set_uri_string($path);
	}

	// --------------------------------------------------------------------

	/**
	 * 设置 URI 字符串
	 *
	 * @access	public
	 * @param 	string
	 * @return	string
	 */
	function _set_uri_string($str)
	{
		// 过滤控制字符
		$str = remove_invisible_characters($str, FALSE);

		// 如果 URI 包含只有一个斜线，将删除它。
		$this->uri_string = ($str == '/') ? '' : $str;
	}

	// --------------------------------------------------------------------

	/**
	 * 检查 URI
	 *
	 * 这个函数将自动检测URI和如果有必要的话，修复这个请求字符串
	 *
	 * @access	private
	 * @return	string
	 */
	private function _detect_uri()
	{
		// 判断是否有 'REQUEST_URI' 或 'SCRIPT_NAME'
		if ( ! isset($_SERVER['REQUEST_URI']) OR ! isset($_SERVER['SCRIPT_NAME']))
		{
			return ''; // 不存在则返回空
		}

		$uri = $_SERVER['REQUEST_URI'];
		if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
		{
			$uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
		}
		elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
		{
			$uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
		}

		// This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
		// URI is found, and also fixes the QUERY_STRING server var and $_GET array.
		if (strncmp($uri, '?/', 2) === 0)
		{
			$uri = substr($uri, 2);
		}
		$parts = preg_split('#\?#i', $uri, 2);
		$uri = $parts[0];
		if (isset($parts[1]))
		{
			$_SERVER['QUERY_STRING'] = $parts[1];
			parse_str($_SERVER['QUERY_STRING'], $_GET);
		}
		else
		{
			$_SERVER['QUERY_STRING'] = '';
			$_GET = array();
		}

		if ($uri == '/' || empty($uri))
		{
			return '/';
		}

		$uri = parse_url($uri, PHP_URL_PATH);

		// Do some final cleaning of the URI and return it
		return str_replace(array('//', '../'), '/', trim($uri, '/'));
	}

	// --------------------------------------------------------------------

	/**
	 * 处理命令行参数
	 *
	 * 把每一个命令行的参数分配给 URI段
	 * @access	private
	 * @return	string
	 */
	private function _parse_cli_args()
	{
		$args = array_slice($_SERVER['argv'], 1);

		return $args ? '/' . implode('/', $args) : '';
	}

	// --------------------------------------------------------------------

	/**
	 * 过滤段的恶意字符
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	function _filter_uri($str)
	{
		if ($str != '' && $this->config->item('permitted_uri_chars') != '' && $this->config->item('enable_query_strings') == FALSE)
		{
			// preg_quote() in PHP 5.3 escapes -, so the str_replace() and addition of - to preg_quote() is to maintain backwards
			// compatibility as many are unaware of how characters in the permitted_uri_chars will be parsed as a regex pattern
			if ( ! preg_match("|^[".str_replace(array('\\-', '\-'), '-', preg_quote($this->config->item('permitted_uri_chars'), '-'))."]+$|i", $str))
			{
				show_error('The URI you submitted has disallowed characters.', 400);
			}
		}

		// Convert programatic characters to entities
		$bad	= array('$',		'(',		')',		'%28',		'%29');
		$good	= array('&#36;',	'&#40;',	'&#41;',	'&#40;',	'&#41;');

		return str_replace($bad, $good, $str);
	}

	// --------------------------------------------------------------------

	/**
	 * 如果有需要从URL删除后缀
	 *
	 * @access	private
	 * @return	void
	 */
	function _remove_url_suffix()
	{
		if  ($this->config->item('url_suffix') != "")
		{
			$this->uri_string = preg_replace("|".preg_quote($this->config->item('url_suffix'))."$|", "", $this->uri_string);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * 展开 URI 段，将段保存到 $this->segments 数组中
	 *
	 * @access	private
	 * @return	void
	 */
	function _explode_segments()
	{
		foreach (explode("/", preg_replace("|/*(.+?)/*$|", "\\1", $this->uri_string)) as $val)
		{
			// Filter segments for security
			$val = trim($this->_filter_uri($val));

			if ($val != '')
			{
				$this->segments[] = $val;
			}
		}
	}

	// --------------------------------------------------------------------
	/**
	 * 重新引索段
	 *
	 * This function re-indexes the $this->segment array so that it
	 * starts at 1 rather than 0.  Doing so makes it simpler to
	 * use functions like $this->uri->segment(n) since there is
	 * a 1:1 relationship between the segment array and the actual segments.
	 *
	 * @access	private
	 * @return	void
	 */
	function _reindex_segments()
	{
		array_unshift($this->segments, NULL);
		array_unshift($this->rsegments, NULL);
		unset($this->segments[0]);
		unset($this->rsegments[0]);
	}

	// --------------------------------------------------------------------

	/**
	 * 取一个URI段
	 *
	 * This function returns the URI segment based on the number provided.
	 *
	 * @access	public
	 * @param	integer
	 * @param	bool
	 * @return	string
	 */
	function segment($n, $no_result = FALSE)
	{
		return ( ! isset($this->segments[$n])) ? $no_result : $this->segments[$n];
	}

	// --------------------------------------------------------------------

	/**
	 * 取一个 URI 路由到段
	 *
	 * This function returns the re-routed URI segment (assuming routing rules are used)
	 * based on the number provided.  If there is no routing this function returns the
	 * same result as $this->segment()
	 *
	 * @access	public
	 * @param	integer
	 * @param	bool
	 * @return	string
	 */
	function rsegment($n, $no_result = FALSE)
	{
		return ( ! isset($this->rsegments[$n])) ? $no_result : $this->rsegments[$n];
	}

	// --------------------------------------------------------------------

	/**
	 * 生成一个键-值对来至URI字符串
	 *
	 * This function generates and associative array of URI data starting
	 * at the supplied segment. For example, if this is your URI:
	 *
	 *	example.com/user/search/name/joe/location/UK/gender/male
	 *
	 * You can use this function to generate an array with this prototype:
	 *
	 * array (
	 *			name => joe
	 *			location => UK
	 *			gender => male
	 *		 )
	 *
	 * @access	public
	 * @param	integer	the starting segment number
	 * @param	array	an array of default values
	 * @return	array
	 */
	function uri_to_assoc($n = 3, $default = array())
	{
		return $this->_uri_to_assoc($n, $default, 'segment');
	}
	/**
	 * Identical to above only it uses the re-routed segment array
	 *
	 * @access 	public
	 * @param 	integer	the starting segment number
	 * @param 	array	an array of default values
	 * @return 	array
	 *
	 */
	function ruri_to_assoc($n = 3, $default = array())
	{
		return $this->_uri_to_assoc($n, $default, 'rsegment');
	}

	// --------------------------------------------------------------------

	/**
	 * Generate a key value pair from the URI string or Re-routed URI string
	 *
	 * @access	private
	 * @param	integer	the starting segment number
	 * @param	array	an array of default values
	 * @param	string	which array we should use
	 * @return	array
	 */
	function _uri_to_assoc($n = 3, $default = array(), $which = 'segment')
	{
		if ($which == 'segment')
		{
			$total_segments = 'total_segments';
			$segment_array = 'segment_array';
		}
		else
		{
			$total_segments = 'total_rsegments';
			$segment_array = 'rsegment_array';
		}

		if ( ! is_numeric($n))
		{
			return $default;
		}

		if (isset($this->keyval[$n]))
		{
			return $this->keyval[$n];
		}

		if ($this->$total_segments() < $n)
		{
			if (count($default) == 0)
			{
				return array();
			}

			$retval = array();
			foreach ($default as $val)
			{
				$retval[$val] = FALSE;
			}
			return $retval;
		}

		$segments = array_slice($this->$segment_array(), ($n - 1));

		$i = 0;
		$lastval = '';
		$retval  = array();
		foreach ($segments as $seg)
		{
			if ($i % 2)
			{
				$retval[$lastval] = $seg;
			}
			else
			{
				$retval[$seg] = FALSE;
				$lastval = $seg;
			}

			$i++;
		}

		if (count($default) > 0)
		{
			foreach ($default as $val)
			{
				if ( ! array_key_exists($val, $retval))
				{
					$retval[$val] = FALSE;
				}
			}
		}

		// Cache the array for reuse
		$this->keyval[$n] = $retval;
		return $retval;
	}

	// --------------------------------------------------------------------

	/**
	 * Generate a URI string from an associative array
	 *
	 *
	 * @access	public
	 * @param	array	an associative array of key/values
	 * @return	array
	 */
	function assoc_to_uri($array)
	{
		$temp = array();
		foreach ((array)$array as $key => $val)
		{
			$temp[] = $key;
			$temp[] = $val;
		}

		return implode('/', $temp);
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a URI Segment and add a trailing slash
	 *
	 * @access	public
	 * @param	integer
	 * @param	string
	 * @return	string
	 */
	function slash_segment($n, $where = 'trailing')
	{
		return $this->_slash_segment($n, $where, 'segment');
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a URI Segment and add a trailing slash
	 *
	 * @access	public
	 * @param	integer
	 * @param	string
	 * @return	string
	 */
	function slash_rsegment($n, $where = 'trailing')
	{
		return $this->_slash_segment($n, $where, 'rsegment');
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a URI Segment and add a trailing slash - helper function
	 *
	 * @access	private
	 * @param	integer
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function _slash_segment($n, $where = 'trailing', $which = 'segment')
	{
		$leading	= '/';
		$trailing	= '/';

		if ($where == 'trailing')
		{
			$leading	= '';
		}
		elseif ($where == 'leading')
		{
			$trailing	= '';
		}

		return $leading.$this->$which($n).$trailing;
	}

	// --------------------------------------------------------------------

	/**
	 * Segment Array
	 *
	 * @access	public
	 * @return	array
	 */
	function segment_array()
	{
		return $this->segments;
	}

	// --------------------------------------------------------------------

	/**
	 * Routed Segment Array
	 *
	 * @access	public
	 * @return	array
	 */
	function rsegment_array()
	{
		return $this->rsegments;
	}

	// --------------------------------------------------------------------

	/**
	 * Total number of segments
	 *
	 * @access	public
	 * @return	integer
	 */
	function total_segments()
	{
		return count($this->segments);
	}

	// --------------------------------------------------------------------

	/**
	 * Total number of routed segments
	 *
	 * @access	public
	 * @return	integer
	 */
	function total_rsegments()
	{
		return count($this->rsegments);
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch the entire URI string
	 *
	 * @access	public
	 * @return	string
	 */
	function uri_string()
	{
		return $this->uri_string;
	}


	// --------------------------------------------------------------------

	/**
	 * Fetch the entire Re-routed URI string
	 *
	 * @access	public
	 * @return	string
	 */
	function ruri_string()
	{
		return '/'.implode('/', $this->rsegment_array());
	}

}
// END URI Class

/* 文件结束，禁止此行后或之下添加任何东西 */
