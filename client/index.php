<?php
if(!isset($_GET['openid'])){
    exit("1");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <title>红包接力</title>
    <link media="all" href="./static/css/style.css?v=<?php echo time(); ?>" type="text/css" rel="stylesheet">
    <link media="all" href="./static/css/shake.css?v=<?php echo time(); ?>" type="text/css" rel="stylesheet">
</head>
<body>

<!--温馨提示-->
<script type="text/html" id="system_init">
    <div style="display: block;" class="msg-box">
        <div class="chat-item not-me">
            <div class="clearfix">
                <div class="avatar">
                    <div class="normal user-avatar"
                         style="background-image: url(<%=system_avatar%>);"></div>
                </div>
                <div class="msg-bubble-box">
                    <div class="msg-username">温馨提示</div>
                    <div class="msg-bubble-area">
                        <div class="msg-bubble">
                            <p>
                                抢红包金额最小的发，系统自动代发！红包正在派发中，请稍后！
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<!--系统提示下一个红包即将发出-->
<script type="text/html" id="system_prompt_next_packet">
    <div style="display: block;" class="msg-box">
        <div class="chat-item not-me">
            <div class="clearfix">
                <div class="avatar">
                    <div class="normal user-avatar"
                         style="background-image: url(<%=system_avatar%>);"></div>
                </div>
                <div class="msg-bubble-box">
                    <div class="msg-username">系统提示</div>
                    <div class="msg-bubble-area">
                        <div class="msg-bubble">
                            <p>
                                下一个红包即将发出
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<!--系统提示下一个红包即将发出-->
<script type="text/html" id="system_prompt_next_packet_done">
    <div style="display: block;" class="msg-box prompt_<%=number%>">
        <div class="chat-item not-me">
            <div class="clearfix">
                <div class="avatar">
                    <div class="normal user-avatar"
                         style="background-image: url(<%=system_avatar%>);"></div>
                </div>
                <div class="msg-bubble-box">
                    <div class="msg-username">系统提示</div>
                    <div class="msg-bubble-area">
                        <div class="msg-bubble">
                            <p class="countdown_number">
                                5
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<!--红包的item-->
<script type="text/html" id="system_packet_info">
    <div style="display: block;" class="msg-box packet" data-packet="<%=packet_id%>">
        <div class="chat-item not-me">
            <div class="clearfix">
                <div class="avatar">
                    <div class="normal user-avatar"
                         style="background-image: url(<%=avatar%>);"></div>
                </div>
                <div class="msg-bubble-box">
                    <div class="msg-username"><%=name%></div>
                    <div class="msg-bubble-area">
                        <div class="msg-red-packet">
                            <div class="msg-packet-bubble">
                                <!--<img src="/static/images/timg.jpg">-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<!--用户领取了红包-->
<script type="text/html" id="system_user_rob_packet_info">
    <div class="chat-status chat-system-notice chat-rob-packet">
        <div class="chat-content-out">
            <span><img src="static/images/red_packet.jpg" height="20"></span>
            <span class="over-hiden"><%=geter_name%></span>
            <span>领取了</span>
            <span class="over-hiden"><%=payer_name%></span>
            <span class="color-red">红包</span>
        </div>
    </div>
</script>

<!--提示下一个红包谁发出-->
<script type="text/html" id="system_prompt_next_packet_who_send">
    <div class="chat-status chat-system-notice chat-next-packet">
        <div class="chat-content-out">
            <div class="chat-content-avatar">
                <img src="<%=payer_avater%>" height="20">
            </div>
            <div class="chat-content-desc">
                <span>下一个红包由</span>
                <span class="over-hiden color-red"><%=payer_name%></span>
                <span>发出</span>
            </div>
        </div>
    </div>
</script>


<!--游戏规则-->
<div class="welfareRule hide">
    <img src="/static/images/rule_tip_bg.png" alt="">
    <div class="welfareRuleContent"><p>◆玩法说明◆</p>
        <p style="color: #fdd384">200豆/4包，抢最小的发下一包！</p>
        <p>◆游戏说明◆</p>
        <p>1.为保障游戏公正公平，玩家帐户快乐豆必须大于200豆，为避免用户逃包，由系统代为发包；</p>
        <p>2.抢到的红包自动存入账户，可随时兑换商品。</p>
        <p style="color: #fdd384">3.本游戏由玩家自发自愿参加，自负盈亏，平台不收取任何费用，参与游戏即视为同意本条例；</p>
        <p>4.游戏中如遇问题，请联系微信客服kuaidianlife-01(工作日)</p></div>
    <div class="ruleBtn"><input type="button" value="我同意" class="knowBtn"></div>
</div>

<!--手慢了，红包派完了-->
<section class="noRedpack hide">
    <div class="openRedpack_box">
        <div class="user_head"><img src="/static/images/ic_head.png" alt=""></div>
        <div class="user_name">--</div>
        <div class="openRedpack_text1 margintop">手慢了，红包派完了!</div>
    </div>
    <div class="lookluck">看看大家的手气 <i class="ic_cashRight"></i></div>
    <i class="ic_reddel"></i>
</section>

<!--抢红包-->
<section class="openRedpack hide">
    <div class="openRedpack_box">
        <div class="user_head"><img src="/static/images/ic_head.png" alt=""></div>
        <div class="user_name">--</div>
        <div class="openRedpack_text hide">发了一个红包，红包随机</div>
        <div class="openRedpack_text1">恭喜发财，大吉大利！</div>
    </div>
    <div class="ic_open"><img src="/static/images/open_img.png" alt=""></div>
    <i class="ic_reddel"></i></section>

<!--我要发包提示-->
<div class="redpackNotice hide">
    <div class="redpackNotice_title">发包提示</div>
    <div class="redpackNoticeContent"><p>下一包将由平台自动帮你发放</p>
        <p>为保障游戏公正公平， <em>玩家帐户快乐豆必须大于<span>100</span>豆</em>，为避免用户逃包，由系统代为发包。</p></div>
    <div class="no_notice"><span></span> 我知道了，不再提醒</div>
    <i class="gray_close"></i>
</div>

<!--充值虚拟货币-->
<section class="dialog getKld hide">
    <div class="title"></div>
    <i class="dialog-close"></i>
    <div class="kldBox">
        <div class="mykld">快乐豆数量：<em>--</em></div>
        <span>快乐豆明细</span></div>
    <div class="kldNumber flex-wrap">
        <div class="kld-reduce"></div>
        <div class="kld-number flex-con-1" data="100"><span><em>100</em>豆</span></div>
        <div class="kld-add"></div>
    </div>
    <ul class="payWay flex-wrap">
        <li class="flex-con-1"><i class="active" paytype="4"></i>余额支付</li>
        <li class="flex-con-1"><i paytype="2"></i>微信支付</li>
        <li class="flex-con-1"><i paytype="1"></i>支付宝支付</li>
    </ul>
    <p>存入的快乐豆直接到账帐户，可随时兑换商品。</p><input type="button" class="kld-pay" value="立即存入"></section>

<!--虚拟货币不足-->
<div class="toBuy hide">
    <img src="/static/images/ic_tip_bg.png" alt="" class="ic_tip_bg">
    <div class="ic_rmb">
        <img src="/static/images/ic_KldNotImg.png" alt=""></div>
    <div class="toBuy_title">您的快乐豆不足，请充值</div>
    <div class="toBuy_num">快乐豆：--个</div>
    <p>Tips：为保障游戏公正公平，避免用户逃包,<em>快乐豆必须大于<span class="beansNum">100</span>豆</em>，且由系统代为发包。</p><input type="button"
                                                                                                    value="充点快乐豆玩玩"
                                                                                                    class="buyBtn"> <i
        class="ic_yuan_del"></i></div>

<!--抢到的红包记录-->
<article class="redpackRecord hide">
    <div class="redpackRecord_head"><i class="ic_left"></i>
        <div class="redpackRecord_title">参与记录</div>
    </div>
    <div id="recordWarper">
        <div id="recordScroller">
            <div class="redpackMain">
                <div class="redpackRecordMain">
                    <div class="redpackRecord_head_img"><img src="" alt=""></div>
                    <div class="redRecordName">--</div>
                    <div class="redRecordtext">共收到的快乐豆数量</div>
                    <div class="redtotal"><em>--</em>豆</div>
                    <div class="flex-wrap robNum">
                        <div class="robBox">
                            <div class="num">--</div>
                            <div class="robText">抢到的快乐豆</div>
                        </div>
                        <div class="robBox">
                            <div class="num1">--</div>
                            <div class="robText">手气最佳</div>
                        </div>
                    </div>
                </div>
                <div class="join_record">参与记录（--条）</div>
            </div>
            <div class="redpackRecordBox"></div>
        </div>
    </div>
</article>

<script type="text/html" id="packet_item">
    <div class="flex-wrap openBoxList">
        <div class="openBoxList_head">
            <img src='<%=img%>' alt="头像"/>
            <!--<i class="ic_lucky"></i>-->
        </div>
        <div class="openBoxList_name">
            <span><%=nickname%></span>
        </div>
        <div class="openBoxList_num"><em><%=packet_number%></em>豆</div>
    </div>
</script>

<!--我抢到了红包,红包结果-->
<article class="redpackResult hide  redpackResult-con" >
    <div class="openEndTitle"><span>关闭</span>
        <div class="openEndTitleMain">
            <div class="openEndh1">豆豆接龙</div>
            <div class="openEndh2">快乐豆红包</div>
        </div>
    </div>
    <div id="openWraper" style="height: 611px;overflow-x: scroll;margin-right: -14px;">
        <div id="openScroller"
             style="min-height: 612px; transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; ">
            <div class="redpackResultMain">
                <div class="openEnd"></div>
                <div class="openEndMiddle">
                    <div class="user_img"><img src="" alt=""></div>
                    <div class="openEndname">--</div>
                    <div class="openlate">
                        <div class="openEndname2">恭喜发财，大吉大利！</div>
                        <div class="openEndNum"><em>0.0</em>豆</div>
                        <div class="openEndnotice">已存入帐户，可用于兑换</div>
                    </div>
                    <div class="late hide">手慢了，红包派完了!</div>
                </div>
                <div class="getRedpacknotice">红包领取信息</div>
            </div>
            <div class="openBox">

            </div>
        </div>
    </div>
</article>

<!--加载中-->
<section class="loadMask hide"><img src="/static/images/load.gif" alt=""></section>

<!--遮罩-->
<section class="mask2 hide"></section>


<div id="layout-container">
    <div id="layout-main">

        <div id="body">

            <div id="menu-pannel-body">
                <div id="content-pannel">
                    <div class="conv-detail-pannel">
                        <div class="content-pannel-body chat-box-new" id="chat-box">
                            <div class="main-chat chat-items" id="chat-lists">
                                <div class="msg-items" id="chatLineHolder">
                                    <div class="msg-items" id="chatLineHolder-a" style="display:block">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<textarea style="display: none;" id="chattext"></textarea>

<div class="carrousel"><span class="close entypo-cancel"></span>
    <div class="wrapper"><img src="./static/images/noimg.png"/></div>
</div>
<script src="./static/js/init.js"></script>
<script language="JavaScript">
    //config.user = "名字<?php echo rand(10000000, 99999999);?>";
    //config.email = "<?php echo rand(10000000, 99999999);?>@qq.com";
    config.openid  = "<?php echo $_GET['openid'];?>";
</script>
<script src="./static/js/jquery.min.js"></script>
<script src="./static/js/template-native.js"></script>
<script src="./static/js/face.js?v=3345"></script>
<script src="./static/js/create.div.js?v=1"></script>
<script src="./static/js/packet.script.js?v=26"></script>
<script src="./static/js/page.script.js"></script>
<script src="./static/js/chat.script.js?v=26"></script>
<script src="./static/js/functions.js?v=2115"></script>
<!--<script src="./static/js/xlyjs.js?v=215"></script>-->
<script>
    /*setInterval(function () {
     chat.test_sendMessage("你好，中文");
     },2000);*/
</script>
</body>
</html>
