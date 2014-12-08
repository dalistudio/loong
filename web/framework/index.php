<?php
/*
 *---------------------------------------------------------------
 * 应用环境
 *---------------------------------------------------------------
 *
 * 你可以加载不同的配置取决于你当前的环境。
 * 设置环境也影响者诸如登录和错误报告。
 *
 * 这可以设置为任何东西，但默认使用：
 *
 *     development	开发
 *     testing		测试
 *     production	产品
 *
 * 注意：如果你改变这些，也需改变 error_reporting() 函数的代码
 *
 */
	define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * 错误报告
 *---------------------------------------------------------------
 *
 * 不同的环境需要不同级别的错误报告。
 * 默认环境为 development 将显示错误，但 testing 将隐藏。
 */

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL); // 输出所有错误
		break;
	
		case 'testing':
		case 'production':
			error_reporting(0); // 不输出错误
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

/*
 *---------------------------------------------------------------
 * 系统目录名
 *---------------------------------------------------------------
 *
 * 这个变量必需包含你的 "system" 目录名称。
 * 如果 "system" 目录和这个文件不在同一目录，请包含完整路径。
 *
 */
	$system_path = 'system';

/*
 *---------------------------------------------------------------
 * 应用目录名
 *---------------------------------------------------------------
 *
 * 如果你想前端控制器使用不同的 "application" 目录，然后你可以设置默认名字在这里。
 * 这个目录可以重新命名或重新定位到你服务器的任意地方。
 * 如果你这样做，更多信息请看用户指南：
 * http://www.codeigniter.org.cn/user_guide/general/managing_apps.html
 *
 * 末尾没有斜线
 *
 */
	$application_folder = 'application';

/*
 * --------------------------------------------------------------------
 * 默认控制器
 * --------------------------------------------------------------------
 *
 * 通常你将在 routes.php 文件中设置你的默认控制器。
 * 你可以强制为指定的控制器 类/函数 设置硬编码路由。
 * 对于大多数应用，你将不会在这里设置路由，
 * 
 * 
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * 取消注释 使用 $routing 数组这个特色
 *
 */
	// The directory name, relative to the "controllers" folder.  Leave blank
	// if your controller is not in a sub-folder within the "controllers" folder
	// $routing['directory'] = '';

	// The controller class file name.  Example:  Mycontroller
	// $routing['controller'] = '';

	// The controller function you wish to be called.
	// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  自定义配置变量
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * 取消注释 使用 $assign_to_config 数组这个特色
 *
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// 用户配置结束。 不要编辑下面这行。
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  解决系统路径提高稳定性
 * ---------------------------------------------------------------
 */

	// 正确的设置当前目录用于 CLI 请求
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}

	// 确保末尾有斜杠
	$system_path = rtrim($system_path, '/').'/';

	// 系统路径是否正确?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}

/*
 * -------------------------------------------------------------------
 *  现在我们知道路径，设置主路径常量
 * -------------------------------------------------------------------
 */
	// 这个文件的名称
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// PHP文件扩展名
	// 不建议使用全局常量
	define('EXT', '.php');

	// "system" 目录的路径
	define('BASEPATH', str_replace("\\", "/", $system_path));

	// Path to the front controller (this file)
	define('FCPATH', str_replace(SELF, '', __FILE__));

	// "system" 目录的名字
	define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

	// "application" 目录的路径
	if (is_dir($application_folder))
	{
		define('APPPATH', $application_folder.'/');
	}
	else
	{
		if ( ! is_dir(BASEPATH.$application_folder.'/'))
		{
			exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
		}

		define('APPPATH', BASEPATH.$application_folder.'/');
	}

/*
 * --------------------------------------------------------------------
 * 加载引导启动文件
 * --------------------------------------------------------------------
 *
 * 我们出发吧...
 *
 */
require_once BASEPATH.'core/Main.php';

/* End of file index.php */
/* Location: ./index.php */
