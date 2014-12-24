#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 打包 deb 安装文件
# Debian软件包命名遵循下列约定: <软件包名称>_<版本>-<Debian修订号>_<平台>.deb
# <平台> 32位为 i386 / 64位为 amd64
dpkg -b release loong-server_2.0.0_amd64.deb

