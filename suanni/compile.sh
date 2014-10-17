#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 生成 Makefile 文件
cd memcached-1.4.20
./configure \
--prefix=/opt/loong

# 编译
make
cd ..

