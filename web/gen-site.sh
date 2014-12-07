#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 声明变量
SITE_DIR="site"

# 判断 site 目录是否存在
if [ ! -d $SITE_DIR ];then
    mkdir $SITE_DIR
fi

# 判断 www 目录是否存在
if [ ! -d $SITE_DIR/www ];then
    mkdir $SITE_DIR/www
fi

# 判断 www/admin 目录是否存在
if [ ! -d $SITE_DIR/www/admin ];then
    mkdir -p $SITE_DIR/www/admin
fi

# 判断 system 目录是否存在
if [ ! -d $SITE_DIR/system ];then
    mkdir $SITE_DIR/system
fi

# 判断 app 目录是否存在
if [ ! -d $SITE_DIR/app ];then
    mkdir $SITE_DIR/app
fi

# 判断 admin 目录是否存在
if [ ! -d $SITE_DIR/admin ];then
    mkdir $SITE_DIR/admin
fi

# 复制 system 目录内容
cp -R CodeIgniter/system/* $SITE_DIR/system/

# 复制 app 目录内容
cp -R CodeIgniter/application/* $SITE_DIR/app

# 复制 admin 目录内容
cp -R CodeIgniter/application/* $SITE_DIR/admin

# 复制 index.php 入口文件到站点发布目录
cp CodeIgniter/index.php $SITE_DIR/www
cp CodeIgniter/index.php $SITE_DIR/www/admin


