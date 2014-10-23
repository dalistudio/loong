#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 声明变量
RELEASE_DIR="../release"

# 判断 ../release 目录是否存在
if [ ! -d $RELEASE_DIR ];then
    mkdir $RELEASE_DIR
fi

# 创建发布相关目录
if [ ! -d $RELEASE_DIR/opt ];then
    mkdir -p $RELEASE_DIR/opt
    mkdir -p $RELEASE_DIR/opt/loong
    mkdir -p $RELEASE_DIR/opt/loong/bin
    mkdir -p $RELEASE_DIR/opt/loong/etc
    mkdir -p $RELEASE_DIR/opt/loong/log/taotie
    mkdir -p $RELEASE_DIR/opt/loong/var/run
    mkdir -p $RELEASE_DIR/opt/loong/web/html
    mkdir -p $RELEASE_DIR/opt/loong/web/php
fi

# 复制 nginx 执行文件到 bin目录并重命名为 taotie
cp ./nginx-1.6.2/objs/nginx $RELEASE_DIR/opt/loong/bin/taotie

# 复制 nginx 相关配置文件
cp ./nginx-1.6.2/conf/mime.types $RELEASE_DIR/opt/loong/etc/
cp ./nginx-1.6.2/conf/fastcgi.conf $RELEASE_DIR/opt/loong/etc/
cp ./nginx-1.6.2/conf/fastcgi_params $RELEASE_DIR/opt/loong/etc/
cp ./etc/taotie.conf $RELEASE_DIR/opt/loong/etc/

# 复制 nginx 静态页面文件
cp -r ./html/* $RELEASE_DIR/opt/loong/web/html

# 复制 nginx 动态页面文件
cp -r ./php/* $RELEASE_DIR/opt/loong/web/php

