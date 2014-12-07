#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

echo "Install TaoTie Starting..."

# 声明变量
INSTALL_DIR="/opt/loong"

# 判断 /opt/loong 目录是否存在
if [ ! -d $INSTALL_DIR ];then
    mkdir -p $INSTALL_DIR
fi

# 创建项目的执行文件目录
if [ ! -d $INSTALL_DIR/bin ];then
    mkdir -p $INSTALL_DIR/bin
fi

# 创建项目的配置文件目录
if [ ! -d $INSTALL_DIR/etc ];then
    mkdir -p $INSTALL_DIR/etc
    chown loong:loong $INSTALL_DIR/etc
fi

# 创建项目的日志文件目录
if [ ! -d $INSTALL_DIR/log/taotie ];then
    mkdir -p $INSTALL_DIR/log/taotie
fi

# 创建项目的运行目录
if [ ! -d $INSTALL_DIR/var/run ];then
    mkdir -p $INSTALL_DIR/var/run
fi

# 创建项目的网站目录
if [ ! -d $RELEASE_DIR/opt/loong/web/www ];then
    mkdir -p $RELEASE_DIR/opt/loong/web/www
fi

# 安装 nginx 执行文件到 bin目录并重命名为 taotie
cp ./nginx-1.6.2/objs/nginx $INSTALL_DIR/bin/taotie

# 安装 nginx 相关配置文件
cp ./nginx-1.6.2/conf/mime.types $INSTALL_DIR/etc/
cp ./nginx-1.6.2/conf/fastcgi.conf $INSTALL_DIR/etc/
cp ./nginx-1.6.2/conf/fastcgi_params $INSTALL_DIR/etc/
cp ./etc/taotie.conf $INSTALL_DIR/etc/
cp -r ./etc/vhost/ $INSTALL_DIR/etc/
chown -R loong:loong $INSTALL_DIR/etc/*

# 安装 nginx 页面文件
cp -r ./html/* $INSTALL_DIR/web/www
chown -R loong:loong $INSTALL_DIR/web

echo "Install TaoTie End"


