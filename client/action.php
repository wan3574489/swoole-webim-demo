<?php

include_once __DIR__."/common.php";

if(!isset($_GET['action'])){
    $action = isset($_POST['action'])?$_POST['action']:'';
}else{
    $action = $_GET['action'];
}


switch($action){
    case "getMoney":
        if(!$user = getCurrentUserInfo("virtual_money")){
            page_404();
        }
        showJson(1,$user['virtual_money']);
        break;
    case "tx":
        if(!$user = getCurrentUserInfo()){
            page_404();
        }
        $money = $_POST['money'];
        $aliPayAccount = $_POST['aliPayAccount'];

        $money = round($money ,2);
        if($user['today_withdraw'] >=10){
            showJson(0,"今日已经提现10次，无法再提现了!");
        }
        if($money<10){
            showJson(0,"提现金额最低10元!");
        }
        if($money>$user['virtual_money']){
            showJson(0,"您最多提现".$user['virtual_money']."元");
        }
        if($money>20000){
            showJson(0,"您最多提现20000元");
        }
        if(empty($aliPayAccount)){
            showJson(0,"请输入您的支付宝账号。");
        }

        if($ret = tx_alipay($money,$user['openid'],$aliPayAccount)){
            if($ret === true){
                showJson(1,$ret);
            }else{
                showJson(0,$ret);
            }
        }
        showJson(0,"系统异常，请刷新重新试!");
        break;
    case "txall":
        if(!$user = getCurrentUserInfo()){
            page_404();
        }
        $money = $user['virtual_money'];
        $money = round($money ,2);
        if($user['today_withdraw'] >=10){
            showJson(0,"今日已经提现10次，无法再提现了!");
        }
        if($money<10){
            showJson(0,"提现金额最低10元!");
        }
        if($money>20000){
            showJson(0,"您最多提现20000元");
        }
        if(empty($aliPayAccount)){
            showJson(0,"请输入您的支付宝账号。");
        }

        if($ret = tx_alipay($money,$user['openid'],$aliPayAccount)){
            if($ret === true){
                showJson(1,$ret);
            }else{
                showJson(0,$ret);
            }
        }
        showJson(0,"系统异常，请刷新重新试!");
        break;
}

?>
