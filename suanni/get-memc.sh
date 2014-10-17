#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 判断 memcached 压缩文件是否存在
if [ ! -f "../down/memcached-1.4.20.tar.gz" ];then
    wget http://www.memcached.org/files/memcached-1.4.20.tar.gz -O ../down/memcached-1.4.20.tar.gz
fi

# 判断 memcached 目录是否存在
if [ ! -d "memcached-1.4.20" ];then
    tar -zxvf ../down/memcached-1.4.20.tar.gz
fi
