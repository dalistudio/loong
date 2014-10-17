#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 判断 hhvm 执行程序是否存在
if [ -f "./hhvm/hphp/hhvm/hhvm" ];then
    cp ./hhvm/hphp/hhvm/hhvm ../release/opt/loong/bin/bixi
fi
