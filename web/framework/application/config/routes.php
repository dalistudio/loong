<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI 路由
| -------------------------------------------------------------------------
| 这个文件让你能重新映射 URI 请求到指定的控制器函数。
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| 默认路由
| -------------------------------------------------------------------------
|
| 有两个默认的路由：
|
|	$route['default_controller'] = 'welcome';
|
| 这个路由用于表示 URI 内容为空，将自动加载"welcome"控制器类。
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome"; // 默认控制器
$route['404_override'] = '';


/* 文件结束，禁止此行后或之下添加任何东西 */
