#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

echo "starting taotie install ..."

# 判断 /opt/loong 目录是否存在
if [ ! -d "/opt/loong" ];then
    mkdir -p /opt/loong
fi

# 创建发布相关目录
if [ ! -d "/opt/loong/bin" ];then
    mkdir -p /opt/loong/bin
fi
if [ ! -d "/opt/loong/etc" ];then
    mkdir -p /opt/loong/etc
fi
if [ ! -d "/opt/loong/log" ];then
    mkdir -p /opt/loong/log
fi
if [ ! -d "/opt/loong/var" ];then
    mkdir -p /opt/loong/var
fi

# 安装 nginx 执行文件到 bin目录并重命名为 taotie
cp ./nginx-1.6.2/objs/nginx /opt/loong/bin/taotie

# 安装 nginx 相关配置文件
cp ./nginx-1.6.2/conf/mime.types /opt/loong/etc/
cp ./nginx-1.6.2/conf/fastcgi.conf /opt/loong/etc/
cp ./nginx-1.6.2/conf/fastcgi_params /opt/loong/etc/
cp ./etc/taotie.conf /opt/loong/etc/

# 安装 nginx 页面文件
cp -r ./web/ /opt/loong/web/
