#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

echo "starting bixi release ..."

# 判断 hhvm 执行程序是否存在
if [ -f "./hhvm/hphp/hhvm/hhvm" ];then
    cp ./hhvm/hphp/hhvm/hhvm ../release/opt/loong/bin/bixi
fi

cp ./etc/bixi.ini ../release/opt/loong/etc/

# 复制 bixi 动态页面文件
cp -r ./web/* ../release/opt/loong/bixi
chown -R loong:loong ../release/opt/loong/bixi/*
