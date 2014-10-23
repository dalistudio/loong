#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 修改 memc 模块的 ngx_http_memc_module.h
# ngx_http_memc_ctx_t 的 off_t rest;
#sed -i '/size_t                     rest;/s/size_t/off_t/' ./mod/memc/src/ngx_http_memc_module.h
