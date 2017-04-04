<?php


require_once "config.inc.php";
require_once "emotion.config.php";
require_once "functions.php";
require_once "classes/module/connect.class.php";
require_once "classes/module/message.class.php";
require_once "classes/module/event.class.php";
require_once "classes/module/packet.class.php";
require_once "classes/".STORAGE."/ChatBase.class.php";
require_once "classes/".STORAGE."/File.class.php";
require_once "classes/".STORAGE."/ChatUser.class.php";
require_once "classes/".STORAGE."/ChatLine.class.php";
require_once "classes/Chat.class.php";
require_once "classes/hsw.class.php";
require_once "classes/cron.function.php";

for($i = 1;$i<=100;$i++){
    $roomid = $i;

    $create_timer = 10000;
    \swoole_timer_after($create_timer,function() use($roomid){
        createPacket($roomid);
    });

    $rob_timer    = 2000;
    \swoole_timer_after($rob_timer,function() use ($roomid){
        robPacket($roomid);
    });

    echo "room".$i."新建成功.\n";
    usleep(100);
}
