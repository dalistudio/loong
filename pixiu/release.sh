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
if [ ! -d "$RELEASE_DIR/opt/loong/bin" ];then
    mkdir -p $RELEASE_DIR/opt/loong/bin
fi
if [ ! -d "$RELEASE_DIR/opt/loong/etc" ];then
    mkdir -p $RELEASE_DIR/opt/loong/etc
fi
if [ ! -d "$RELEASE_DIR/opt/loong/log" ];then
    mkdir -p $RELEASE_DIR/opt/loong/log
fi
if [ ! -d "$RELEASE_DIR/opt/loong/log/pixiu" ];then
    mkdir -p $RELEASE_DIR/opt/loong/log/pixiu
fi
if [ ! -d "$RELEASE_DIR/opt/loong/var/run" ];then
    mkdir -p $RELEASE_DIR/opt/loong/var/run
fi
if [ ! -d "$RELEASE_DIR/opt/loong/pixiu" ];then
    mkdir -p $RELEASE_DIR/opt/loong/pixiu
    chown loong:loong $RELEASE_DIR/opt/loong/pixiu
fi

# 复制 nginx 执行文件到 bin目录并重命名为 pixiu
cp ./nginx-1.6.2/objs/nginx $RELEASE_DIR/opt/loong/bin/pixiu

# 复制 nginx 相关配置文件
cp ./etc/pixiu.conf $RELEASE_DIR/opt/loong/etc/
chown -R loong:loong $RELEASE_DIR/opt/loong/etc/*

# 复制 nginx 页面文件
cp -r ./web/* $RELEASE_DIR/opt/loong/pixiu/
chown -R loong:loong $RELEASE_DIR/opt/loong/pixiu/*

