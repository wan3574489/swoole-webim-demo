<?php

require_once "../config.inc.php";
require_once "../emotion.config.php";
require_once "../functions.php";
require_once "../classes/module/connect.class.php";
require_once "../classes/module/message.class.php";
require_once "../classes/module/event.class.php";
require_once "../classes/module/packet.class.php";
require_once "../classes/".STORAGE."/ChatBase.class.php";
require_once "../classes/".STORAGE."/File.class.php";
require_once "../classes/".STORAGE."/ChatUser.class.php";
require_once "../classes/".STORAGE."/ChatLine.class.php";
require_once "../classes/Chat.class.php";
require_once "../classes/hsw.class.php";
require_once "../classes/cron.function.php";


$roomid = 11;
//
connect::query(" delete from jnp_fortune_event where roomid = $roomid ");
connect::query("  delete from jnp_fortune_packet_info where roomid = $roomid   ");
connect::query("delete from jnp_fortune_packet where roomid = $roomid  ");

$create_timer = 1000;
\swoole_timer_after($create_timer,function() use($roomid,$create_timer){
    createPacket($roomid,$create_timer);
});

$rob_timer    = 500;
\swoole_timer_after($rob_timer,function() use ($roomid,$rob_timer){
    robPacket($roomid,$rob_timer);
});


$user_rob_timer    = 600;
\swoole_timer_after($user_rob_timer,function() use ($roomid,$user_rob_timer){
    userRobPacket($roomid,$user_rob_timer,56);
});


function userRobPacket($roomid,$rob_timer,$userid){

    connect::getTime();
    connect::resetTime();
    $has = hasCanRobPacket($roomid);
    if($has !== false){
        if(packet::rob($has,$userid)){
            melog("[用户]领取成功!");
            \swoole_timer_after($rob_timer+100,function() use ($roomid,$rob_timer,$userid){
                userRobPacket($roomid,$rob_timer,$userid);
            });
            return ;
        }else{
            melog("[用户]自动领取红包失败:".packet::getErrorMessage());
        }
    }else{
        melog("[用户]没有红包可以领取!");
    }

    swoole_timer_after($rob_timer,function() use ($roomid,$rob_timer,$userid){
        userRobPacket($roomid,$rob_timer,$userid);
    });
}