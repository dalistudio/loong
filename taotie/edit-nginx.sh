#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 修改版本信息
sed -i '/#define nginx_version/s/1006002/2000000/' ./nginx-1.6.2/src/core/nginx.h 
sed -i '/#define NGINX_VERSION/s/1.6.2/2.0.0/' ./nginx-1.6.2/src/core/nginx.h 
sed -i '/#define NGINX_VER/s/nginx/taotie/' ./nginx-1.6.2/src/core/nginx.h 
sed -i '/#define NGINX_VAR/s/"NGINX"/"TAOTIE"/' ./nginx-1.6.2/src/core/nginx.h 

sed -i '/nginx version:/s/nginx/taotie/' ./nginx-1.6.2/src/core/nginx.c
sed -i '/Usage: nginx/s/nginx/taotie/' ./nginx-1.6.2/src/core/nginx.c

# 修改进程信息
sed -i '/nginx:/s/nginx/taotie/' ./nginx-1.6.2/src/os/unix/ngx_setproctitle.c

# 修改禁止部分命令行参数
sed -i '/ngx_show_help = 1;/s/1/0/' ./nginx-1.6.2/src/core/nginx.c
sed -i '/ngx_show_configure = 1;/s/1/0/' ./nginx-1.6.2/src/core/nginx.c

