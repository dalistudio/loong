<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Router Class
 * 路由类
 *
 * Parses URIs and determines routing
 * 处理 URI 和决定路由
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		ExpressionEngine Dev Team
 * @category	Libraries
 * @link		http://codeigniter.com/user_guide/general/routing.html
 */
class CI_Router {

	/**
	 * Config class
	 * 配置类
	 *
	 * @var object
	 * @access public
	 */
	var $config;
	/**
	 * List of routes
	 * 路由列表
	 *
	 * @var array
	 * @access public
	 */
	var $routes			= array();
	/**
	 * List of error routes
	 * 错误路由列表
	 *
	 * @var array
	 * @access public
	 */
	var $error_routes	= array();
	/**
	 * Current class name
	 * 当前类名
	 *
	 * @var string
	 * @access public
	 */
	var $class			= '';
	/**
	 * Current method name
	 * 当前方法名
	 *
	 * @var string
	 * @access public
	 */
	var $method			= 'index';
	/**
	 * Sub-directory that contains the requested controller class
	 *
	 * @var string
	 * @access public
	 */
	var $directory		= '';
	/**
	 * Default controller (and method if specific)
	 * 默认控制器
	 *
	 * @var string
	 * @access public
	 */
	var $default_controller;

	/**
	 * Constructor
	 * 构造器
	 *
	 * Runs the route mapping function.
	 * 运行路由映射函数
	 */
	function __construct()
	{
		$this->config =& load_class('Config', 'core'); // 加载配置文件
		$this->uri =& load_class('URI', 'core'); // 加载URI类
		log_message('debug', "Router Class Initialized"); // 打印日志信息
	}

	// --------------------------------------------------------------------

	/**
	 * Set the route mapping
	 * 设置路由映射
	 *
	 * This function determines what should be served based on the URI request,
	 * as well as any "routes" that have been set in the routing config file.
	 *
	 * @access	private
	 * @return	void
	 */
	function _set_routing()
	{
		// Are query strings enabled in the config file?  Normally CI doesn't utilize query strings
		// since URI segments are more search-engine friendly, but they can optionally be used.
		// If this feature is enabled, we will gather the directory/class/method a little differently
		$segments = array();
		if ($this->config->item('enable_query_strings') === TRUE AND isset($_GET[$this->config->item('controller_trigger')]))
		{
			if (isset($_GET[$this->config->item('directory_trigger')])) // 目录触发器
			{
				$this->set_directory(trim($this->uri->_filter_uri($_GET[$this->config->item('directory_trigger')])));
				$segments[] = $this->fetch_directory(); // 取得目录
			}

			if (isset($_GET[$this->config->item('controller_trigger')])) // 控制器触发器
			{
				$this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));
				$segments[] = $this->fetch_class(); // 取得类
			}

