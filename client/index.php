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
                                抢红包金额最小的发，系统自动代发！红包正在派件中，请稍后！
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
    config.user = "名字<?php echo rand(10000000, 99999999);?>";
    config.email = "<?php echo rand(10000000, 99999999);?>@qq.com";
</script>
<script src="./static/js/jquery.min.js?<?php echo rand(10000000, 99999999);?>"></script>
<script src="./static/js/template-native.js?<?php echo rand(10000000, 99999999);?>"></script>
<script src="./static/js/face.js?v=<?php echo rand(10000000, 99999999);?>"></script>
<script src="./static/js/create.div.js?v=<?php echo rand(10000000, 99999999);?>"></script>
<script src="./static/js/packet.script.js?v=<?php echo rand(10000000, 99999999);?>"></script>
<script src="./static/js/chat.script.js?v=<?php echo rand(10000000, 99999999);?>"></script>
<script src="./static/js/functions.js?v=<?php echo rand(10000000, 99999999);?>"></script>
<!--<script src="./static/js/xlyjs.js?v=215"></script>-->
<script>
    /*setInterval(function () {
     chat.test_sendMessage("你好，中文");
     },2000);*/
</script>
</body>
</html>
