<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Copyright (c) 2014, wangdali <wangdali@qq.com>
 */

/**
 * 基准测试类
 *
 * 这个类使你可以标准点用于计算他们之间的时间差，内存消耗也可以显示。
 */
class CI_Benchmark {

	/**
	 * 添加到链表所有基准标志
	 *
	 * @var array
	 */
	var $marker = array();

	// --------------------------------------------------------------------

	/**
	 * 设置一个基准标志
	 *
	 * 多出调用这个函数，可以使用多个点的定时器
	 *
	 * @access	public
	 * @param	string	$name	name of the marker
	 * @return	void
	 */
	function mark($name)
	{
		$this->marker[$name] = microtime();
	}

	// --------------------------------------------------------------------

	/**
	 * 计算两个标志点之间的时间差
	 *
	 * If the first parameter is empty this function instead returns the
	 * {elapsed_time} pseudo-variable. This permits the full system
	 * execution time to be shown in a template. The output class will
	 * swap the real value for this variable.
	 *
	 * @access	public
	 * @param	string	a particular marked point
	 * @param	string	a particular marked point
	 * @param	integer	the number of decimal places
	 * @return	mixed
	 */
	function elapsed_time($point1 = '', $point2 = '', $decimals = 4)
	{
		if ($point1 == '')
		{
			return '{elapsed_time}';
		}

		if ( ! isset($this->marker[$point1]))
		{
			return '';
		}

		if ( ! isset($this->marker[$point2]))
		{
			$this->marker[$point2] = microtime();
		}

		list($sm, $ss) = explode(' ', $this->marker[$point1]);
		list($em, $es) = explode(' ', $this->marker[$point2]);

		return number_format(($em + $es) - ($sm + $ss), $decimals);
	}

	// --------------------------------------------------------------------

	/**
	 * 内存使用
	 *
	 * This function returns the {memory_usage} pseudo-variable.
	 * This permits it to be put it anywhere in a template
	 * without the memory being calculated until the end.
	 * The output class will swap the real value for this variable.
	 *
	 * @access	public
	 * @return	string
	 */
	function memory_usage()
	{
		return '{memory_usage}';
	}

}

// CI_Benchmark 类结束

/* 文件结束，禁止此行后或之下添加任何东西 */
