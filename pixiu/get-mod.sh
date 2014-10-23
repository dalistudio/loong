#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

##### 
if [ ! -d "../down" ];then
    mkdir ../down
fi

if [ ! -d "./mod" ];then
    mkdir ./mod
fi

##### ngx_devel_kit
if [ ! -f "../down/ndk-0.2.19.tar.gz" ];then
    wget https://github.com/simpl/ngx_devel_kit/archive/v0.2.19.tar.gz -O ../down/ndk-0.2.19.tar.gz
fi
if [ ! -d "./mod/ndk" ];then
    tar -zxvf ../down/ndk-0.2.19.tar.gz -C ./mod
    mv ./mod/ngx_devel_kit-0.2.19 ./mod/ndk
fi

##### array-var-nginx-module
if [ ! -f "../down/array-0.03.tar.gz" ];then
    wget https://github.com/openresty/array-var-nginx-module/archive/v0.03.tar.gz -O ../down/array-0.03.tar.gz
fi
if [ ! -d "./mod/array" ];then
    tar -zxvf ../down/array-0.03.tar.gz -C ./mod
    mv ./mod/array-var-nginx-module-0.03 ./mod/array
fi

##### echo-nginx-module
if [ ! -f "../down/echo-0.56.tar.gz" ];then
    wget https://github.com/openresty/echo-nginx-module/archive/v0.56.tar.gz -O ../down/echo-0.56.tar.gz
fi
if [ ! -d "./mod/echo" ];then
    tar -zxvf ../down/echo-0.56.tar.gz -C ./mod
    mv ./mod/echo-nginx-module-0.56 ./mod/echo
fi

##### headers-more-nginx-module
if [ ! -f "../down/headers-0.25.tar.gz" ];then
    wget https://github.com/openresty/headers-more-nginx-module/archive/v0.25.tar.gz -O ../down/headers-0.25.tar.gz
fi
if [ ! -d "./mod/headers" ];then
    tar -zxvf ../down/headers-0.25.tar.gz -C ./mod
    mv ./mod/headers-more-nginx-module-0.25 ./mod/headers
fi

##### memc-nginx-module
if [ ! -f "../down/memc-0.15.tar.gz" ];then
    wget https://github.com/openresty/memc-nginx-module/archive/v0.15.tar.gz -O ../down/memc-0.15.tar.gz
fi
if [ ! -d "./mod/memc" ];then
    tar -zxvf ../down/memc-0.15.tar.gz -C ./mod
    mv ./mod/memc-nginx-module-0.15 ./mod/memc
fi

##### set-misc-nginx-module
if [ ! -f "../down/misc-0.26.tar.gz" ];then
    wget https://github.com/openresty/set-misc-nginx-module/archive/v0.26.tar.gz -O ../down/misc-0.26.tar.gz
fi
if [ ! -d "./mod/misc" ];then
    tar -zxvf ../down/misc-0.26.tar.gz -C ./mod
    mv ./mod/set-misc-nginx-module-0.26 ./mod/misc
fi

##### srcache-nginx-module
if [ ! -f "../down/srcache-0.28.tar.gz" ];then
    wget https://github.com/openresty/srcache-nginx-module/archive/v0.28.tar.gz -O ../down/srcache-0.28.tar.gz
fi
if [ ! -d "./mod/srcache" ];then
    tar -zxvf ../down/srcache-0.28.tar.gz -C ./mod
    mv ./mod/srcache-nginx-module-0.28 ./mod/srcache
fi

##### form-input-nginx-module
if [ ! -f "../down/form-0.10.tar.gz" ];then
    wget https://github.com/calio/form-input-nginx-module/archive/v0.10.tar.gz -O ../down/form-0.10.tar.gz
fi
if [ ! -d "./mod/form" ];then
    tar -zxvf ../down/form-0.10.tar.gz -C ./mod
    mv ./mod/form-input-nginx-module-0.10 ./mod/form
fi

##### ngx_coolkit
if [ ! -f "../down/nck-0.2rc1.tar.gz" ];then
    wget https://github.com/FRiCKLE/ngx_coolkit/archive/0.2rc1.tar.gz -O ../down/nck-0.2rc1.tar.gz
fi
if [ ! -d "./mod/nck" ];then
    tar -zxvf ../down/nck-0.2rc1.tar.gz -C ./mod
    mv ./mod/ngx_coolkit-0.2rc1 ./mod/nck
fi

##### lua-nginx-module
if [ ! -f "../down/lua-0.9.12.tar.gz" ];then
    wget https://github.com/openresty/lua-nginx-module/archive/v0.9.12.tar.gz -O ../down/lua-0.9.12.tar.gz
fi
if [ ! -d "./mod/lua" ];then
    tar -zxvf ../down/lua-0.9.12.tar.gz -C ./mod
    mv ./mod/lua-nginx-module-0.9.12 ./mod/lua
fi

##### luajit
if [ ! -f "../down/LuaJIT-2.0.3.tar.gz" ];then
    wget http://luajit.org/download/LuaJIT-2.0.3.tar.gz -O ../down/LuaJIT-2.0.3.tar.gz
fi
if [ ! -d "./mod/luajit" ];then
    tar -zxvf ../down/LuaJIT-2.0.3.tar.gz -C ./mod
    mv ./mod/LuaJIT-2.0.3 ./mod/luajit
fi



