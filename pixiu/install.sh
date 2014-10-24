#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 声明变量
INSTALL_DIR="/opt/loong"

# 判断 /opt/loong 目录是否存在
if [ ! -d $INSTALL_DIR ];then
    mkdir -p $INSTALL_DIR
fi

# 创建发布相关目录
if [ ! -d "$INSTALL_DIR/bin" ];then
    mkdir -p $INSTALL_DIR/bin
fi
if [ ! -d "$INSTALL_DIR/etc" ];then
    mkdir -p $INSTALL_DIR/etc
fi
if [ ! -d "$INSTALL_DIR/log" ];then
    mkdir -p $INSTALL_DIR/log
fi
if [ ! -d "$INSTALL_DIR/log/pixiu" ];then
    mkdir -p $INSTALL_DIR/log/pixiu
fi
if [ ! -d "$INSTALL_DIR/var/run" ];then
    mkdir -p $INSTALL_DIR/var/run
fi
if [ ! -d "$INSTALL_DIR/pixiu" ];then
    mkdir -p $INSTALL_DIR/pixiu
    chown loong:loong $INSTALL_DIR/pixiu
fi

# 安装 nginx 执行文件到 bin目录并重命名为 pixiu
cp ./nginx-1.6.2/objs/nginx $INSTALL_DIR/bin/pixiu

# 安装 nginx 相关配置文件
cp ./nginx-1.6.2/conf/mime.types $INSTALL_DIR/etc/
cp ./nginx-1.6.2/conf/fastcgi.conf $INSTALL_DIR/etc/
cp ./nginx-1.6.2/conf/fastcgi_params $INSTALL_DIR/etc/
cp ./etc/pixiu.conf $INSTALL_DIR/etc/
chown -R loong:loong $INSTALL_DIR/etc/*

# 安装 nginx 页面文件
cp -r ./web/* $INSTALL_DIR/pixiu/
chown -R loong:loong $INSTALL_DIR/pixiu/*


