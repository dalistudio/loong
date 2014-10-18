#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 安装 TaoTie 
cd taotie
./install.sh
cd ..

# 安装 BiXi
cd bixi
./install.sh
cd ..

# 安装 SuanNi
cd suanni
./install.sh
cd ..

# 安装 JiaoTu
cd jiaotu
./install.sh
cd ..

####################

# 安装 PiXiu
cd pixiu
./install.sh
cd ..

# 安装 ChiShou
cd chishou
./install.sh
cd ..

####################

# 安装 MySQL
cd chiwen
./install.sh
cd ..

