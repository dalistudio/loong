#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

echo "Release BiXi Starting..."

# 声明变量
RELEASE_DIR="../release"

# 判断 hhvm 执行程序是否存在
if [ -f "./hhvm/hphp/hhvm/hhvm" ];then
    cp ./hhvm/hphp/hhvm/hhvm $RELEASE_DIR/opt/loong/bin/bixi
fi

cp ./etc/bixi.ini $RELEASE_DIR/opt/loong/etc/

## 创建项目的网站目录
#if [ ! -d $RELEASE_DIR/opt/loong/web/bixi ];then
#    mkdir -p $RELEASE_DIR/opt/loong/web/bixi
#    chown -R loong:loong $RELEASE_DIR/opt/loong/web
#fi

# 复制 bixi 动态页面文件到 taotie 目录
cp -r ./web/* $RELEASE_DIR/opt/loong/web/taotie
chown -R loong:loong $RELEASE_DIR/opt/loong/web/taotie/*

echo "Release BiXi End"
