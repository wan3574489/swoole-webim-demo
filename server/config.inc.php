<?php

//error_reporting(E_ALL ^ E_NOTICE);
define("STORAGE","redis"); //file 文件存储，mysql 数据库存储，redis 缓存存储
define("DOMAIN","http://chat.codeception.cn");
define('ONLINE_DIR','/home/www/chat/swoole-webim-demo/rooms/');

/*房间配置*/
for($i =1;$i<=255;$i++){
	$rooms[$i] = $i;
}

/*$rooms = array(
	'a' => '唐',
	'b' => '伯',
	'c' => '虎',
	'd' => '点',
	'e' => '秋',
	'f' => '香'
);*/

?>