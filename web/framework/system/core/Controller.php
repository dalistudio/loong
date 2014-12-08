<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Copyright (c) 2014, wangdali <wangdali@qq.com>
 */

/**
 * 控制器基类
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 */
class CI_Controller {

	private static $instance;

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class); // 加载类
		}

		$this->load =& load_class('Loader', 'core'); // 加载加载类

		$this->load->initialize(); // 初始化加载加载类
		
		log_message('debug', "Controller Class Initialized");
	}

	// 获得实例化句柄
	public static function &get_instance()
	{
		return self::$instance;
	}
}
// 控制器类结束

/* 文件结束，禁止此行后或之下添加任何东西 */
