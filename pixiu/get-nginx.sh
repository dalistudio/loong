#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 判断下载目录是否存在
if [ ! -d "../down" ];then
    # 创建目录
    mkdir ../down
fi

# 判断 nginx-1.6.2.tar.gz 文件是否存在
if [ ! -f "../down/nginx-1.6.2.tar.gz" ];then
    # 下载 Nginx 1.6.2 稳定版本 
    wget http://nginx.org/download/nginx-1.6.2.tar.gz -O ../down/nginx-1.6.2.tar.gz
fi

# 判断 nginx-1.6.2 目录是否存在
if [ ! -d "nginx-1.6.2" ]; then
    # 解压 tar.gz 文件
    tar -zxvf ../down/nginx-1.6.2.tar.gz
fi
