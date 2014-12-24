#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 删除临时文件
./del_temp.sh

# 生成饕餮
cd taotie
./autogen.sh
cd ..

# 生成赑屃
#cd bixi
#./autogen.sh
#cd ..

# 生成狻猊
cd suanni
./autogen.sh
cd ..

# 生成椒图
cd jiaotu
./autogen.sh
cd ..

# 生成貔貅
cd pixiu
./autogen.sh
cd ..

# 生成螭首
cd chishou
./autogen.sh
cd ..

# 生成鸱吻
#cd chiwen
#./autogen.sh
#cd ..

# 生成网站
cd web 
./autogen.sh
cd ..


