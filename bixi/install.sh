#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

echo "Install BiXi starting..."

# 声明变量
INSTALL_DIR="/opt/loong"

# 判断 hhvm 执行程序是否存在
if [ -f "./hhvm/hphp/hhvm/hhvm" ];then
    cp ./hhvm/hphp/hhvm/hhvm $INSTALL_DIR/bin/bixi
fi

cp ./etc/bixi.ini $INSTALL_DIR/etc/

# 复制 bixi 动态页面文件
cp -r ./web/* $INSTALL_DIR/web/www
chown -R loong:loong $INSTALL_DIR/web/www/*

echo "Install BiXi End"
