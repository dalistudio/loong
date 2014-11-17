#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 复制 DEBIAN 目录的文件到 release 目录
cd ./DEBIAN/
rm *~
cd ..
mkdir -p ./release/DEBIAN/
cp ./DEBIAN/* ./release/DEBIAN/

# 复制 init.d 目录的文件到 release 目录
cd ./init.d/
rm *~
cd ..
mkdir -p ./release/etc/init.d
cp ./init.d/* ./release/etc/init.d

# 复制 3rd/usr 目录到 release 目录
mkdir -p ./release/usr/
cp -r ./3rd/usr/* ./release/usr/

# 打包 deb 安装文件
dpkg -b release loong-2.0.0.deb

