<?php
class File {
	/**
	 * @var self
	 */
	public static $instance;
	protected $online_dir;
    protected $history = array();
    protected $history_max_size = 100;
    protected $history_write_count = 0;
	public $client;

	private function __construct() {
		global $rooms;
		$this->client = new Redis();
		$this->client->connect('127.0.0.1', 6379);
		$this->client->setOption(Redis::OPT_PREFIX, 'swoole-webim:');
	}

	public static function init(){
		if(self::$instance instanceof self){
			return false;
		}
		self::$instance = new self();
	}
	
	public static function clearDir($key) {
		self::$instance->client->delete($key);
        return true;
    }

	public static function getRoomidKey($roomid){
		return 'room-key-'.$roomid;
	}

	public static function changeUser($oldroomid,$fd,$newroomid){
		$oldroomidKey = self::getRoomidKey($oldroomid);
		$newroomidKey = self::getRoomidKey($newroomid);

		$oldValue = self::$instance->client->lGet($oldroomidKey,$fd);
		self::$instance->client->lSet($newroomidKey,$fd,$oldValue);

		self::outRoom($oldroomid,$fd);
		self::joinRoom($newroomid,$fd);

		return true;
	}

	public static function joinRoom($room,$fd){
		self::$instance->client->sadd("room-".$room,$fd);
		self::$instance->client->set('fd-'.$fd,$room);
	}

	public static function outRoom($room,$fd){
		self::$instance->client->sRem("room-".$room,$fd);
		self::$instance->client->delete('fd-'.$fd,$room);

	}

	public static function getRoomUsers($room){
		return self::$instance->client->sMembers($room);
	}

	public static function checkDir($dir, $clear_file = false) {
        if ($clear_file) {
           self::clearDir($dir);
        }
    }

	//登录
	public static function login($roomid,$fd, $info){
		$roomidKey = self::getRoomidKey($roomid);

        self::$instance->client->rPush($roomidKey, 'A');
        self::$instance->client->rPush($roomidKey, 'b');

		$flag = self::$instance->client->lSet($roomidKey,$fd,json_encode($info));

		self::joinRoom($roomid,$fd);
		return $flag;
    }

	/**
	 * 获取所有房间的在线用户
	 */
	public static function getOnlineUsers(){
		global $rooms;
		$online_users = array();
		foreach($rooms as $_k => $_v){
			$online_users[$_k] = array_slice(self::getRoomUsers($_k), 2);
		}
        return $online_users;
    }
	
	public static function getUsersByRoom($roomid){
		$users = array_slice(self::getRoomUsers($roomid), 2);
		return $users;
	}
	
	public static function getUsers($roomid,$users) {
        $ret = array();
        foreach($users as $v){
            $ret[] = self::getUser($roomid,$v);
        }
        return $ret;
    }
	
	public static function getUser($roomid,$userid) {
		if($roomid == ""){
			$roomid = self::$instance->client->get('fd-'.$userid);
		}
        if ($roomid == "") {
            return false;
        }

		$roomidKey = self::getRoomidKey($roomid);
		$ret = self::$instance->client->lGet($roomidKey,$userid);
        $info = @json_decode($ret,true);
		$info['roomid'] = $roomid;//赋予用户所在的房间
        return $info;
    }

	public static function logout($userid) {
		$roomid = self::$instance->client->get('fd-'.$userid);
		$roomidKey = self::getRoomidKey($roomid);
		$flag = self::$instance->client->lSet($roomidKey,$userid,0);

		self::outRoom($roomid,$userid);
    }
	
	public static function exists($roomid,$userid){
		$roomid = self::$instance->client->get('fd-'.$userid);
		if($roomid == $userid){
			return true;
		}
		return false;
    }
}