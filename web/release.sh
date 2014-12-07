#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 判断 web 目录是否存在
if [ ! -d "../release/opt/loong/web" ];then
    mkdir -p "../release/opt/loong/web"
fi

# 复制网站内容到发布目录
cp -r site/* ../release/opt/loong/web/

