#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 获得 Memcached 源代码
./get-memc.sh

# 编辑 Memcached 源代码
./edit-memc.sh

# 编译 Memcached 源代码
./compile.sh

# 发布 Memcached
./release.sh

