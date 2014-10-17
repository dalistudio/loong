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
    mkdir ../release/opt
    mkdir ../release/opt/loong
    mkdir ../release/opt/loong/bin
    mkdir ../release/opt/loong/etc
    mkdir ../release/opt/loong/log
    mkdir ../release/opt/loong/var
fi

# 复制 nginx 执行文件到 bin目录并重命名为 pixiu
cp ./nginx-1.6.2/objs/nginx ../release/opt/loong/bin/pixiu

# 复制 nginx 相关配置文件
cp ./nginx-1.6.2/conf/mime.types ../release/opt/loong/etc/
cp ./nginx-1.6.2/conf/fastcgi.conf ../release/opt/loong/etc/
cp ./nginx-1.6.2/conf/fastcgi_params ../release/opt/loong/etc/
cp ./etc/taotie.conf ../release/opt/loong/etc/

# 复制 nginx 页面文件
cp -r ./web/ ../release/opt/loong/web/

