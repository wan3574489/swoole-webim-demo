<?php

class packet extends message {

    /**
     * 生成红包
     * @param $roomid
     * @param $userid
     * @return bool
     */
    static function create($roomid,$userid){
        if(is_array($userid)){
            $user = $userid;
        }else{
            $user = self::getUser($userid);
        }

        if(!$user){
            self::addErrorMessage("用户不存在");
            return false;
        }

       $packet_number = self::getPayMonery($roomid);
       if( ($user['user_type'] !=5) && ($user['virtual_money'] < $packet_number) ){
           self::addErrorMessage("金额不够");
           return false;
       }

        connect::openCommit();
        $time = connect::getTime();
        try{
            $insert_packet_sql = " insert into ".connect::tablename("fortune_packet")." (user_id,roomid,packet_number,create_at,status) VALUES($userid,'$roomid',$packet_number,$time,1); ";
            $update_user_monery_sql = " update ".connect::tablename("fortune_user")." set virtual_money=virtual_money - $packet_number where id = $userid";

           // echo $insert_packet_sql;

            if(!$id = connect::insert($insert_packet_sql)){

                self::addErrorMessage(connect::getInstance()->error);
                connect::rollback();
                return false;
            }

            if(!connect::query($update_user_monery_sql)){
                self::addErrorMessage(connect::getInstance()->error);
                connect::rollback();
                return false;
            }

            if(!self::createSmallPacket($roomid,$id,$packet_number)){
                connect::rollback();
                return false;
            }

            if(!event::afterPacketEvent([
                'roomid'=>$roomid,
                'userid'=>$userid,
                'packet_id'=>$id,
                'time' =>$time,
                'user' =>$user
            ])){
                connect::rollback();
                return false;
            }

            connect::debug("包创建成功,id".$id);

            connect::submitCommit();

            return true;
        }catch (Exception $e){
            connect::rollback();
        }

    }

    /**
     * 创建小包数据
     * @param $packet_number
     * @return bool
     */
     protected static function createSmallPacket($roomid,$packet_id,$packet_number){
        $time = connect::getTime();
        $residue_number = $packet_number*100;
        $max_number = 4;
        $result = array();
        for($i =1;$i<=$max_number;$i++){
            if($i == 4){
                $rand_number = ($packet_number*100) - $residue_number;
            }else{
                $rand_number = rand(1,$residue_number);
                if(rand(0,1) == 1){
                    $rand_number = rand(1,$rand_number);
                }
            }
            //
            $residue_number = $residue_number - $rand_number;
            $result[] = $rand_number;
        }
        rsort($result);

        foreach ($result as $i =>$rand_number){
            if($i == 1 || $i == 4){
                $robot_place = rand(3,4);
            }else{
                $robot_place = rand(1,2);
            }

            $insert_packet_sql = " insert into ".connect::tablename("fortune_packet_info")." (roomid,packet_id,user_id,packet_number,create_at,rob_at,plcae,status,robot_place) VALUES('{$roomid}',$packet_id,0,$rand_number/100,$time,0,$i+1,0,$robot_place); ";
            if(!connect::insert($insert_packet_sql)){
                self::addErrorMessage(connect::getInstance()->error);
                return false;
            }
        }

        return true;
    }

    /**
     * 领取
     * @param $packet_id
     * @param $userid
     * @return bool
     */
    static function rob($packet_id,$userid){
        $time = connect::getTime();
        if(is_array($userid)){
            $user = $userid;
        }else{
            $user = self::getUser($userid);
        }

        $packet = self::getPacket($packet_id);
        $roomid = $packet['roomid'];

        //是否已经领取
        $count_sql = "select count(*) from ".connect::tablename("fortune_packet_info")." where status = 1 and user_id = $userid and  packet_id = ".$packet_id;
        $count = connect::count($count_sql);
        if($count > 0 ){
            self::addErrorMessage("对不起，您已经领取",1001);
            return false;
        }

        //机器人先领取的时候只领取到第2-3位的，后面再领取第一位的，最后是第4位的
        $count_sql = "select count(*) from ".connect::tablename("fortune_packet_info")." where status = 0 and  packet_id = ".$packet_id;
        $count = connect::count($count_sql);
        if($count <= 0 ){
            self::addErrorMessage("红包领取完了",1000);
            return false;
        }


        connect::openCommit();

        // 用户类型
        if($user['user_type'] == 5){
            $update_sql = "update ".connect::tablename("fortune_packet_info")." set user_id=$userid ,status = 1 ,rob_at = $time where status = 0 and id = ( select id  from (select id from ".connect::tablename("fortune_packet_info")." where packet_id = $packet_id and status = 0 order by robot_place asc limit 1 )as a) ";
        }else{
            $update_sql = "update ".connect::tablename("fortune_packet_info")." set user_id=$userid ,status = 1 ,rob_at = $time where status = 0 and id = ( select id from  (select id from ".connect::tablename("fortune_packet_info")." where packet_id = $packet_id and status = 0 order by  robot_place desc limit 1) as a) ";
        }

        if(!connect::query($update_sql)){
            self::addErrorMessage("红包领取完了",1000);
            return false;
        }

        $update_sql = "update ".connect::tablename("fortune_packet")." set rob_number = rob_number +1  where id = $packet_id";
        if(!connect::query($update_sql)){
            connect::rollback();
            self::addErrorMessage("红包领取完了",1000);
            return false;
        }

        //领取成功
        if(!event::afterRobEvent(array(
            'packet_id'=>$packet_id,
            'packet'   =>$packet,
            'userid'   => $userid,
            'roomid'   =>$roomid,
            'user' =>$user,
            'pay_user'=> self::getUser($packet['user_id'])
        ))){
            connect::rollback();
            return false;
        }

        connect::submitCommit();

        return true;
    }

    /**
     * 谁继续发红包
     */
    static function next_packet_which_send($packet){
        $packet_id = $packet['id'];

        $sql = " select user_id from ".connect::tablename("fortune_packet_info")." where packet_id = ".$packet_id." and plcae = 4 and status = 1 ";
        if(!$user = connect::select($sql,true)){
            return false;
        }

        connect::debug('有人需要发下一个红包');

        //
        $user_id = $user['user_id'];
        event::next_packet_which_sendEvent(array(
            'pay_user'=>packet::getUser($user_id),
            'roomid' => $packet['roomid']
        ));



        return true;
    }

    static function getUser($userid){
        if(strlen($userid) > 15){
            $sql = "select * from ".connect::tablename("fortune_user")." where openid = ".$userid;
        }else{
            $sql = "select * from ".connect::tablename("fortune_user")." where id = ".$userid;
        }
        return connect::select($sql,true);
    }

    static function getPacket($packet_id){
        $sql = "select * from ".connect::tablename("fortune_packet")." where id = ".$packet_id;
        return connect::select($sql,true);
    }

    static function getPayMonery($roomid){
            return 200;
    }

}