			if (isset($_GET[$this->config->item('function_trigger')])) // 函数触发器
			{
				$this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
				$segments[] = $this->fetch_method(); // 取得方法
			}
		}

		// Load the routes.php file.
		// 加载 routes.php 应用的路由文件
		if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/routes.php'); // 加载应用环境的路由文件
		}
		elseif (is_file(APPPATH.'config/routes.php'))
		{
			include(APPPATH.'config/routes.php'); // 加载应用的路由文件
		}

		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);

		// Set the default controller so we can display it in the event
		// the URI doesn't correlated to a valid controller.
		// 设置默认控制器，所以显示它在事件，URI不能关联到一个无效的控制器
		$this->default_controller = ( ! isset($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower($this->routes['default_controller']);

		// Were there any query string segments?  If so, we'll validate them and bail out since we're done.
		// 有任何查询字符串段？如果是这样的话，我们将验证和保释外出，因为我们做的。
		if (count($segments) > 0)
		{
			return $this->_validate_request($segments); // 验证请求
		}

		// Fetch the complete URI string
		// 取得完整 URI 字符串
		$this->uri->_fetch_uri_string();

		// Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
		// 是否有一个 URI 字符串？如果没有，则默认控制器在 "routes" 文件指定，将显示。
		if ($this->uri->uri_string == '')
		{
			return $this->_set_default_controller(); // 设置默认控制器
		}

		// Do we need to remove the URL suffix?
		// 我们需要删除URL的后缀吗？
		$this->uri->_remove_url_suffix();

		// Compile the segments into an array
		// 编译段到数组
		$this->uri->_explode_segments();

		// Parse any custom routing that may exist
		// 可能存在，处理当前路由
		$this->_parse_routes();

		// Re-index the segment array so that it starts with 1 rather than 0
		// 重新引索段数组，他们开始于1，而不是0
		$this->uri->_reindex_segments();
	}

	// --------------------------------------------------------------------

	/**
	 * Set the default controller
	 * 设置默认控制器
	 *
	 * @access	private
	 * @return	void
	 */
	function _set_default_controller()
	{
		if ($this->default_controller === FALSE)
		{
			show_error("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
		}
		// Is the method being specified?
		if (strpos($this->default_controller, '/') !== FALSE)
		{
			$x = explode('/', $this->default_controller);

			$this->set_class($x[0]);
			$this->set_method($x[1]);
			$this->_set_request($x);
		}
		else
		{
			$this->set_class($this->default_controller);
			$this->set_method('index');
			$this->_set_request(array($this->default_controller, 'index'));
		}

		// re-index the routed segments array so it starts with 1 rather than 0
		$this->uri->_reindex_segments();

		log_message('debug', "No URI present. Default controller set.");
	}

	// --------------------------------------------------------------------

	/**
	 * Set the Route
	 * 设置路由
	 *
	 * This function takes an array of URI segments as
	 * input, and sets the current class/method
	 *
	 * @access	private
	 * @param	array
	 * @param	bool
	 * @return	void
	 */
	function _set_request($segments = array())
	{
		$segments = $this->_validate_request($segments); // 验证请求

		if (count($segments) == 0)
		{
			return $this->_set_default_controller(); // 设置默认控制器
		}

		$this->set_class($segments[0]); // 设置类

		if (isset($segments[1]))
		{
			// A standard method request
			// 一个标准方法请求
			$this->set_method($segments[1]); // 设置方法
		}
		else
		{
			// This lets the "routed" segment array identify that the default
			// index method is being used.
			$segments[1] = 'index'; // 默认方法名
		}

		// Update our "routed" segment array to contain the segments.
		// Note: If there is no custom routing, this array will be
		// identical to $this->uri->segments
		$this->uri->rsegments = $segments;
	}

	// --------------------------------------------------------------------

	/**
	 * Validates the supplied segments.  Attempts to determine the path to
	 * the controller.
	 * 验证所提供的段，并确定控制器路径
	 *
	 * @access	private
	 * @param	array
	 * @return	array
	 */
	function _validate_request($segments)
	{
		if (count($segments) == 0)
		{
			return $segments;
		}

		// Does the requested controller exist in the root folder?
		// 请求的控制器是否存在与根目录？
		if (file_exists(APPPATH.'controllers/'.$segments[0].'.php'))
		{
			return $segments;
		}

		// Is the controller in a sub-folder?
		// 控制器是否在子目录下？
		if (is_dir(APPPATH.'controllers/'.$segments[0]))
		{
			// Set the directory and remove it from the segment array
			// 设置目录并从字段数组中移除
			$this->set_directory($segments[0]);
			$segments = array_slice($segments, 1);

			if (count($segments) > 0)
			{
				// Does the requested controller exist in the sub-folder?
				// 需要的控制器是否存在于子目录下？
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].'.php'))
				{
					if ( ! empty($this->routes['404_override']))
					{
						$x = explode('/', $this->routes['404_override']);

						$this->set_directory('');
						$this->set_class($x[0]);
						$this->set_method(isset($x[1]) ? $x[1] : 'index');

						return $x;
					}
					else
					{
						show_404($this->fetch_directory().$segments[0]); // 返回 404 未找到
					}
				}
			}
			else
			{
				// Is the method being specified in the route?
				if (strpos($this->default_controller, '/') !== FALSE)
				{
					$x = explode('/', $this->default_controller);

					$this->set_class($x[0]);
					$this->set_method($x[1]);
				}
				else
				{
					$this->set_class($this->default_controller);
					$this->set_method('index');
				}

				// Does the default controller exist in the sub-folder?
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.'.php'))
				{
					$this->directory = '';
					return array();
				}

			}

			return $segments;
		}


		// If we've gotten this far it means that the URI does not correlate to a valid
		// controller class.  We will now see if there is an override
		if ( ! empty($this->routes['404_override']))
		{
			$x = explode('/', $this->routes['404_override']);

			$this->set_class($x[0]);
			$this->set_method(isset($x[1]) ? $x[1] : 'index');

			return $x;
		}


		// Nothing else to do at this point but show a 404
		show_404($segments[0]);
	}

	// --------------------------------------------------------------------

	/**
	 *  Parse Routes
	 *  处理路由
	 *
	 * This function matches any routes that may exist in
	 * the config/routes.php file against the URI to
	 * determine if the class/method need to be remapped.
	 *
	 * @access	private
	 * @return	void
	 */
	function _parse_routes()
	{
		// Turn the segment array into a URI string
		$uri = implode('/', $this->uri->segments);

		// Is there a literal match?  If so we're done
		if (isset($this->routes[$uri]))
		{
			return $this->_set_request(explode('/', $this->routes[$uri]));
		}

		// Loop through the route array looking for wild-cards
		foreach ($this->routes as $key => $val)
		{
			// Convert wild-cards to RegEx
			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri))
			{
				// Do we have a back-reference?
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}

				return $this->_set_request(explode('/', $val));
			}
		}

		// If we got this far it means we didn't encounter a
		// matching route so we'll set the site default route
		$this->_set_request($this->uri->segments);
	}

	// --------------------------------------------------------------------

	/**
	 * Set the class name
	 * 设置类名
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function set_class($class)
	{
		$this->class = str_replace(array('/', '.'), '', $class);
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch the current class
	 * 取得当前类
	 *
	 * @access	public
	 * @return	string
	 */
	function fetch_class()
	{
		return $this->class;
	}

	// --------------------------------------------------------------------

	/**
	 *  Set the method name
	 *  设置方法名
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function set_method($method)
	{
		$this->method = $method;
	}

	// --------------------------------------------------------------------

	/**
	 *  Fetch the current method
	 *  取得当前方法
	 *
	 * @access	public
	 * @return	string
	 */
	function fetch_method()
	{
		if ($this->method == $this->fetch_class())
		{
			return 'index';
		}

		return $this->method;
	}

	// --------------------------------------------------------------------

	/**
	 *  Set the directory name
	 *  设置目录名
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function set_directory($dir)
	{
		$this->directory = str_replace(array('/', '.'), '', $dir).'/';
	}

	// --------------------------------------------------------------------

	/**
	 *  Fetch the sub-directory (if any) that contains the requested controller class
	 *  取得子目录
	 *
	 * @access	public
	 * @return	string
	 */
	function fetch_directory()
	{
		return $this->directory;
	}

	// --------------------------------------------------------------------

	/**
	 *  Set the controller overrides
	 *  设置控制器重写
	 *
	 * @access	public
	 * @param	array
	 * @return	null
	 */
	function _set_overrides($routing)
	{
		if ( ! is_array($routing))
		{
			return;
		}

		if (isset($routing['directory'])) // 目录
		{
			$this->set_directory($routing['directory']);
		}

		if (isset($routing['controller']) AND $routing['controller'] != '') // 控制器
		{
			$this->set_class($routing['controller']);
		}

		if (isset($routing['function'])) // 函数
		{
			$routing['function'] = ($routing['function'] == '') ? 'index' : $routing['function'];
			$this->set_method($routing['function']);
		}
	}


}
// END Router Class

/* End of file Router.php */
/* Location: ./system/core/Router.php */
