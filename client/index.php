<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <title>公共聊天室</title>
    <link media="all" href="./static/css/style.css?v=2222" type="text/css" rel="stylesheet">
    <link media="all" href="./static/css/shake.css?v=2222" type="text/css" rel="stylesheet">
</head>
<body>
<div id="layout-container">
    <div id="layout-main">

        <div id="body">

            <div id="menu-pannel-body">
                <!--<div id="sub-menu-pannel" class="conv-list-pannel">
                    <div class="conv-lists-box" id="user-lists">
                        <div class="conv-lists" id="conv-lists"></div>
                    </div>
                </div>-->
                <div id="content-pannel">
                    <div class="conv-detail-pannel">
                        <!--<div class="nocontent-logo" style="display:none;" >
                            <div>
                                <img alt="欢迎" src="./static/images/noimg.png">
                            </div>
                        </div>-->
                        <div class="content-pannel-body chat-box-new" id="chat-box">
                            <div class="main-chat chat-items" id="chat-lists">
                                <div class="msg-items" id="chatLineHolder">
                                    <div class="msg-items" id="chatLineHolder-a" style="display:block">
                                        <div style="display: block;" class="msg-box">
                                            <div class="chat-item me">
                                                <div class="clearfix">
                                                    <div class="avatar">
                                                        <div class="normal user-avatar"
                                                             style="background-image: url(http://chat.codeception.cn/static/images/avatar/f1/f_6.jpg);"></div>
                                                    </div>
                                                    <div class="msg-bubble-box">
                                                        <div class="msg-bubble-area">
                                                            <div>
                                                                <div class="msg-bubble">
                                                                    <pre class="text">123</pre>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat-status chat-system-notice">系统消息：欢迎&nbsp;名字85145537&nbsp;加入群聊
                                        </div>
                                        <div style="display: block;" class="msg-box">
                                            <div class="chat-item not-me">
                                                <div class="clearfix">
                                                    <div class="avatar">
                                                        <div class="normal user-avatar"
                                                             style="background-image: url(http://chat.codeception.cn/static/images/avatar/f1/f_6.jpg);"></div>
                                                    </div>
                                                    <div class="msg-bubble-box">
                                                        <div class="msg-bubble-area">
                                                            <div class="msg-red-packet">
                                                                <div class="msg-bubble">
                                                                    <img src="static/images/timg.jpg">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div>
                            <!--<div class="send-msg-box-wrapper">
                                <div class="input-area" style="display:none;">
                                    <ul class="tool-bar">
                                        <li class="tool-item">
                                            <i class="iconfont tool-icon tipper-attached emotion_btn" title="表情"></i>
                                            <div class="faceDiv"></div>
                                        </li>
                                        <li class="tool-item">
                                            <i class="iconfont tool-icon icon-card tipper-attached" onclick="upload()" title="图片"></i>
                                        </li>
                                    </ul>
                                    <span class="user-guide">Enter 发送 , Ctrl+Enter 换行</span>
                                    <div class="msg-box" style="height:100%;">
                                        <textarea class="textarea input-msg-box" onkeydown="chat.keySend(event);" id="chattext"></textarea>
                                    </div>
                                </div>
                                <div class="action-area" style="display:none;">
                                    <a href="javascript:;" class="send-message-button" onclick="chat.sendMessage()">发送</a>
                                </div>
                                <div id="loginbox" class="area" style="width:100%;text-align:center;display:block;">
                                    <form action="javascript:void(0)" onsubmit="return chat.doLogin('','');">
                                        <div class="clearfix" style="margin-top:35px">
                                            <input name="name" id="name" style="margin-right:20px;width:250px;" placeholder="请输入昵称" class="fm-input" value="" type="text">
                                            <input id="email" class="fm-input" style="margin-right:20px;width:250px;" name="email" placeholder="请输入Email" type="text">
                                            <button type="submit" class="blue big">登录</button>
                                        </div>

                                    </form>
                                </div>
                            </div>-->
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
<script src="./static/js/jquery.min.js"></script>
<script src="./static/js/face.js?v=3345"></script>
<script src="./static/js/create.div.js?v=1"></script>
<script src="./static/js/chat.script.js?v=26"></script>
<script src="./static/js/functions.js?v=2115"></script>
<script src="./static/js/xlyjs.js?v=215"></script>
<script>
    /*setInterval(function () {
        chat.test_sendMessage("你好，中文");
    },2000);*/
</script>
</body>
</html>
