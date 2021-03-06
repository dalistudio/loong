#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

echo "Release TaoTie Starting..."

# 声明变量
RELEASE_DIR="../release"

# 判断 ../release 目录是否存在
if [ ! -d $RELEASE_DIR ];then
    mkdir $RELEASE_DIR
fi

# 创建发布相关目录
if [ ! -d $RELEASE_DIR/opt ];then
    mkdir -p $RELEASE_DIR/opt  
fi

# 创建Loong项目的目录
if [ ! -d $RELEASE_DIR/opt/loong ];then
    mkdir -p $RELEASE_DIR/opt/loong
fi

# 创建项目的执行文件目录
if [ ! -d $RELEASE_DIR/opt/loong/bin ];then
    mkdir -p $RELEASE_DIR/opt/loong/bin
fi

# 创建项目的配置文件目录
if [ ! -d $RELEASE_DIR/opt/loong/etc ];then
    mkdir -p $RELEASE_DIR/opt/loong/etc
    chown loong:loong $RELEASE_DIR/opt/loong/etc
fi

# 创建项目的日志文件目录
if [ ! -d $RELEASE_DIR/opt/loong/log/taotie ];then
    mkdir -p $RELEASE_DIR/opt/loong/log/taotie
fi

# 创建项目的运行目录
if [ ! -d $RELEASE_DIR/opt/loong/var/run ];then
    mkdir -p $RELEASE_DIR/opt/loong/var/run
fi

# 创建项目的网站目录
if [ ! -d $RELEASE_DIR/opt/loong/web/www ];then
    mkdir -p $RELEASE_DIR/opt/loong/web/www
fi

# 创建测试的网站目录
if [ ! -d $RELEASE_DIR/opt/loong/web/test ];then
    mkdir -p $RELEASE_DIR/opt/loong/web/test
fi

# 复制 nginx 执行文件到 bin目录并重命名为 taotie
cp ./nginx-1.6.2/objs/nginx $RELEASE_DIR/opt/loong/bin/taotie

# 复制 nginx 相关配置文件
cp ./nginx-1.6.2/conf/mime.types $RELEASE_DIR/opt/loong/etc/
cp ./nginx-1.6.2/conf/fastcgi.conf $RELEASE_DIR/opt/loong/etc/
cp ./nginx-1.6.2/conf/fastcgi_params $RELEASE_DIR/opt/loong/etc/
cp ./etc/taotie.conf $RELEASE_DIR/opt/loong/etc/
cp -r ./etc/vhost/ $RELEASE_DIR/opt/loong/etc/
chown -R loong:loong $RELEASE_DIR/opt/loong/etc/*

# 复制 nginx 页面文件
cp -r ./web/* $RELEASE_DIR/opt/loong/web/www/
cp -r ./web/* $RELEASE_DIR/opt/loong/web/test/
chown -R loong:loong $RELEASE_DIR/opt/loong/web/

echo "Release TaoTie End"


