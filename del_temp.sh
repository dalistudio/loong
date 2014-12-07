#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 查找 . 目录下的所有 *~ 文件，并执行 rm 删除他们
find . -name "*~" -print -exec rm {} \;
