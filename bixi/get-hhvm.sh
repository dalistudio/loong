#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 判断 hhvm 目录是否存在
if [ ! -d "hhvm" ];then
    # git 克隆 HHVM 项目的代码
    git clone git://github.com/facebook/hhvm.git
    cd hhvm
    git submodule update --init --recursive
    cd ..
fi
