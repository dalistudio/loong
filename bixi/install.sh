#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 判断 hhvm 执行程序是否存在
if [ -f "./hhvm/hphp/hhvm/hhvm" ];then
    cp ./hhvm/hphp/hhvm/hhvm /opt/loong/bin/bixi
fi

cp ./etc/bixi.ini /opt/loong/etc/

# 复制 bixi 动态页面文件
cp -r ./web/* /opt/loong/bixi
chown -R loong:loong /opt/loong/bixi/*
