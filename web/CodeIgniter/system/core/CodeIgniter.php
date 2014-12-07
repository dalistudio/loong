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
 * 系统初始化文件
 *
 * 加载基类和执行请求
 *
 * @package		CodeIgniter
 * @subpackage	codeigniter
 * @category	Front-controller
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/
 */

/**
 * 版本号
 *
 * @var string
 *
 */
	define('CI_VERSION', '2.2.0');

/**
 * CodeIgniter Branch (Core = TRUE, Reactor = FALSE)
 *
 * @var boolean
 *
 */
	define('CI_CORE', FALSE);

/*
 * ------------------------------------------------------
 *  加载全局函数
 * ------------------------------------------------------
 */
	require(BASEPATH.'core/Common.php');

/*
 * ------------------------------------------------------
 *  加载框架常量
 * ------------------------------------------------------
 */
	// 如果应用中环境目录下存在常量文件则加载，否则加载默认目录下的常量文件
	if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/constants.php'))
	{
		require(APPPATH.'config/'.ENVIRONMENT.'/constants.php');
	}
	else
	{
		require(APPPATH.'config/constants.php');
	}

/*
 * ------------------------------------------------------
 *  定义一个自定义错误的句柄
 * ------------------------------------------------------
 */
	set_error_handler('_exception_handler'); // 系统函数：指定错误发生时的处理函数

	if ( ! is_php('5.3'))
	{
		@set_magic_quotes_runtime(0); // Kill magic quotes
	}

/*
 * ------------------------------------------------------
 *  设置子类的前缀
 * ------------------------------------------------------
 *
 * Normally the "subclass_prefix" is set in the config file.
 * The subclass prefix allows CI to know if a core class is
 * being extended via a library in the local application
 * "libraries" folder. Since CI allows config items to be
 * overriden via data set in the main index. php file,
 * before proceeding we need to know if a subclass_prefix
 * override exists.  If so, we will set this value now,
 * before any classes are loaded
 * Note: Since the config file data is cached it doesn't
 * hurt to load it here.
 */
	if (isset($assign_to_config['subclass_prefix']) AND $assign_to_config['subclass_prefix'] != '')
	{
		get_config(array('subclass_prefix' => $assign_to_config['subclass_prefix']));
	}

/*
 * ------------------------------------------------------
 *  Set a liberal script execution time limit
 *  设置一个自由的脚本执行时间限制
 * ------------------------------------------------------
 */
	if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
	{
		@set_time_limit(300);
	}

/*
 * ------------------------------------------------------
 *  开启定时器... 滴答 滴答
 * ------------------------------------------------------
 */
	$BM =& load_class('Benchmark', 'core'); // 加载类
	$BM->mark('total_execution_time_start'); // 总执行时间开始
	$BM->mark('loading_time:_base_classes_start'); // 加载时间：基类开始

/*
 * ------------------------------------------------------
 *  实例化 hooks 类
 * ------------------------------------------------------
 */
	$EXT =& load_class('Hooks', 'core'); // 加载核心的Hooks类

/*
 * ------------------------------------------------------
 *  是否有一个 "pre_system" 勾子
 * ------------------------------------------------------
 */
	// 系统执行的早期调用.仅仅在benchmark 和 hooks 类 加载完毕的时候. 没有执行路由或者其它的过程.
	$EXT->_call_hook('pre_system'); // 呼叫勾子

/*
 * ------------------------------------------------------
 *  实力化 confiig 类
 * ------------------------------------------------------
 */
	$CFG =& load_class('Config', 'core'); // 加载配置类

	// 我们是否有手动设置配置项在 index.php 文件中？
	if (isset($assign_to_config))
	{
		$CFG->_assign_to_config($assign_to_config); // 分配到配置文件
	}

/*
 * ------------------------------------------------------
 *  实例化 UTF-8 类
 * ------------------------------------------------------
 *
 * Note: Order here is rather important as the UTF-8
 * class needs to be used very early on, but it cannot
 * properly determine if UTf-8 can be supported until
 * after the Config class is instantiated.
 *
 */

	$UNI =& load_class('Utf8', 'core'); // 加载utf8类 

/*
 * ------------------------------------------------------
 *  实例化 URI 类
 * ------------------------------------------------------
 */
	$URI =& load_class('URI', 'core'); // 加载 URI 类

