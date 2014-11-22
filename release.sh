#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

echo "Starting Release Loong Server"
# 发布 TaoTie 
echo "Taotie Release"
cd taotie
./release.sh
cd ..

# 发布 BiXi
echo "BiXi Release"
cd bixi
./release.sh
cd ..

# 发布 SuanNi
echo "SuanNi Release"
cd suanni
./release.sh
cd ..

# 发布 JiaoTu
echo "JiaoTu Release"
cd jiaotu
./release.sh
cd ..

####################

# 发布 PiXiu
echo "PiXiu Release"
cd pixiu
./release.sh
cd ..

# 发布 ChiShou
echo "ChiShou Release"
cd chishou
./release.sh
cd ..

####################

# 发布 MySQL
echo "ChiWen Release"
cd chiwen
./release.sh
cd ..

####################

# 复制 DEBIAN 目录的文件到 release 目录
echo "DEBIAN Release"
cd ./DEBIAN/
rm *~
cd ..
mkdir -p ./release/DEBIAN/
cp ./DEBIAN/* ./release/DEBIAN/

# 复制 init.d 目录的文件到 release 目录
echo "init.d Release"
cd ./init.d/
rm *~
cd ..
mkdir -p ./release/etc/init.d
cp ./init.d/* ./release/etc/init.d

# 复制 3rd/usr 目录到 release 目录
echo "3rd Release"
mkdir -p ./release/usr/
cp -r ./3rd/usr/* ./release/usr/

