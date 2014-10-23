#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 判断 memcached 目录是否存在
if [ -d "memcached-1.4.20" ];then
    ./clean.sh
    ./get-memc.sh
fi

# 修改产品名称
sed -i '/AC_INIT/s/memcached/chishou/' ./memcached-1.4.20/configure.ac
sed -i '/memcached@googlegroups.com/s/memcached/chishou/' ./memcached-1.4.20/configure.ac

# 修改版本号 
sed -i '/VERSION_NUMBER/s/1.4.20/2.0.0/' ./memcached-1.4.20/version.m4

# 生成 configure
cd memcached-1.4.20
autoscan
aclocal
autoconf
cd ..

# 修改默认设置
sed -i '/settings.port = 11211;/s/11211/7000/' ./memcached-1.4.20/memcached.c
sed -i '/settings.udpport = 11211;/s/11211/7000/' ./memcached-1.4.20/memcached.c
## 需要转意 * 符号，使用 \* 表示 *
sed -i '/settings.maxbytes = 64 \* 1024 \* 1024;/s/64/256/' ./memcached-1.4.20/memcached.c

# 禁止部分命令行参数
#sed -i '/usage();/s/usage();/\/\/usage();/' ./memcached-1.4.20/memcached.c
#sed -i '/usage_license();/s/usage_license();/\/\/usage_license();/' ./memcached-1.4.20/memcached.c

# 屏蔽代码
sed -i '/printf("-p <num>/s/printf/\/\*printf/' ./memcached-1.4.20/memcached.c
sed -i '/static void usage_license(void)/s/static/\*\/}\n\nstatic/' ./memcached-1.4.20/memcached.c

sed -i '/static void usage_license(void) {/s/{/{\nprintf(PACKAGE " " VERSION "\\n\\n");\n\/\*/' ./memcached-1.4.20/memcached.c
sed -i '/static void save_pid(const char \*pid_file)/s/static/\*\/}\n\nstatic/' ./memcached-1.4.20/memcached.c
