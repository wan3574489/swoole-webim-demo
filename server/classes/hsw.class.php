<?php
class hsw {
	private $serv = null;

    private $isClose = array();

	public function __construct(){
		File::init();

		$this->serv = new swoole_websocket_server("0.0.0.0",9501);
		$this->serv->set(array(
			'task_worker_num'     => 8
		));
		$this->serv->on("open",array($this,"onOpen"));
		$this->serv->on("message",array($this,"onMessage"));
		$this->serv->on("Task",array($this,"onTask"));
		$this->serv->on("Finish",array($this,"onFinish"));
		$this->serv->on("close",array($this,"onClose"));

		$this->serv->start();
	}
	
	public function onOpen( $serv , $request ){
		$data = array(
					'task' => 'open',
					'fd' => $request->fd
				);
		$this->serv->task( json_encode($data) );
		echo "open\n";

        $this->isClose[$request->fd] = 0;

        $this->afterPushMessage(500,$request->fd);
	}

	private $pushTime = false;
	public function addPushTime($fd,$value){
		$this->pushTime[$fd] = $value;
	}

	public function getPushTime($fd){
		if(isset($this->pushTime[$fd]) && !empty($this->pushTime[$fd])){
			return $this->pushTime[$fd];
		}
		return connect::get_millisecond();
	}

	public function afterPushMessage($time,$fd){
	    $the = $this;

        if(isset($this->isClose[$fd]) && ($this->isClose[$fd] == 1) ){
            return false;
        }

        swoole_timer_after($time, function() use ($the,$fd,$time) {

            $select_time = $this->getPushTime($fd);
			//$__sql = "";

			$end_time = connect::get_millisecond();
            $__sql = "select data from ".connect::tablename("fortune_event")." where time > $select_time and  time <= $end_time";
            /*$__sql = "select data from ".connect::tablename("fortune_event")." where 1 = 1 ";
			echo $__sql."\n";*/
			//echo $__sql."\n";

            if($ret = connect::select($__sql)){
                foreach($ret as $r){
					$data = json_decode($r['data'],true);
					$data['fd'] = $fd;
                    $this->serv->task( json_encode($data) );
                }
            }
			$this->addPushTime($fd,$end_time);
            $the->afterPushMessage($time,$fd);
        });
    }

	public function onMessage( $serv , $frame ){
		$data = json_decode( $frame->data , true );
		switch($data['type']){
			//openid登陆
			case 101:
				$data = array(
					'task' => 'loginOpenid',
					'params' => array(
						'openid' => $data['openid'],
					),
					'fd' => $frame->fd,
					'roomid' =>$data['roomid']
				);
				break;
			case 1://登录
				$data = array(
					'task' => 'login',
					'params' => array(
							'name' => $data['name'],
							'email' => $data['email']
						),
					'fd' => $frame->fd,
					'roomid' =>$data['roomid']
				);
				
				if(!$data['params']['name'] || !$data['params']['email'] ){
					$data['task'] = "nologin";
					$this->serv->task( json_encode($data) );
					break;
				}
				$this->serv->task( json_encode($data) );
				break;
			case 2: //新消息
				$data = array(
					'task' => 'new',
					'params' => array(
							'name' => $data['name'],
							'avatar' => $data['avatar']
						),
					'c' => $data['c'],
					'message' => $data['message'],
					'fd' => $frame->fd,
					'roomid' => $data['roomid']
				);
				$this->serv->task( json_encode($data) );
				break;
			case 3: // 改变房间
				$data = array(
					'task' => 'change',
					'params' => array(
						'name'   => $data['name'],
						'avatar' => $data['avatar'],
					),
					'fd' => $frame->fd,
					'oldroomid' => $data['oldroomid'],
					'roomid' => $data['roomid']
				);
				
				$this->serv->task( json_encode($data) );
				
				break;
            case 11:  //抢红包
                $data = array(
                    'task'=>'red_packet',
                    'params' => array(
                        'u_id'=> $data['u_id'],
                        'packet_id'=>$data['packet_id']
                    ),
                    'fd' => $frame->fd,
					'roomid' => $data['roomid']
                );

                $this->serv->task( json_encode($data) );
                break;
			default :
				$this->serv->push($frame->fd, json_encode(array('code'=>0,'msg'=>'type error')));
		}
	}
	public function onTask( $serv , $task_id , $from_id , $data ){
		$pushMsg = array('code'=>0,'msg'=>'','data'=>array());
		$data = json_decode($data,true);
		switch( $data['task'] ){
			case "rob":
				$packet_id = $data['packet_id'];
				$openid = $data['openid'];
				if(packet::rob($packet_id,$openid)){
					$pushMsg = array(
						'task'      =>'rob_success',
						'code'      => 1101,
						'data'    => array(
							'code'      => 1100,
						),
						'roomid'=>$data['roomid']
					);
				}else{
					$pushMsg = array(
						'task'      =>'rob_fail',
						'code'      => 1102,
						'data'    => array(
							'code'      => 1102,
						),
						'roomid'=>$data['roomid']
					);
				}

				$this->serv->push( $data['fd'] , json_encode($pushMsg) );
				return 'Finished';
			case 'open':
				$pushMsg = Chat::open( $data );
				$this->serv->push( $data['fd'] , json_encode($pushMsg) );
				return 'Finished';
			case 'login':
				$pushMsg = Chat::doLogin( $data );
				break;
			case 'loginOpenid':
				$pushMsg = Chat::doLoginOpenid( $data );
				break;
			case 'new':
				$pushMsg = Chat::sendNewMsg( $data );
				break;
			case 'logout':
				$pushMsg = Chat::doLogout( $data );
				break;
			case 'nologin':
				$pushMsg = Chat::noLogin( $data );
				$this->serv->push( $data['fd'] ,json_encode($pushMsg));
				return "Finished";
			case 'change':
				$pushMsg = Chat::change( $data );
				break;
			case 'rob_packet':
			case 'create_packet':
			case 'which_send_packet':
			case 'system_prompt_next_packet':
			case 'system_prompt_next_packet_done':
				$pushMsg  = $data ;
				$this->serv->push( $data['fd'] ,json_encode($pushMsg));
				return "Finished";
		}

		$this->sendMsg($pushMsg,$data['fd']);
		return "Finished";
	}
	
	public function onClose( $serv , $fd ){

        $this->isClose[$fd] = 1;

		$pushMsg = array('code'=>0,'msg'=>'','data'=>array());
		//获取用户信息
		$user = Chat::logout("",$fd);
		if($user){
			$data = array(
				'task' => 'logout',
				'params' => array(
						'name' => $user['name']
					),
				'fd' => $fd
			);
			$this->serv->task( json_encode($data) );
		}
		
		echo "client {$fd} closed\n";
	}
	
	public function sendMsg($pushMsg,$myfd){
		foreach($this->serv->connections as $fd) {
			if($fd === $myfd){
				$pushMsg['data']['mine'] = 1;
			} else {
				$pushMsg['data']['mine'] = 0;
			}
			$this->serv->push($fd, json_encode($pushMsg));
		}
	}
	
	
	public function onFinish( $serv , $task_id , $data ){
		echo "Task {$task_id} finish\n";
        echo "Result: {$data}\n";
	}
}