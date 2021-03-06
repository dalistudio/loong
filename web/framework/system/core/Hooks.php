<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Copyright (c) 2014, wangdali <wangdali@qq.com>
 */

// ------------------------------------------------------------------------

/**
 * 勾子类
 *
 * 提供一种机制来扩展基本系统，无需骇客它。
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/encryption.html
 */
class CI_Hooks {

	/**
	 * 确定是否开启 hooks
	 *
	 * @var bool
	 */
	var $enabled		= FALSE;
	/**
	 * 所有 hooks 列表设置在 config/hooks.php文件中
	 *
	 * @var array
	 */
	var $hooks			= array();
	/**
	 * 决定是否用在进程中，用来防止死循环。
	 *
	 * @var bool
	 */
	var $in_progress	= FALSE;

	/**
	 * 构造函数
	 *
	 */
	function __construct()
	{
		$this->_initialize(); // 初始化
		log_message('debug', "Hooks Class Initialized"); // 打印日志信息
	}

	// --------------------------------------------------------------------

	/**
	 * 初始化 Hooks 偏好参数
	 *
	 * @access	private
	 * @return	void
	 */
	function _initialize()
	{
		$CFG =& load_class('Config', 'core'); // 加载配置类

		// 如果 Hooks 没有在配置文件中启用，则这里没有什么事做。

		if ($CFG->item('enable_hooks') == FALSE)
		{
			return;
		}

		// 获取 “hooks” 定义文件，如果没有hooks，则什么都不做。

		if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/hooks.php'))
		{
		    include(APPPATH.'config/'.ENVIRONMENT.'/hooks.php');
		}
		elseif (is_file(APPPATH.'config/hooks.php'))
		{
			include(APPPATH.'config/hooks.php'); // 默认加载配置目录下的hooks.php文件
		}


		if ( ! isset($hook) OR ! is_array($hook))
		{
			return;
		}

		$this->hooks =& $hook;
		$this->enabled = TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Call Hook
	 *
	 * 呼叫特殊的 hook
	 *
	 * @access	private
	 * @param	string	the hook name
	 * @return	mixed
	 */
	function _call_hook($which = '')
	{
		if ( ! $this->enabled OR ! isset($this->hooks[$which]))
		{
			return FALSE;
		}

		if (isset($this->hooks[$which][0]) AND is_array($this->hooks[$which][0]))
		{
			foreach ($this->hooks[$which] as $val) // 循环所有 hook
			{
				$this->_run_hook($val); // 运行 hook
			}
		}
		else
		{
			$this->_run_hook($this->hooks[$which]); // 运行 hook
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Run Hook
	 *
	 * 运行特殊的 hook
	 *
	 * @access	private
	 * @param	array	the hook details
	 * @return	bool
	 */
	function _run_hook($data)
	{
		if ( ! is_array($data))
		{
			return FALSE; // 不存在数据，返回。
		}

		// -----------------------------------
		// Safety - Prevents run-away loops
		// 安全 - 防止死循环
		// -----------------------------------

		// If the script being called happens to have the same
		// hook call within it a loop can happen

		if ($this->in_progress == TRUE)
		{
			return;
		}

		// -----------------------------------
		// Set file path
		// 设置文件路径
		// -----------------------------------

		if ( ! isset($data['filepath']) OR ! isset($data['filename']))
		{
			return FALSE;
		}

		$filepath = APPPATH.$data['filepath'].'/'.$data['filename'];

		if ( ! file_exists($filepath)) // 判断文件是否存在
		{
			return FALSE;
		}

		// -----------------------------------
		// Set class/function name
		// 设置 类/函数 名称
		// -----------------------------------

		$class		= FALSE;
		$function	= FALSE;
		$params		= '';

		if (isset($data['class']) AND $data['class'] != '')
		{
			$class = $data['class']; // 类
		}

		if (isset($data['function']))
		{
			$function = $data['function']; // 函数
		}

		if (isset($data['params']))
		{
			$params = $data['params']; // 参数
		}

		if ($class === FALSE AND $function === FALSE)
		{
			return FALSE;
		}

		// -----------------------------------
		// 设置 在进程内 标志
		// -----------------------------------

		$this->in_progress = TRUE;

		// -----------------------------------
		// 呼叫请求 类 和/或 函数
		// -----------------------------------

		if ($class !== FALSE)
		{
			if ( ! class_exists($class)) // 判断类是否存在
			{
				require($filepath);
			}

			$HOOK = new $class; // 实例化类
			$HOOK->$function($params); // 调用类中的函数
		}
		else
		{
			if ( ! function_exists($function))
			{
				require($filepath);
			}

			$function($params); // 调用函数
		}

		$this->in_progress = FALSE;
		return TRUE;
	}

}

// END CI_Hooks class

/* 文件结束，禁止此行后或之下添加任何东西 */
