<?php


/**
 * 创建一个红包
 */
function createPacket($roomid){
    global $create_timer;
    connect::getTime();
    connect::resetTime();

    /*$roomid = 'a';*/
    if(!hasPacket($roomid)){
        if($rebootid = getRandReboot([])){
            if($a =  packet::create($roomid,$rebootid)){
                melog("创建红包成功,红包编号:$a,创建人:$rebootid");
            }else{
                melog("创建红包失败:".packet::getErrorMessage());
            }
        }
    }

    \swoole_timer_after($create_timer,function() use ($roomid){
        createPacket($roomid);
    });
}

/**
 * 机器人自动领取红包
 * @param $roomid
 * @return bool
 */
function robPacket($roomid){
    global $rob_timer;

    /*$roomid = 'a';*/
    connect::getTime();
    connect::resetTime();

    $has = hasCanRobPacket($roomid);
    if($has !== false){
        if($id = getRandReboot('')){
            if(packet::rob($has,$id)){
                melog("自动领取红包成功:红包id{$has},机器人{$id}");
                \swoole_timer_after($rob_timer+2000,function() use ($roomid){
                    robPacket($roomid);
                });
                return ;
            }else{
                melog("自动领取红包失败:".packet::getErrorMessage());
            }
        }
    }

    swoole_timer_after($rob_timer,function() use ($roomid){
        robPacket($roomid);
    });

}

/**
 * 是否有长时间没有领取完的红包
 */
function hasCanRobPacket($roomid){

    $end_time = connect::getTime();
    //10秒中没有领取完就领取一次
    $begin_time   = $end_time-10000*100;
    $sql = 'select packet_id from '.connect::tablename("fortune_packet_info") . " where roomid  = '{$roomid}' and /*create_at >= $begin_time and create_at <= $end_time and*/ status = 0 limit 1";
    if($has = connect::select($sql,true)){
        return $has['packet_id'];
    }
    return false;
}

function hasPacket($roomid){
    $sql = 'select count(*) from '.connect::tablename("fortune_packet") . " where  roomid  = '{$roomid}'";

    if(connect::count($sql) <=0){
        return false;
    }
    return true;

    //60秒内没有创建一个红包就让机器人创建一个
    $end_time = connect::getTime();
    $begin_time   = $end_time-10000*60;
    $sql = 'select count(*) from '.connect::tablename("fortune_packet") . " where roomid  = '{$roomid}' and create_at >= $begin_time and create_at <= $end_time";

    if(connect::count($sql) <=0){
        echo "end time : ".$end_time." begin_time :".$begin_time."\n";
        echo $sql."\n";
        return false;
    }


    return true;
}

/**
 * 获取随机的机器人的id
 * @param $ex
 * @return bool
 */
function getRandReboot($ex){
    $tablname = connect::tablename('fortune_user');
    $ex = false;
    $sql = "SELECT t1.id FROM `".$tablname."` AS t1 JOIN ( SELECT ROUND( RAND() * ( ( SELECT MAX(id) FROM `".$tablname."` WHERE user_type = 5 ) - ( SELECT MIN(id) FROM `".$tablname."` WHERE user_type = 5 ) ) + ( SELECT MIN(id) FROM `".$tablname."` WHERE user_type = 5 ) ) AS id) AS t2 WHERE t1.id >= t2.id ORDER BY t1.id LIMIT 1;";
    if($r = connect::select($sql,true)){
        return $r['id'];
    }
    return false;
}

function melog($string){
    echo "[". date("Y-m-d H:i:s ",time())."]".$string."\n";
}
