#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

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
--with-http_sub_module \
--with-http_gunzip_module \
--with-http_gzip_static_module \
--user=loong \
--group=loong \
--prefix=/opt/loong \
--conf-path=etc/taotie.conf \
--error-log-path=log/taotie/error.log \
--http-log-path=log/taotie/access.log \
--pid-path=var/run/taotie.pid \
--http-client-body-temp-path=/tmp/client_body_temp \
--http-proxy-temp-path=/tmp/proxy_temp \
--http-fastcgi-temp-path=/tmp/fastcgi_temp \
--http-uwsgi-temp-path=/tmp/uwsgi_temp \
--http-scgi-temp-path=/tmp/scgi_temp \
--add-module=../mod/ndk \
--add-module=../mod/memc \
--add-module=../mod/headers \
--add-module=../mod/echo \
--add-module=../mod/srcache \
--add-module=../mod/misc


# 目前不需要启用 SSL 模块
#--with-http_ssl_module \

# 编译 Nginx
make
cd ..

