#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 声明变量
SITE_DIR="site"

# 修改 www/index.php 的参数
sed -i "/system_path/s/'system'/'\.\.\/system'/" $SITE_DIR/www/index.php
sed -i "/application_folder/s/'application'/'\.\.\/app'/" $SITE_DIR/www/index.php

# 修改 www/admin/index.php 的参数
sed -i "/system_path/s/'system'/'\.\.\/system'/" $SITE_DIR/www/admin/index.php
sed -i "/application_folder/s/'application'/'\.\.\/admin'/" $SITE_DIR/www/admin/index.php

# 删除不需要的文件

# 删除 system 目录中不需要的文件
rm site/system/index.html
rm site/system/core/index.html
rm site/system/database/index.html
rm site/system/database/drivers/index.html
rm site/system/database/drivers/cubrid/index.html
rm site/system/database/drivers/mssql/index.html
rm site/system/database/drivers/mysql/index.html
rm site/system/database/drivers/mysqli/index.html
rm site/system/database/drivers/oci8/index.html
rm site/system/database/drivers/odbc/index.html
rm site/system/database/drivers/pdo/index.html
rm site/system/database/drivers/postgre/index.html
rm site/system/database/drivers/sqlite/index.html
rm site/system/database/drivers/sqlsrv/index.html
rm site/system/fonts/index.html
rm site/system/fonts/texb.ttf
rm site/system/helpers/index.html
rm site/system/language/index.html
rm site/system/language/english/index.html
rm site/system/language/zh_CN/index.html
rm site/system/libraries/index.html
rm site/system/libraries/Cache/index.html
rm site/system/libraries/Cache/drivers/index.html
rm site/system/libraries/javascript/index.html

# 删除 app 目录中不需要的文件 
rm site/app/index.html
rm site/app/cache/index.html
rm site/app/config/index.html
rm site/app/controllers/index.html
rm site/app/core/index.html
rm site/app/errors/index.html
rm site/app/helpers/index.html
rm site/app/hooks/index.html
rm site/app/language/index.html
rm site/app/language/english/index.html
rm site/app/libraries/index.html
rm site/app/logs/index.html
rm site/app/models/index.html
rm site/app/third_party/index.html
rm site/app/views/index.html

# 删除 admin 目录中不需要的文件 
rm site/admin/index.html
rm site/admin/cache/index.html
rm site/admin/config/index.html
rm site/admin/controllers/index.html
rm site/admin/core/index.html
rm site/admin/errors/index.html
rm site/admin/helpers/index.html
rm site/admin/hooks/index.html
rm site/admin/language/index.html
rm site/admin/language/english/index.html
rm site/admin/libraries/index.html
rm site/admin/logs/index.html
rm site/admin/models/index.html
rm site/admin/third_party/index.html
rm site/admin/views/index.html


