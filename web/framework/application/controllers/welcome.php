<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * 这个控制器的默认动作
	 *
	 * 对应的网址为：
	 * 		http://example.com/index.php/welcome
	 *	- 或 -  
	 * 		http://example.com/index.php/welcome/index
	 *	- 或 -
	 *		http://example.com/
	 *
	 */
	public function index()
	{
		$this->load->view('welcome/message');
	}
}

/* 文件结束，禁止此行后或之下添加任何东西 */
