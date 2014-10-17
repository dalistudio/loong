#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 下载和修改 nginx
./get-nginx.sh
./edit-nginx.sh

# 下载和修改 nginx 模块
./get-mod.sh
./edit-mod.sh

# 编译和发行 nginx
./compile.sh
./release.sh
