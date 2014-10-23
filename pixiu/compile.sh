#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 编译 LuaJIT
cd mod/luajit
make
sudo make install
cd ../..

# 注意 LuaJIT 路径要正确
export LUAJIT_LIB=/usr/local/lib
export LUAJIT_INC=/usr/local/include/luajit-2.0


# 生成 Makefile 文件
cd nginx-1.6.2
./configure \
--without-select_module \
--without-poll_module \
--without-http_ssi_module \
--without-http_auth_basic_module \
--without-http_autoindex_module \
--without-http_geo_module \
--without-http_split_clients_module \
--without-http_uwsgi_module \
--without-http_scgi_module \
--without-http_memcached_module \
--with-http_realip_module \
--user=loong \
--group=loong \
--prefix=/opt/loong \
--conf-path=etc/pixiu.conf \
--error-log-path=log/pixiu/error.log \
--http-log-path=log/pixiu/access.log \
--pid-path=var/run/pixiu.pid \
--http-client-body-temp-path=/tmp/client_body_temp \
--http-proxy-temp-path=/tmp/proxy_temp \
--http-fastcgi-temp-path=/tmp/fastcgi_temp \
--http-uwsgi-temp-path=/tmp/uwsgi_temp \
--http-scgi-temp-path=/tmp/scgi_temp \
--add-module=../mod/ndk \
--add-module=../mod/echo \
--add-module=../mod/headers \
--add-module=../mod/array \
--add-module=../mod/misc \
--add-module=../mod/lua \


# 编译 Nginx
make
cd ..

