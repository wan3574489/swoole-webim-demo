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

//
  class robController {
    public $mpid=0;
    public $works=[];
    public $max_precess=5;
    public $process_number = 20;
    public $new_index=0;

    public function __construct(){
        try {
            swoole_set_process_name(sprintf('php-ps:%s', 'master'));
            $this->mpid = posix_getpid();
            $this->run();
            $this->processWait();
        }catch (\Exception $e){
            die('ALL ERROR: '.$e->getMessage());
        }
    }

    public function run(){
        for ($i=0; $i < $this->max_precess; $i++) {
            $this->CreateProcess($i);
        }
    }

    public function CreateProcess($index=null){

        $process = new swoole_process(function(swoole_process $worker)use($index){
            if(is_null($index)){
                $index=$this->new_index;
                $this->new_index++;
            }
            swoole_set_process_name(sprintf('php-ps:%s',$index));

            $step =$index+1;


            for($i = 1;$i<=$this->process_number;$i++){
                $roomid = $i + ($step-1)*$this->process_number;

                $create_timer = 10000;
                \swoole_timer_after($create_timer,function() use($roomid,$create_timer){
                    createPacket($roomid,$create_timer);
                });

                $rob_timer    = 2000;
                \swoole_timer_after($rob_timer,function() use ($roomid,$rob_timer){
                    robPacket($roomid,$rob_timer);
                });

                echo "room".$roomid."新建成功.\n";
                usleep(200);
            }


        }, false, false);
        $pid=$process->start();
        $this->works[$index]=$pid;
        return $pid;
    }
    public function checkMpid(&$worker){
        if(!swoole_process::kill($this->mpid,0)){
            $worker->exit();
            // 这句提示,实际是看不到的.需要写到日志中
            echo "Master process exited, I [{$worker['pid']}] also quit\n";
        }
    }

    public function rebootProcess($ret){
        $pid=$ret['pid'];
        $index=array_search($pid, $this->works);
        if($index!==false){
            $index=intval($index);
            $new_pid=$this->CreateProcess($index);
            echo "rebootProcess: {$index}={$new_pid} Done\n";
            return;
        }
        throw new \Exception('rebootProcess Error: no pid');
    }

    public function processWait(){
        while(1) {
            if(count($this->works)){
                $ret = swoole_process::wait();
                if ($ret) {
                    $this->rebootProcess($ret);
                }
            }else{
                break;
            }
        }
    }
};

new robController();