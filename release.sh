#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 发布 TaoTie 
cd taotie
./release.sh
cd ..

# 发布 BiXi
cd bixi
./release.sh
cd ..

# 发布 SuanNi
cd suanni
./release.sh
cd ..

# 发布 JiaoTu
cd jiaotu
./release.sh
cd ..

####################

# 发布 PiXiu
cd pixiu
./release.sh
cd ..

# 发布 ChiShou
cd chishou
./release.sh
cd ..

####################

# 发布 MySQL
cd chiwen
./release.sh
cd ..

