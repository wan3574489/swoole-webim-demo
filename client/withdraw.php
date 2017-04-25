<?php
    include_once __DIR__."/common.php";
    if(!$user = getCurrentUserInfo()){
        header('Location: http://wchat.codeception.cn/app/index.php?i=15&c=entry&do=packet&m=wwe_health_care');
        exit;
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <title>提现</title>
    <link href="style/withdraw.css?t=<?php echo time();?>" rel="stylesheet">
</head>

<body>
    <div class="shade" id="shade" ></div>
    <!--说明-->
    <div class="popup" id="popup-1">
        <div class="popup-header">
            <div class="exit"></div>
            <div class="popup-title">提款说明</div>
        </div>
        <div class="popup-content">
            <p>1.提现为实时到账，将直接到账您的收款账户(如遇网络延迟状态，请耐心等待)，所提金额将在当日24时前处理完毕，请正确填写账户信息，如因账户信息填写错误，导致资金不能到账，所造成的损失，由用户自行承担；</p>
            <p>2.禁止使用任何技术手段抢包，偷包等，一经查实，平台将有权冻结该账户；</p>
            <p>3.据第三方平台规定，提现手续费按转账金额1%收取，不足1元则按1元计算;</p>
            <p>4.如遇问题 可联系客户：<br>
                123456（微信）
            </p>
        </div>

        <div class="popup-content">
            <button class="button-1 button-2" id="iknow">我知道了</button>
        </div>
    </div>

    <!--区块1-->
    <div class="layout layout-1">
        <div class="layout-line layout-header">
            收款账户
        </div>
        <div class="layout-line layout-content">
            <div class="layout-column layout-column-2 vertical-center">
                <img src="image/icon_wchat_1.png" width="41" height="40">
            </div>
            <div class="layout-column layout-column-6 font-border-1">
                <p class="size-16">支付宝账户</p>
            </div>
            <div class="layout-column layout-column-2 vertical-center right">
                <img src="image/chose.png" width="20" height="20">
            </div>
        </div>
    </div>

    <!--区块2-->
    <div class="layout layout-2 size-16">
        <div class="layout-line layout-header">金额提现 </div>
        <div class="layout-line layout-content">
            <div class="layout-column layout-column-2 vertical-center"  >
                提现金额
            </div>
            <div class="layout-column  vertical-center layout-column-3">
                <input type="text" id="money" placeholder="请输入提款金额 (最低10元起提)" class="input-1">
            </div>
        </div>
        <div class="layout-line layout-content" style=" border-top: solid 1px #cacaca;">
            <div class="layout-column layout-column-2 vertical-center"  >
                支付宝账号
            </div>
            <div class="layout-column  vertical-center layout-column-3">
                <input type="text"  id="aliPayAccount" placeholder="请输入您的支付宝账号" class="input-1">
            </div>
        </div>

        <div class="layout-line layout-content border-top-1 height-1 text-center">
            可提现余额：<span class="red-2"><?php echo $user['virtual_money'];?></span>元
           <!-- <div class="layout-column layout-column-2 font-right-1">余额:</div>
            <div class="layout-column "></div>-->
           <!-- <div class="layout-column layout-column-2 right red" id="withdrawall">全部提款</div>-->
        </div>
    </div>

    <!--区块3-->
    <div class="layout layout-3">
        <div class="layout-line text-center ">
            <p class="size-2">手续费按提现金额1%收取，不足1元则按1元收取</p>
<!--            <p>(今日可提取<span class="oring"><?php /*echo 20000-$user['today_withdraw_money'];*/?></span>元|剩余<span class="oring"><?php /* echo 10 - $user['today_withdraw'];*/?></span>次)</p>
-->        </div>
    </div>

    <!--区块4-->
    <div class="layout">
        <div class="layout-line">
           <button id="submit" class="button-1" >确定提现</button>
        </div>
    </div>

</body>
<script src="http://cdn.bootcss.com/jquery/1.12.3/jquery.js"></script>
<script>

    $(document).ready(function () {
        var oldmoney = <?php echo $user['virtual_money'];?>;
        var number = <?php echo $user['today_withdraw'];?>;
        var openid = '<?php echo $user['openid'];?>';
        if(false && (number >=10 || oldmoney < 10) ){
            $("#submit").css("background-color",'#c1c2c1');
        }else{

            function tx(numer){
                var par = {};
                if(numer=='all'){
                    par['action'] = 'txall';
                }else{
                    par['action'] = 'tx';
                    par['money'] = numer;
                }

                var aliPayAccount = $("#aliPayAccount").val();
                aliPayAccount = aliPayAccount.trim();
                if(aliPayAccount.length <=0){
                    alert("请填写您的支付宝账号!");
                    return ;
                }
                par['aliPayAccount'] = aliPayAccount;

                if(window.confirm("确定["+aliPayAccount+"]是提现的支付宝账户吗?")){
                    $.post("/action.php?openid=<?php echo $_GET['openid'];?>",par,function(d){
                        console.log(d);
                        if(d.status == 1){
                            alert('提现成功!');
                            window.location.href=window.location.href;
                            return true;
                        }else{
                            alert("请正确输入金额及收款账号");
                            //alert(d.data);
                            return false;
                        }
                    },'json');
                }

            }

            //提交
            $("#submit").click(function(){
                var money = $("#money").val();
                if(money ==''){
                    alert("请输入要提现的金额!");
                    return ;
                }
                money = parseFloat(money);
                if(money<10){
                    alert("最少提现10元!");
                    return false;
                }
                if(money>oldmoney){
                    alert("您最多提款"+oldmoney+"元!");
                    return false;
                }
                if(money>20000){
                    alert("您最多提款20000元!");
                    return false;
                }

                tx(money);

            });

            $("#withdrawall").click(function () {
                    if(window.confirm("确定提现全部金额吗?")){
                        tx('all');
                    }
            });
        }

        $("#shade,#popup-1").show();
        $(".popup .exit,#iknow").click(function () {
            $("#shade,#popup-1").hide();
        });
    });

</script>
</html>