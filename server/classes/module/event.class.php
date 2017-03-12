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

        $data = array(
            'task'      =>'create_packet',
            'code'      => 1001,
            'params'    => array(
                'code'      => 1001,
                'name' => $params['user']['nickname'],
                'avatar' => $params['user']['img'],
                'userid' =>$params['userid'],
                'packet_id'=>$params['packet_id'],
                'roomid'=>$params['roomid']
            ),
            'roomid'=>$params['roomid']
        );

        return self::insertEvent($params['roomid'],$data);
    }

    /**
     * 领取成功后
     * @param $params
     * @return bool
     */
    static function afterRobEvent($params){

        $data = array(
            'task'      =>'rob_packet',
            'code'      => 1002,
            'data'    => array(
                'code'      => 1002,
                'geter_name' => $params['user']['nickname'],
                'payer_name' => $params['pay_user']['nickname'],
                'avatar' => $params['user']['img'],
                'userid' =>$params['userid'],
                'roomid'=>$params['roomid']
            ),
            'roomid'=>$params['roomid']
        );

        self::insertEvent($params['roomid'],$data);

        //红包发完了
        $count_sql = "select count(*) as count from ".connect::tablename("fortune_packet")." where rob_number = 4 and  id = ".$params['packet_id'];
        $count = connect::count($count_sql);
        if($count == 1 ){
            //
            \swoole_timer_after(500,function()use($params){
                connect::debug('计算谁发下一个红包');
                if(packet::next_packet_which_send($params['packet'])){
                    connect::debug('计算成功');
                }else{
                    connect::debug('计算失败');
                }
            });
        }

        return true;
    }

    /**
     * 谁发下一个红包
     * @param $roomid
     * @param $data
     */
    static function next_packet_which_sendEvent($params){
        $data = array(
            'task'      =>'which_send_packet',
            'code'      => 1003,
            'data'    => array(
                'code'      => 1003,
                'payer_name' => $params['pay_user']['nickname'],
                'payer_avater'=>$params['pay_user']['img']
            ),
            'roomid'=>$params['roomid']
        );

        self::insertEvent($params['roomid'],$data);

        //下一个红包即将发出
        \swoole_timer_after(1000, function() use($params){
            connect::resetTime();
            $data = array(
                'task'      =>'system_prompt_next_packet',
                'code'      => 1004,
                'data'    => array(
                    'code'      => 1004,
                ),
                'roomid'=>$params['roomid']
            );

            self::insertEvent($params['roomid'],$data);

        });

        //五秒倒计时
        \swoole_timer_after(1500, function() use($params){
            connect::resetTime();

            $data = array(
                'task'      =>'system_prompt_next_packet_done',
                'code'      => 1005,
                'data'    => array(
                    'code'      => 1005,
                ),
                'roomid'=>$params['roomid']
            );

            self::insertEvent($params['roomid'],$data);
        });

        //五秒后插入红包数据
        \swoole_timer_after(7000, function() use($params){
            connect::resetTime();
            //
            packet::create($params['roomid'],$params['pay_user']['id']);
        });
    }

    /**
     * 插入一个事件
     * @param $data
     * @return bool
     */
    static function insertEvent($roomid,$data){
        $string_data = json_encode($data,JSON_UNESCAPED_UNICODE);
        $time = connect::get_millisecond();
        $insert_packet_sql = " insert into ".connect::tablename("fortune_event")." (roomid,time,data) VALUES('$roomid',$time,'$string_data'); ";
        if(connect::query($insert_packet_sql)){
            return true;
        }
        return false;

    }
}