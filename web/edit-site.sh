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



