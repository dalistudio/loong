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
if [ ! -d "$INSTALL_DIR/log/taotie" ];then
    mkdir -p $INSTALL_DIR/log/taotie
fi
if [ ! -d "$INSTALL_DIR/var" ];then
    mkdir -p $INSTALL_DIR/var/run
fi

# 安装 nginx 执行文件到 bin目录并重命名为 taotie
cp ./nginx-1.6.2/objs/nginx $INSTALL_DIR/bin/taotie

# 安装 nginx 相关配置文件
cp ./nginx-1.6.2/conf/mime.types $INSTALL_DIR/etc/
cp ./nginx-1.6.2/conf/fastcgi.conf $INSTALL_DIR/etc/
cp ./nginx-1.6.2/conf/fastcgi_params $INSTALL_DIR/etc/
cp ./etc/taotie.conf $INSTALL_DIR/etc/

# 安装 nginx 静态页面文件
cp -r ./html/* $INSTALL_DIR/web

# 安装 nginx 动态页面文件
cp -r ./php/* $INSTALL_DIR/php

