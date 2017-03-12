<?php
class message{
    static $_message ;
    static function addErrorMessage($string,$code = -1){
        self::$_message[self::class] = array(
            'message'=>$string,
            'code'   =>$code
        );
        connect::debug("message:".$string);
    }

    static function getErrorMessage(){
        $ret = self::$_message[self::class];
        return $ret['message'];
    }

    static function getErrorCode(){
        $ret = self::$_message[self::class];
        return $ret['code'];
    }
}