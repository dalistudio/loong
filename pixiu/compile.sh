#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 生成 Makefile 文件
cd nginx-1.6.2
./configure \
--without-http_autoindex_module \
--without-http_uwsgi_module \
--without-http_scgi_module \
--with-http_realip_module \
--with-http_sub_module \
--with-http_gunzip_module \
--with-http_gzip_static_module \
--with-http_auth_request_module \
--user=loong \
--group=loong \
--prefix=/opt/loong \
--conf-path=etc/pixiu.conf \
--error-log-path=log/error.log \
--http-log-path=log/access.log \
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
--add-module=../mod/nck \
--add-module=../mod/srcache \
--add-module=../mod/form

# 编译 Nginx
make
cd ..

