#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

if [ ! -f "./hhvm/hphp/hhvm/hhvm" ];then
    # 生成 Makefile 并编译
    cd hhvm
    cmake .
    make -j 2
    cd ..
fi

