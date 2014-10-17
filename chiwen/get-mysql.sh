#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

if [ ! -f "../down/mysql-5.6.21.tar.gz" ];then
    # 下载 mysql
    wget http://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.21.tar.gz -O ../down/mysql-5.6.21.tar.gz
fi

if [ ! -d "mysql-5.6.21" ];then
    tar -zxvf ../down/mysql-5.6.21.tar.gz
fi
