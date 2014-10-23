#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

echo "starting pixiu release ..."

# 判断 ../release 目录是否存在
if [ ! -d "../release" ];then
    mkdir ../release/
fi

# 创建发布相关目录
if [ ! -d "../release/opt" ];then
    mkdir -p ../release/opt
    mkdir -p ../release/opt/loong
    mkdir -p ../release/opt/loong/bin
    mkdir -p ../release/opt/loong/etc
    mkdir -p ../release/opt/loong/log
    mkdir -p ../release/opt/loong/var
fi

if [ ! -d "../release/opt/loong/var" ];then
    mkdir -p ../release/opt/loong/var/pixiu
fi

if [ ! -d "../release/opt/loong/bet" ];then
    mkdir -p ../release/opt/loong/bet
fi

# 复制 nginx 执行文件到 bin目录并重命名为 pixiu
cp ./nginx-1.6.2/objs/nginx ../release/opt/loong/bin/pixiu

# 复制 nginx 相关配置文件
cp ./etc/pixiu.conf ../release/opt/loong/etc/

# 复制 nginx 页面文件
cp -r ./web/* ../release/opt/loong/bet/

