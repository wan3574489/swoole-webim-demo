<?php
function page_404()
{
    exit("1");
}

function isValidRequest()
{
    if (!isset($_GET['openid'])) {
        page_404();
    }
}

isValidRequest();

include_once(__DIR__ . "/../server/classes/module/connect.class.php");

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

function getCurrentUserInfo($filed="*")
{
    $openid = $_GET['openid'];
    if ($user = connect::select(" select {$filed} from " . connect::tablename("fortune_user") . " where openid = '{$openid}'", true)) {
        if($filed == "*"){
            $key = "tx-number-".date("y-m-d");
            if (!$num = getRedisHandle()->get($key)) {
                $num = 0;
            }
            $key = "tx-money-".date("y-m-d");
            if (!$money = getRedisHandle()->get($key)) {
                $money = 0;
            }
            $user['today_withdraw'] = $num;
            $user['today_withdraw_money'] = $money;
        }
        return $user;
    }

    return false;
}

function tx($money,$openid)
{
    if(!class_exists('Wechat')){
        include __DIR__."/classes/wechat.class.php";
    }
    $wx = new Wechat(array());

    if($wx->payTransfers(1,$openid,'1444290802','wxaeb33e5269d52588',array(
        'certfile'=>__DIR__.'/../certs/apiclient_cert.pem',
        'keyfile' =>__DIR__.'/../certs/apiclient_key.pem',
        'rootfile'=>__DIR__.'/../certs/rootca.pem'
    ),'Hcth1392529292918627187950135902')){
        $key = "tx-number-".date("y-m-d");
        getRedisHandle()->incrby($key,1);

        $key = "tx-money-".date("y-m-d");
        getRedisHandle()->incrby($key,$money);
        $sql = "update  ".connect::tablename("fortune_user")." set virtual_money = virtual_money-".$money." where openid ='{$openid}'";
        if(connect::query($sql)){
            return true;
        }
    }
    return false;
}

function showJson($status, $data = '')
{
    $ret['status'] = $status;
    if ($data) {
        $ret['data'] = $data;
    }
    echo json_encode($ret);
    exit;
}