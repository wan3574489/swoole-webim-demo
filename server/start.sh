#!/bin/sh 

RootPath=$(cd `dirname $0`; pwd)

if [ -f $RootPath/rob.pid ]; then
    kill $(cat $RootPath/rob.pid)
    rm -r $RootPath/rob.pid
fi

if [ -f $RootPath/hsw_server.pid ]; then
    kill $(cat $RootPath/hsw_server.pid)
    rm -r $RootPath/hsw_server.pid
fi


echo 数据清理
php clean.php

echo 服务器开启
nohup php rob.php > $RootPath/rob.log &
nohup php hsw_server.php > $RootPath/hsw.log & 