/*
 * ------------------------------------------------------
 *  实例化 routing 类，和设置路由
 * ------------------------------------------------------
 */
	$RTR =& load_class('Router', 'core'); // 加载路由类
	$RTR->_set_routing(); // 设置路由

	// Set any routing overrides that may exist in the main index file
	if (isset($routing))
	{
		$RTR->_set_overrides($routing); // 设置重写
	}

/*
 * ------------------------------------------------------
 *  实例化 output 类
 * ------------------------------------------------------
 */
	$OUT =& load_class('Output', 'core'); // 加载输出类

/*
 * ------------------------------------------------------
 *      是否有一个有效的缓冲文件？如果是，我们做...
 * ------------------------------------------------------
 */
	// 呼叫勾子 'cache_override' 缓冲重写
	// 可以让你调用自己的函数来取代output类中的_display_cache() 函数.这可以让你使用自己的缓存显示方法
	if ($EXT->_call_hook('cache_override') === FALSE)
	{
		// 显示缓冲
		if ($OUT->_display_cache($CFG, $URI) == TRUE)
		{
			exit;
		}
	}

/*
 * -----------------------------------------------------
 *  加载 security 类为了支持 xss 和 csrf
 * -----------------------------------------------------
 */
	$SEC =& load_class('Security', 'core'); // 加载安全类

/*
 * ------------------------------------------------------
 *  加载 Input 类
 * ------------------------------------------------------
 */
	$IN	=& load_class('Input', 'core'); // 加载输入类

/*
 * ------------------------------------------------------
 *  加载 Language 类
 * ------------------------------------------------------
 */
	$LANG =& load_class('Lang', 'core'); // 加载语言类

/*
 * ------------------------------------------------------
 *  加载 app 控制器和本地控制器
 * ------------------------------------------------------
 *
 */
	// 加载基础控制器类
	require BASEPATH.'core/Controller.php'; // 控制器基类

	function &get_instance() // 实例化
	{
		return CI_Controller::get_instance();
	}

	// 判断文件是否存在 应用/核心/控制器继承类
	if (file_exists(APPPATH.'core/'.$CFG->config['subclass_prefix'].'Controller.php'))
	{
		require APPPATH.'core/'.$CFG->config['subclass_prefix'].'Controller.php'; // 加载应用继承的控制类
	}

	// 加载本地应用控制器
	// Note: The Router class automatically validates the controller path using the router->_validate_request().
	// If this include fails it means that the default controller in the Routes.php file is not resolving to something valid.

	// 判断文件是否存在 应用/控制器/所有目录/所有类文件.php
	if ( ! file_exists(APPPATH.'controllers/'.$RTR->fetch_directory().$RTR->fetch_class().'.php'))
	{
		show_error('Unable to load your default controller. Please make sure the controller specified in your Routes.php file is valid.');
	}

	// 加载所有 应用/控制器/所有目录/所有类文件.php
	include(APPPATH.'controllers/'.$RTR->fetch_directory().$RTR->fetch_class().'.php');

	// Set a mark point for benchmarking
	$BM->mark('loading_time:_base_classes_end'); // 加载时间：基类结束

/*
 * ------------------------------------------------------
 *  安全检查
 * ------------------------------------------------------
 *
 *  None of the functions in the app controller or the
 *  loader class can be called via the URI, nor can
 *  controller functions that begin with an underscore
 *
 *  控制器或加载类的函数，不能呼叫 URI。
 *  控制器的函数名也不能以下划线开始。
 */
	$class  = $RTR->fetch_class(); // 类
	$method = $RTR->fetch_method(); // 方法

	if ( ! class_exists($class)
		OR strncmp($method, '_', 1) == 0
		OR in_array(strtolower($method), array_map('strtolower', get_class_methods('CI_Controller')))
		)
	{
		if ( ! empty($RTR->routes['404_override']))
		{
			$x = explode('/', $RTR->routes['404_override']);
			$class = $x[0];
			$method = (isset($x[1]) ? $x[1] : 'index');
			if ( ! class_exists($class))
			{
				if ( ! file_exists(APPPATH.'controllers/'.$class.'.php'))
				{
					show_404("{$class}/{$method}");
				}

				include_once(APPPATH.'controllers/'.$class.'.php');
			}
		}
		else
		{
			show_404("{$class}/{$method}");
		}
	}

