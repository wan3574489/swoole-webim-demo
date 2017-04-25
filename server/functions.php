<?php

/**
 * �ַ�����SQLע����룬��GET,POST,COOKIE�����ݽ���Ԥ����
 *
 * @param  $input Ҫ�����ַ�����������
 * @param  $urlencode �Ƿ�ҪURL����
 */
function escape($input, $urldecode = 0) {
    if(is_array($input)){
        foreach($input as $k=>$v){
            $input[$k]=escape($v,$urldecode);
        }
    }else{
        $input=trim($input);
        if ($urldecode == 1) {
            $input=str_replace(array('+'),array('{addplus}'),$input);
            $input = urldecode($input);
            $input=str_replace(array('{addplus}'),array('+'),$input);
        }
        // PHP�汾����5.4.0��ֱ��ת���ַ�
        if (strnatcasecmp(PHP_VERSION, '5.4.0') >= 0) {
            $input = addslashes($input);
        } else {
            // ħ��ת��û�������Զ��ӷ�б��
            if (!get_magic_quotes_gpc()) {
                $input = addslashes($input);
            }
        }
    }
    //��ֹ���һ����б������SQL������ 'abc\'
    if(substr($input,-1,1)=='\\') $input=$input."'";//$input=substr($input,0,strlen($input)-1);
    return $input;
}

function getRedisHandle()
{
    static $redis;
    if (!$redis) {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->setOption(Redis::OPT_PREFIX, 'swoole-webim:');
    }
    return $redis;
}