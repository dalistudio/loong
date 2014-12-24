#!/bin/sh
# Copyright (c) 2014, wangdali <wangdali@qq.com>
#

# 安装 TaoTie 静态页面及反向代理服务器
cd taotie
./install.sh
cd ..

# 安装 BiXi 脚本引擎服务器
cd bixi
./install.sh
cd ..

# 安装 SuanNi 静态页面缓冲服务器
cd suanni
./install.sh
cd ..

# 安装 JiaoTu 会话信息管理服务器
cd jiaotu
./install.sh
cd ..

####################

# 安装 Web 网站
cd web
./install.sh
cd ..

####################

# 安装 PiXiu 应用服务器
cd pixiu
./install.sh
cd ..

# 安装 ChiShou 投注信息管理服务器
cd chishou
./install.sh
cd ..

####################

# 安装 MySQL 数据库服务器
#cd chiwen
#./install.sh
#cd ..

####################

# 安装守护脚本
cp ./init.d/* /etc/init.d/

# 饕餮
if [ -x "/etc/init.d/taotie" ]; then
	chmod +x /etc/init.d/taotie
	update-rc.d taotie defaults >/dev/null
fi

# 狻猊
if [ -x "/etc/init.d/suanni" ]; then
	chmod +x /etc/init.d/suanni
	update-rc.d suanni defaults >/dev/null
fi

# 椒图
if [ -x "/etc/init.d/jiaotu" ]; then
	chmod +x /etc/init.d/jiaotu
	update-rc.d jiaotu defaults >/dev/null
fi

# 赑屃
if [ -x "/etc/init.d/bixi" ]; then
	chmod +x /etc/init.d/bixi
	update-rc.d bixi defaults >/dev/null
fi

# 貔貅
if [ -x "/etc/init.d/pixiu" ]; then
	chmod +x /etc/init.d/pixiu
	update-rc.d pixiu defaults >/dev/null
fi

# 螭首
if [ -x "/etc/init.d/chishou" ]; then
	chmod +x /etc/init.d/chishou
	update-rc.d chishou defaults >/dev/null
fi

# 数据库
#if [ -x "/etc/init.d/mysql" ]; then
#	chmod +x /etc/init.d/mysql
#	update-rc.d mysql defaults >/dev/null
#fi
