# 在线聊天室(Making a Web Chat With PHP and Swoole)

------

使用swoole扩展和php开发的一个在线聊天室，**目前实现的功能有** ：


# 如何运行？

1.先将client目录放置在您的web服务器下，打开client/static/js/init.js 文件，将该文件的配置修改成自己的域名或者IP

2.打开server目录，首先将rooms目录以及其子目录权限设为777，确保该目录可写。将client/uploads目录设置为777可写。

3.修改server/config.inc.php 文件。将下面一行代码修改为您的域名或者IP。

> define("DOMAIN","http://192.168.56.133:8081");

并且将下面这样修改为rooms目录所在的路径

> define('ONLINE_DIR','/mnt/hgfs/swoole/chatroom/rooms/');

4.命令行执行 ：
> /usr/local/php/bin/php /path/server/hsw_server.php 

# 资料说明
swoole官网 http://www.swoole.com

网站目录说明:

client 网站访问目录
service 服务端目录
  --> hsw_server.php websocket目录
  --> rob.php 机器人自动领取目录
  --> create.php 系统第一次运行的时候，需要运行一次它会自动生成一个红包。