/*
 * ------------------------------------------------------
 *  是否存在 "pre_controller" 勾子？
 * ------------------------------------------------------
 */
	// 在调用你的任何控制器之前调用.此时所用的基础类,路由选择和安全性检查都已完成.
	$EXT->_call_hook('pre_controller'); // 呼叫勾子

/*
 * ------------------------------------------------------
 *  实例化 requested 控制器
 * ------------------------------------------------------
 */
	// Mark a start point so we can benchmark the controller
	$BM->mark('controller_execution_time_( '.$class.' / '.$method.' )_start');

	$CI = new $class(); // 实例化新的类

/*
 * ------------------------------------------------------
 *  Is there a "post_controller_constructor" hook?
 *  是否存在 "post_controller_constructor" 勾子？
 * ------------------------------------------------------
 */
	// 在你的控制器实例化之后,任何方法调用之前调用.
	$EXT->_call_hook('post_controller_constructor'); // 呼叫勾子

/*
 * ------------------------------------------------------
 *  Call the requested method
 *  调用 requested 方法
 * ------------------------------------------------------
 */
	// 是否存在 "remap" 函数？如果是，则呼叫它插入 
	if (method_exists($CI, '_remap'))
	{
		$CI->_remap($method, array_slice($URI->rsegments, 2)); // 执行_remap函数
	}
	else
	{
		// is_callable() returns TRUE on some versions of PHP 5 for private and protected
		// methods, so we'll use this workaround for consistent behavior
		if ( ! in_array(strtolower($method), array_map('strtolower', get_class_methods($CI))))
		{
			// 检查看看，如果使用了404重写就使用它。
			if ( ! empty($RTR->routes['404_override']))
			{
				$x = explode('/', $RTR->routes['404_override']);
				$class = $x[0];
				$method = (isset($x[1]) ? $x[1] : 'index');

				// 判断类是否存在
				if ( ! class_exists($class))
				{
					// 判断文件是否存在
					if ( ! file_exists(APPPATH.'controllers/'.$class.'.php'))
					{
						show_404("{$class}/{$method}"); // 显示文件内容
					}

					include_once(APPPATH.'controllers/'.$class.'.php'); // 加载控制器
					unset($CI);
					$CI = new $class(); // 实例化
				}
			}
			else
			{
				show_404("{$class}/{$method}");
			}
		}

		// 呼叫请求的方法
		// 任意 URI 段的处理（除了类/函数）将传给方法转换
		call_user_func_array(array(&$CI, $method), array_slice($URI->rsegments, 2)); // 呼叫用户函数组
	}


	// Mark a benchmark end point
	$BM->mark('controller_execution_time_( '.$class.' / '.$method.' )_end'); // 控制器执行时间：结束

/*
 * ------------------------------------------------------
 *  是否存在 "post_controller" 勾子？
 * ------------------------------------------------------
 */
	// 在你的控制器完全运行之后调用.
	$EXT->_call_hook('post_controller'); // 呼叫勾子

/*
 * ------------------------------------------------------
 *  把最终的内容输出到浏览器
 * ------------------------------------------------------
 */
	// 判断勾子是否存在
	// 覆盖_display()函数, 用来在系统执行末尾向web浏览器发送最终页面.这允许你用自己的方法来显示.
	// 注意，你需要通过 $this->CI =& get_instance() 引用 CI 超级对象，
	// 然后这样的最终数据可以通过调用 $this->CI->output->get_output() 来获得。
	if ($EXT->_call_hook('display_override') === FALSE)
	{
		$OUT->_display(); // 输出显示
	}

/*
 * ------------------------------------------------------
 *  是否存在 "post_system" 勾子？
 * ------------------------------------------------------
 */
	// 在最终渲染的页面发送到浏览器之后,浏览器接收完最终数据的系统执行末尾调用
	$EXT->_call_hook('post_system'); // 呼叫勾子

/*
 * ------------------------------------------------------
 *  如果存在数据库连接，则关闭它。
 * ------------------------------------------------------
 */
	if (class_exists('CI_DB') AND isset($CI->db))
	{
		$CI->db->close(); // 关闭数据库
	}


/* End of file CodeIgniter.php */
/* Location: ./system/core/CodeIgniter.php */
