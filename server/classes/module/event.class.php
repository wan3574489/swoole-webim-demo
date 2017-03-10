<?php

/**
 * Created by PhpStorm.
 * User: WanZengchuang
 * Date: 2017/3/10
 * Time: 10:44
 */
class event
{
    /**
     * 创建任务后生成一个创建红包的信息
     * @param $params
     */
    static function afterPacketEvent($params){
        return self::insertEvent($params['roomid'],array(
            'type' =>'create_packet',
            'userid' =>$params['userid'],
            'nickname'=>$params['user']['nickname'],
            'avatar'  =>$params['user']['img']
        ));
    }

    /**
     * 领取成功后
     * @param $params
     */
    static function afterRobEvent($params){
        return self::insertEvent($params['roomid'],array(
            'type' =>'rob_packet',
            'userid' =>$params['userid'],
            'nickname'=>$params['user']['nickname'],
            'avatar'  =>$params['user']['img']
        ));
    }

    /**
     * 插入一个事件
     * @param $data
     * @return bool
     */
    static function insertEvent($roomid,$data){
        $string_data = json_encode($data);
        $time = connect::getTime();
        $insert_packet_sql = " insert into ".connect::tablename("fortune_event")." (roomid,time,data) VALUES('$roomid',$time,'$string_data'); ";
        if(connect::query($insert_packet_sql)){
            return true;
        }
        return false;

    }
}