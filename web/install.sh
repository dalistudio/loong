#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 判断 web 目录是否存在
if [ ! -d "/opt/loong/web" ];then
    mkdir -p "/opt/loong/web"
fi

# 复制网站内容到发布目录
cp -r site/* /opt/loong/web/

