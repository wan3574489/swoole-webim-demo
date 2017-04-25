<?php
function page_404()
{
    exit("1");
}

function isValidRequest()
{
    if (!isset($_GET['openid']) && !isset($_GET['token'])) {
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

function checkSalf(){

    $salf = false;

    if(isset($_GET['_t'])){
        $t = $_GET['_t'];
        $time = time();

        if($time >= $t && $t+5>=$time){
            $salf = true;
        }
    }

    if(!$salf){
        header('Location: http://wchat.codeception.cn/app/index.php?i=15&c=entry&do=packet&m=wwe_health_care');
        exit;
    }
    return true;
}

function getCurrentUserInfo($filed="*")
{
    if(isset($_GET['openid'])){
        $openid = $_GET['openid'];
    }elseif(isset($_GET['token'])){
        $openid = $_GET['token'];
    }

    if ($user = connect::select(" select {$filed} from " . connect::tablename("fortune_user") . " where openid = '{$openid}'", true)) {
        if($filed == "*"){
            $key = $openid."-tx-number-".date("y-m-d");
            if (!$num = getRedisHandle()->get($key)) {
                $num = 0;
            }
            $key = $openid."-tx-money-".date("y-m-d");
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

function tx_alipay($money,$openid,$aliPayAccount){
    if(!class_exists("AopClient")){
        include_once __DIR__."/classes/alipay/AopSdk.php";
    }
    $c = new AopClient;
    $c->gatewayUrl = "https://openapi.alipay.com/gateway.do";
    $c->appId = "2017041106642794";
    $c->apiVersion = '1.0';
    $c->format = "json";
    $c->charset= "GBK";
    $c->signType= "RSA2";
    $c->rsaPrivateKey = 'MIIEpQIBAAKCAQEAp6AzfIrIqkr4bInF3kP6JPA7KfBP5uD1oG3ddsh330OdQnyFDzM4GL1CJIC19su3BaIS2QlJvNiPSH7DBAWOcJrxPy1378SZuxBfcQx4lXFPqFxy1ZOsqjR2xlJ9Mcgq7N3LuudYclnlJRBveAENedSLHiXpHbA0wd17q81fkrhcbCwxi9k2wi1GACeGDp29GCleI6nM2tG+/kG+WftLTXJfU2S8U0sYC0X+IRg6CjvVTeZNAb+FReIzBQ+hWs4ONQLpJUxHSBHlCrD+subshRTDuhRqQjBUvayR+lhgDZcOYCUAKmIqKAJad2suM3PsUzB+Q3dZoq0xsmB5Awm6ewIDAQABAoIBAQCITclwDT5M0zecso82RFpkrP+/A41FdUnmUVATZcGrx8RZqv1btc94tnTRT+QnMdG6f+cJmvbd287vKTyUyZvgzu067VMoodpL9W1WdMic5I3cnog2SaXOpWirranl0BmvkE84xSPzoEunTu0FTP3TQlR5iGQ94umTdvE4a4C6wWQrkysqhOCTNyL+hThy1DYYE1hwPwDO14MJiNGA7odhAzYw0goYgf6oBR67WkDGfpVws9HT01ZI99hbN9/xk5OoJV7NE+G8aTYpd6xS2shMVeeF7o2sMEPHAzUnSA+2eerG5zddtDqeeGdzVzaoqfibM7AwZxIHUDsGThMILhIpAoGBANcd0kUGwvhwEpp6rl2jC1P8zDk3FpmSXEbsN+RGdla8n1JCvQkCh8+ietukTaMB/1iq237A95byrz27qnqWoFlGmtL9/0+098prigkTVDvDfnu5Y1TvOKK5hc1ucRYhfD4gzeGjkC5Sp1Mj5ElFjwUh0QtfVhhzQMVdWIwKlb5FAoGBAMd7yfWtbJ7PRhJKfu6mOSprqYqm0RP2glMZn9iPN6agRUjkP13pITYFMTs5jqlq5mrRc1pzAQnEiOgK0wh3bO71NqVc1ft6jMhc3EBm2V0I50nkMfUDz4Vwt7oRKQO59GfgNxm81NrXn3Ra1wbTWGKtyQ8J5DSo7NUP85+FsIG/AoGBAKxy8a/4XbDAV4mTs9jI7jnkPOvZJ7rxRBxvHddYTWH3UFmnutdQOgPQI2GU89Art8IjJlcU5ucRoj6BBYfE3ML1AQUILfZ+Au85Cq1/21UVwX35/pGGPQbmZ0dqtCmjqnA76BBtCRa5l/3klgvPQXpBw820Hdb3/gK6dFO/4I9pAoGAI60/BIJcv9ZgONs78mCmLrEMpHCLSh+3VTdrACc1E8bsPUodDyWnu+qX0HjNy/0Dcq09DTsuP1n4BlARSB1bzSzr9g0xdAWJ8jexaI88Zsg13WBDkwd4cOwk39E73Z+/V2ihUigUhYM00HGCrYTU9OkR4W+qccSYfs6Yiro1RC8CgYEAkCWrPkgjTnZWa69e24MGxiLEePXYO9cMWX1Cy95No44tiKO9EzYe0CPMWcOgRj5NY6BO3eku/VQmC56dz4CDaaf96GkiG4uvlzOAoH8Fwi8WJp78UXGUEKlXbeMGDzw8qnhaoZyt4z7HJvXZLiCXgvstkF/Nz+klQ7Aoj7YBmOA=';
    $c->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAiq4EeNG+U8WqRxuTkzVrHfoSzwlUiRttuVHkzWCAfH6KPLVprOI+GzHsgeBxNn3qdFEYnryLedQj1tDlJ0wIwKZtroSwIoJ1JiZcpx+kjyEFxxsRJjvIVDo4RxAgyMdoNdhxGQWpHZlo7guW5VWvS+1ylhhjxjOvVQ8cM6a6if3dEWTMyGFpO1IAyc10PHDxn5I0Esgg5jh3TFgSDf8arr47Fxd4GqTHtG0jHFd4RIQq/Mi4xrx6Ysi2eFoC27P03wQt4jljIgtRNXSSBhiwva/eFX7Rsjck+JtNbN7rX3zfV7JKZJswVZ5JjDqLLtRcjyt0TkhlZNJ+vUYa/oWTCwIDAQAB';

    $money1 = 0.1;
    //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名
    $request = new AlipayFundTransToaccountTransferRequest ();
    $out_biz_no = time();

    $request->setBizContent("{" .
        "    \"out_biz_no\":\"$out_biz_no\"," .
        "    \"payee_type\":\"ALIPAY_LOGONID\"," .
        "    \"payee_account\":\"$aliPayAccount\"," .
        "    \"amount\":\"$money1\"," .
     /*   "    \"payer_show_name\":\"提现\"," .*/
        "    \"remark\":\"提现\"" .
        "  }");
    $result = $c->execute( $request);

    $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
    $resultCode = $result->$responseNode->code;

    if(!empty($resultCode)&&$resultCode == 10000){

        $key = $openid."-tx-number-".date("y-m-d");
        getRedisHandle()->incrby($key,1);

        $key = $openid."-tx-money-".date("y-m-d");
        getRedisHandle()->incrby($key,$money);
        $sql = "update  ".connect::tablename("fortune_user")." set virtual_money = virtual_money-".$money." where openid ='{$openid}'";
        connect::query($sql);
        return true;

    } else {
        return $result->$responseNode->sub_msg;
    }

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