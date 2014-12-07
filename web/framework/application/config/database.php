<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| 数据库连接设置
| -------------------------------------------------------------------
| 该文件将需要访问的数据库设置
|
| -------------------------------------------------------------------
| 变量解释
| -------------------------------------------------------------------
|
|	['hostname'] 数据库服务器的主机名
|	['username'] 用户名用于连接到数据库
|	['password'] 密码用来连接数据库
|	['database'] 要连接到的数据库的名称
|	['dbdriver'] 数据库类型 例如: mysql.  当前支持:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - 是否使用持久连接
|	['db_debug'] TRUE/FALSE - 是否要显示数据库错误
|	['cache_on'] TRUE/FALSE - 启用/禁用查询缓存
|	['cachedir'] 缓存文件应该存放的文件夹路径
|	['char_set'] 用于与数据库进行通信的字符集
|	['dbcollat'] 用于与数据库进行通信的特征排序
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] 默认的表前缀，应与dbprefix交换
|	['autoinit'] 是否要自动初始化数据库
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = '';
$db['default']['password'] = '';
$db['default']['database'] = '';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


/* 文件结束，禁止此行后或之下添加任何东西 */
