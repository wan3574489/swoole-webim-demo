function initIsrcoll() {
    $("#wrapper").height($("body").height() - $(".activity_time").height() - $(".header").height() - $(".footer").height() - 50), $("#scroller").css("min-height", $("#wrapper").height() + 1), myScroll = new IScroll("#wrapper", {
        scrollbars: !1,
        vScrollbar: !1,
        click: !0,
        scrollX: !0,
        probeType: 3,
        mouseWheel: !0
    }), document.addEventListener("touchmove", function (e) {
        e.preventDefault()
    }, !1)
}
function initIsrcoll1() {
    $("#openWraper").height($("body").height() - $(".openEndTitle").height()), $("#openScroller").css("min-height", $("#openWraper").height() + 1), myScroll1 = new IScroll("#openWraper", {
        scrollbars: !1,
        vScrollbar: !1,
        click: !0,
        scrollX: !0,
        probeType: 3,
        mouseWheel: !0
    }), document.addEventListener("touchmove", function (e) {
        e.preventDefault()
    }, !1)
}
function initIsrcoll2() {
    $("#recordWarper").height($("body").height() - $(".redpackRecord_head").height()), $("#recordScroller").css("min-height", $("#recordWarper").height() + 1), myScroll2 = new IScroll("#recordWarper", {
        scrollbars: !1,
        vScrollbar: !1,
        click: !0,
        scrollX: !0,
        probeType: 3,
        mouseWheel: !0
    }), document.addEventListener("touchmove", function (e) {
        e.preventDefault()
    }, !1)
}
function randomCashBubble(e) {
    $.ajax({
        type: "post",
        data: {roomType: e},
        dataType: "json",
        url: "/rd-portal/redpackRoom/randomCashBubble",
        cache: !1,
        success: function (e) {
            var o = e.msgCode;
            if (200 == o) {
                var a = e.roomId, n = e.url;
                localStorage.setItem("kld_room", n), localStorage.setItem("kld_room_id", a), cashWebSocket()
            }
        }
    })
}
var tool = 1, sw = 0, sw1 = 0, propId, sw2 = 0, type = 3, roomType, myScroll = {}, myScroll1 = {}, myScroll2 = {};
$(function () {
    initIsrcoll(), initIsrcoll1(), type = localStorage.getItem("type"), roomType = localStorage.getItem("roomType"), null != type && "" != type && void 0 != type || (type = 3), null != roomType && "" != roomType && void 0 != roomType || (roomType = 13), 1 == type ? ($(".kld_scroller li").removeClass("kldactive"), $(".kld_scroller li").eq(0).addClass("kldactive"), $(".beansNum").html("20"), $(".redpackNoticeContent p span").html("20"), randomCashBubble(roomType)) : 2 == type ? ($(".kld_scroller li").removeClass("kldactive"), $(".kld_scroller li").eq(0).addClass("kldactive"), $(".beansNum").html("50"), $(".redpackNoticeContent p span").html("50"), randomCashBubble(roomType)) : 3 == type ? ($(".kld_scroller li").removeClass("kldactive"), $(".kld_scroller li").eq(1).addClass("kldactive"), $(".beansNum").html("100"), $(".redpackNoticeContent p span").html("100"), randomCashBubble(roomType)) : 4 == type && ($(".kld_scroller li").removeClass("kldactive"), $(".kld_scroller li").eq(2).addClass("kldactive"), $(".beansNum").html("200"), $(".redpackNoticeContent p span").html("200"), randomCashBubble(roomType)), $(".kld_scroller li").bind("tap", function () {
        type = $(this).attr("type"), 2 == type ? localStorage.setItem("roomType", "12") : 3 == type ? localStorage.setItem("roomType", "13") : 4 == type && localStorage.setItem("roomType", "14"), localStorage.setItem("type", type), window.location.reload()
    }), $(".kldShop").bind("tap", function () {
        sessionStorage.setItem("kldShop", "redpackKld"), location.href = "../../views/kldShop/kldShop.html"
    }), $(document).on("tap", ".record_main img", function () {
        $(this).parent().parent().find(".infoBox").toggleClass("expandUp hide")
    }), $(".qd_btn").bind("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn").addClass("hide")
    }), $("#confirm").bind("tap", function () {
        if (0 == sw2) {
            sw2 = 1;
            var e = 1;
            buyTool(propId, e)
        }
    }), $(document).on("tap", ".lookfirstBag", function () {
        $(".mask2").show(), $(".toolShop").removeClass("hide").addClass("bounceIn"), toolShop()
    }), $(document).on("tap", ".textColor", function () {
        0 == _propIdStatus || void 0 == _propIdStatus || null == _propIdStatus
    }), $(".payWay li").bind("tap", function () {
        $(".payWay li").find("i").removeClass("active"), $(this).find("i").addClass("active")
    }), $(".lock").bind("tap", function () {
        return dialog.gray("敬请期待", 1500), !1
    }), $(".moreOptions li").bind("tap", function () {
        $(".moreOptions li").each(function (e) {
            this.index = e
        }), 0 == this.index ? ($(".mask2").show(), $(".welfareRule").removeClass("bounceOutUp hide").addClass("bounceIn")) : 1 == this.index ? (console.log("old" + history.length), $(".main").addClass("hide"), $(".redpackRecord").show(), history.pushState(null, "", "cashRedpack.html#record"), redpackRedcord(), redpackRank(1), initIsrcoll2()) : 2 == this.index ? dialog.gray("敬请期待", 1500) : 3 == this.index && (location.href = "../../views/index.html")
    }), window.onpopstate = function () {
        $(".redpackRecord").hide(), $(".main").removeClass("hide"), $(".redpackResult").hide()
    }, $(".ic_left").click(function () {
        window.history.back()
    }), $("#goGet").bind("tap", function () {
        $(".noBeans").removeClass("bounceIn").addClass("hide"), $(".getKld").removeClass("hide").addClass("bounceIn")
    }), $(".cancel").bind("tap", function () {
        $(".toolShop").removeClass("hide").addClass("bounceIn"), $(".againConfirm").removeClass("bounceIn").addClass("hide"), $(".noBeans").removeClass("bounceIn").addClass("hide")
    }), $(document).on("tap", ".exchangeBean", function () {
        propId = $(this).attr("propId");
        var e = $(this).find("i").html(), o = localStorage.getItem("openid");
        if ($.inArray(o, testArr) != -1) {
            if (1 == propId)dialog.gray("暂未开放哦！", 2e3); else if (2 == propId)dialog.gray("暂未开放哦！", 2e3); else if (3 == propId) {
                var a = $(".mybeans em").html();
                Number(a) >= Number(e) ? ($(".toolShop").removeClass("bounceIn").addClass("hide"), $(".againConfirm").removeClass("hide").addClass("bounceIn"), $(".againConfirm p").html("购买将花费" + e + "快乐豆")) : ($(".toolShop").removeClass("bounceIn").addClass("hide"), $(".noBeans").removeClass("hide").addClass("bounceIn"))
            }
        } else dialog.gray("暂未开放哦！", 2e3)
    }), $(".mybeans span:nth-child(2)").bind("tap", function () {
        location.href = "beansDetails.html"
    }), $(".ic_left_del").on("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn").addClass("hide")
    }), $(".ic_yuan_del,.dialog-close,.noCard_yesBtn,.ic_cafei_del").on("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn").addClass("hide")
    }), $(document).on("tap", ".ic_about", function () {
        $(this).parent().parent().find(".infoBox").toggleClass("expandUp hide")
    }), $(".ic_detele").bind("tap", function () {
        $(".mask2").hide(), $(".toolShop").removeClass("bounceIn").addClass("hide")
    }), $(".ic_tool").bind("tap", function () {
        0 == tool ? ($(".mask2").show(), $(".toolShop").removeClass("hide").addClass("bounceIn"), toolShop()) : dialog.gray("敬请期待", 1500)
    }), $(".ic_options").on("tap", function () {
        var e = $(".moreOptions");
        e.hasClass("hide") ? (e.removeClass("hide"), e.addClass("pullUp")) : (e.addClass("hide"), e.removeClass("pullUp"))
    }), $(".kld-add").bind("tap", function () {
        var e = $(".kld-number em");
        e.html() >= 1e4 ? dialog.gray("最大充值不超过10000豆哦！", 2e3) : e.html(Number(e.html()) + 100)
    }), $(".kld-reduce").bind("tap", function () {
        var e = $(".kld-number em");
        e.html() > 100 ? e.html(Number(e.html()) - 100) : dialog.gray("至少充值100豆哦！", 2e3)
    }), $(".kldBox span").bind("tap", function () {
        location.href = "../../views/balanceDetailed.html"
    }), $(".balance span").bind("tap", function () {
        var e = navigator.userAgent, o = $(".kld-number em").html();
        e.indexOf("Android") > -1 || e.indexOf("Linux") > -1 ? ($(".payWay li").eq(1).removeClass("hide"), useramount < Number(o) / 10 && ($(".payWay li").find("i").removeClass("active"), $(".payWay li").eq(1).find("i").addClass("active"))) : ($(".payWay li").eq(1).addClass("hide"), useramount < Number(o) / 10 && ($(".payWay li").find("i").removeClass("active"), $(".payWay li").eq(2).find("i").addClass("active"))), $(".mask2").show(), $(".getKld").removeClass("hide").addClass("bounceIn")
    }), $(document).on("tap", ".openBoxList", function () {
        var e = $(this).attr("userCode");
        location.href = "personalData.html?userCode=" + e
    }), $(".lookBtn").bind("tap", function () {
        $(".toBuy").removeClass("bounceIn").addClass("hide"), $(".mask2").hide(), $(".redpackResult").show(), $(".main").addClass("hide");
        var e = sessionStorage.getItem("redpackType"), o = sessionStorage.getItem("period"), a = 1;
        3 == e ? torank(o, a) : 4 == e && torankWelfare(o, a)
    }), $(".backBox").bind("tap", function () {
        var e = sessionStorage.getItem("redpackKld");
        "" == e || null == e ? location.href = "../../views/index.html" : location.href = "../../views/" + e + ".html"
    }), $(document).on(".openBoxList", function () {
        var e = $(this).attr("userCode");
        location.href = "personalData.html?userCode=" + e
    }), $(document).on("input propertychange", "#input_info", function () {
        var e = $("#input_info").val();
        e.length > 0 || "" != e ? ($(".sendInfo").show(), $(".ic_more").hide()) : ($(".sendInfo").hide(), $(".ic_more").show())
    }), $(".lookluck").bind("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn").addClass("hide"), $(".main").addClass("hide"), $(".redpackResult").show(), history.pushState(null, "", "cashRedpack.html#luck"), $(".openlate").hide(), $(".late").show();
        var e = 1, o = sessionStorage.getItem("redpackType"), a = sessionStorage.getItem("period");
        3 == o ? ($(".openEndh2").html("快乐豆红包"), $(".openEnd").css("background", "no-repeat center url(../images/redpackKld/open_bg.png)"), $(".openEnd").css("background-size", "100%"), $(".openEndTitle").css("background", "#FF2739"), torank(a, e)) : 4 == o && ($(".openEndh2").html("系统福利包"), $(".openEnd").css("background", "no-repeat center url(../images/redpackKld/openYellow_bg.png)"), $(".openEnd").css("background-size", "100%"), $(".openEndTitle").css("background", "#EDBD4F"), torankWelfare(a, e), initIsrcoll1())
    }), $(".ic_group").bind("tap", function () {
        location.href = "groupInfo.html"
    }), $(".knowBtn").bind("tap", function () {
        $(".mask2").hide(), $(".welfareRule").removeClass("bounceIn hide").addClass("bounceOutUp")
    }), $(".gray_close").bind("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn hide").addClass("bounceOutUp")
    }), $(document).on("click", ".redpackBox", function () {
        var e = $(this).attr("redpackType");
        if (0 == sw) {
            sw = 1, sessionStorage.setItem("redpackType", e);
            var o = $(this).attr("period");
            sessionStorage.setItem("period", o);
            var a = 1;
            3 == e ? (torank(o, a), rob(o)) : 4 == e && (torankWelfare(o, a), robWelfare(o))
        }
    }), $(".ic_reddel").bind("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn hide").addClass("bounceOutUp")
    }), $(".openEndTitle span").click(function () {
        $(".openlate").show(), $(".late").hide(), $(".redpackResult").hide(), window.history.back()
    }), $(".ic_more").bind("tap", function () {
        userCash();
        var e = $(".toMoney").css("position");
        $(".ic_more").toggleClass("rotate45"), "fixed" == e ? ($(".toMoney").css("position", "relative"), $(".toMoney").slideToggle("hide")) : "relative" == e && $(".toMoney").slideToggle("hide")
    }), $(".tomoneyBtn").bind("tap", function () {
        $(".mask2").show(), $(".getKld").removeClass("bounceOutUp hide").addClass("bounceIn")
    }), $(".buyBtn").bind("tap", function () {
        var e = navigator.userAgent, o = $(".kld-number em").html();
        e.indexOf("Android") > -1 || e.indexOf("Linux") > -1 ? ($(".payWay li").eq(1).removeClass("hide"), useramount < Number(o) / 10 && ($(".payWay li").find("i").removeClass("active"), $(".payWay li").eq(1).find("i").addClass("active"))) : ($(".payWay li").eq(1).addClass("hide"), useramount < Number(o) / 10 && ($(".payWay li").find("i").removeClass("active"), $(".payWay li").eq(2).find("i").addClass("active"))), $(".toBuy").removeClass("bounceIn").addClass("hide"), $(".getKld").removeClass("bounceOutUp hide").addClass("bounceIn")
    }), $(".ic_del").bind("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn hide").addClass("bounceOutUp")
    }), $(".no_notice").bind("tap", function () {
        $(".no_notice span").addClass("add_yes"), $(".redpackNotice").removeClass("bounceIn hide").addClass("bounceOutUp"), $(".mask2").hide(), k = 1
    }), $(".newRedpack").bind("tap", function () {
        isrcoll.onScrollTo_2(), setTimeout(function () {
            $(".newRedpack").fadeOut()
        }, 1e3)
    }), $(".okBtn").bind("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn hide").addClass("bounceOutUp")
    }), $(".red_close").bind("tap", function () {
        $(".mask2").hide(), $(this).parent().removeClass("bounceIn hide").addClass("bounceOutUp")
    })
});


function cashWebSocket() {
    var e = localStorage.getItem("kld_room"), s = localStorage.getItem("kld_room_id");
    ws = new WebSocket("ws://" + e + "/ws-cashBubble/room/" + s + "/" + openId), ws.onopen = function () {
        console.log("会话创建" + e + "房间号" + s), interval = setInterval(function () {
            keepalive()
        }, 3e4), intoRoom("")
    }, ws.onclose = function () {
        console.log("会话关闭"), clearInterval(interval)
    }, ws.onerror = function (e) {
        console.log("错误：" + e)
    }, ws.onmessage = function (e) {
        if (sign != e.data) {
            var s = JSON.parse(e.data), a = s.businessCode;
            "601" == a ? getCountDown(s) : "602" == a || ("603" == a ? lookRank(s) : "604" == a ? robResult(s) : "605" == a ? getRedpackInfo(s) : "606" == a ? cashRedpackRule(s) : "607" == a ? nextSendRedpacket(s) : "608" == a || ("609" == a ? system(s) : "610" == a ? sendRedpack(s) : "611" == a ? sendMessage(s) : "612" == a ? getRedpack(s) : "613" == a ? userBalance(s) : "614" == a || ("615" == a ? RedbagCord(s) : "616" == a ? redbagRank(s) : "617" == a ? nextPerson(s) : "618" == a ? userInfo(s) : "619" == a ? userWinInfo(s) : "620" == a ? userGold(s) : "621" == a ? lookfirstBag(s) : "622" == a ? goTool(s) : "623" == a ? toolInfoList(s) : "624" == a ? toolList(s) : "625" == a ? userToolList(s) : "626" == a ? getTool(s) : "627" == a && showAmount(s))))
        }
    }
}
function keepalive() {
    ws.send(sign)
}
function rob(e) {
    var s = '{"businessCode":"501","data":{"period":"' + e + '"}}';
    ws.send(s)
}
function torank(e, s) {
    var a = '{"businessCode":"502","data":{"period":"' + e + '","currentPage":"' + s + '"}}';
    ws.send(a)
}
function intoRoom(e) {
    var s = '{"businessCode":"503","data":{"period":"' + e + '"}}';
    ws.send(s)
}
function robWelfare(e) {
    var s = '{"businessCode":"505","data":{"period":"' + e + '"}}';
    ws.send(s)
}
function torankWelfare(e, s) {
    var a = '{"businessCode":"506","data":{"period":"' + e + '","currentPage":"' + s + '"}}';
    ws.send(a)
}
function send(e) {
    var s = '{"businessCode":"507","data":{"content":"' + e + '"}}';
    ws.send(s)
}
function redpackRedcord() {
    var e = '{"businessCode":"508","data":{}}';
    ws.send(e)
}
function redpackRank(e) {
    var s = '{"businessCode":"509","data":{"currentPage":"' + e + '"}}';
    ws.send(s)
}
function userCash() {
    var e = '{"businessCode":"510","data":{}}';
    ws.send(e)
}
function toolShop() {
    var e = '{"businessCode":"512","data":{}}';
    ws.send(e)
}
function buyTool(e, s) {
    var a = '{"businessCode":"513", "data":{"propId":' + e + ',"propCount":"' + s + '"}}';
    ws.send(a)
}
function userInfo(e) {
    var s = (e.amount, e.sycee);
    $(".balance span").html(parseFloat(s).toFixed(1)), $(".toBuy_num").html("当前快乐豆：" + parseFloat(s).toFixed(1) + "豆")
}
function showAmount(e) {
    var s = (e.amount, e.sycee);
    $(".balance span").html(parseFloat(s).toFixed(1)), $(".mykld em").html(parseFloat(s).toFixed(1)), $(".toBuy_num").html("快乐豆" + parseFloat(s).toFixed(1) + "个"), $(".cashmoveTop").html("+" + parseFloat(beans).toFixed(1)), $(".cashmoveTop").addClass("amontAddMove"), setTimeout(function () {
        $(".cashmoveTop").removeClass("amontAddMove")
    }, 4e3)
}
function userGold(e) {
    var s = e.goldNum;
    $(".noDieBar em").html("x" + s), $(".my-noDie-num em").html(s)
}
function getCountDown(e) {
    var s = e.totalTime, a = e.time;
    e.nextTime, e.currentTime;
    $(".activity_time em:nth-of-type(1)").html(s + "分钟"), timing(a)
}
function joinRoomInfo(e) {
    var s = e.text, a = e.level, o = (e.time, "");
    o += 0 == a ? '<div class="join_person">' + s + "加入了超级大富翁</div>" : '<div class="join_person"> <i class="ic_mark"></i><em>' + s + "</em> 加入了超级大富翁</div>", $(".joinBox").append(o);
    var i = sessionStorage.getItem("totalNum");
    sessionStorage.setItem("totalNum", Number(i) + 1);
    var i = sessionStorage.getItem("totalNum");
    $(".black_head_title").html("超级大富翁（" + i + "）"), isrcoll.onCompletion(myScroll3);
    var t = $("#joinWrapper").height(), n = $("#joinScroller").height();
    "" != myScroll3 && null != myScroll3 && n > t + 2 && myScroll3.scrollTo(0, -n + t - 35, 800, IScroll.utils.ease.circular)
}
function nextPerson(e) {
    var s = e.userCode, a = sessionStorage.getItem("userCode"), o = $(".openResult").css("display");
    a == s && 0 == k && "none" == o && ($(".mask2").show(), $(".redpackNotice").removeClass("bounceOutUp hide").addClass("bounceIn"))
}
function userBalance(e) {
    var s = e.amount, a = e.userCode, o = e.userImage, i = e.userName, t = e.status, n = e.sycee;
    useramount = s, sessionStorage.setItem("userName", i), sessionStorage.setItem("userImage", o), sessionStorage.setItem("userCode", a), $(".mykld em").html(parseFloat(n).toFixed(1)), $(".mybeans em").html(parseFloat(n).toFixed(1)), $(".banlance em").html(parseFloat(s).toFixed(1)), $(".toBuy_num").html("当前快乐豆：" + parseFloat(n).toFixed(1) + "豆"), $(".balance span").html(parseFloat(n).toFixed(1)), 3 == t ? ($(".input_info").attr("disabled", "disabled"), $(".input_info").attr("placeholder", "禁言！")) : ($(".input_info").attr("disabled", !1), $(".input_info").attr("placeholder", "")), s < 10 ? $(".toMoney_notice").show() : $(".toMoney_notice").hide();
    var d = e.isRecharge;
    d || $(".kld-number em").html("100")
}
function userNum(e) {
    var s = e.totalNum;
    sessionStorage.setItem("totalNum", s), $(".black_head_title").html("超级大富翁（" + s + "）")
}
function getRoomMessage(e) {
    var s = e.list, a = "";
    $(s).each(function (e, s) {
        var o = s.alias, i = s.userImage, t = (s.level, s.content), n = s.userCode, d = sessionStorage.getItem("userCode");
        n == d ? (a += '<div class="userInfo clearfix">', a += '<div class="userInfo_left">', a += "<span></span>", a += "<span></span>", a += '<div class="usertext">' + t + "</div>", a += "</div>", a += '<div class="userInfo_right"><img src="../' + i + '" alt=""/></div>', a += "</div>") : (a += '<div class="flex-wrap otheruserInfo">', a += '<div class="otherUser_right"><img src="../' + i + '" alt=""/></div>', a += '<div class="otheruserInfoContent">', a += '<div class="userName">' + o + "</div>", a += '<div class="otherUser_left ">', a += "<span></span>", a += "<span></span>", a += '<div class="usertext">' + t + "</div>", a += "</div>", a += "</div>", a += "</div>")
    }), $(".cashBox").append(a), isrcoll.onCompletion(myScroll), isrcoll.getForBottomOffset() ? (isrcoll.onScrollTo(), $(".goBottom").fadeOut()) : $(".goBottom").fadeIn()
}
function getRedpack(e) {
    var s = e.userName, a = e.userCode, o = e.level, t = e.sendUserName, n = e.firstRobPack, d = sessionStorage.getItem("userCode"), l = "";
    1 == n ? (i++, d == a ? 0 == o ? t.length > 6 ? s == t ? (l += '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>我</em>领取了我的<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : (l += '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>我</em>领取了' + t.substring(0, 6) + '...<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : s == t ? (l += '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>我</em>领取了我的<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : (l += '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>我</em>领取了' + t + '<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : t.length > 6 ? s == t ? (l += '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em>我</em>领取了' + t.substring(0, 6) + '...<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : (l += '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">我</em>领取了' + t.substring(0, 6) + '...<span class="textColor">红包</span>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : s == t ? (l += '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em>我</em>领取了' + t + '<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : (l += '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">我</em>领取了' + t + '<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : 0 == o ? t.length > 6 ? (l += '<div class="getRedpack"><i class="ic_getRedpack"></i> <em class="redcolor">' + s + "</em>领取了" + t.substring(0, 6) + '...<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : (l += '<div class="getRedpack"><i class="ic_getRedpack"></i> <em class="redcolor">' + s + "</em>领取了" + t + '<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : t.length > 6 ? (l += '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">' + s + "</em>领取了" + t.substring(0, 6) + '...<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>") : (l += '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">' + s + "</em>领取了" + t + '<a class="textColor">红包</a>', l += '<div class="lookfirstBag hide">使用“首包查看卡”，可查看红包金额哦～ <em>点击获得></em><span></span></div>', l += '<div class="firstBagAmountBox_' + i + '"></div>', l += "</div>")) : l += d == a ? 0 == o ? t.length > 6 ? s == t ? '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>我</em>领取了我的<span>红包</span> </div>' : '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>我</em>领取了' + t.substring(0, 6) + "...<span>红包</span> </div>" : s == t ? '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>我</em>领取了我的<span>红包</span> </div>' : '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>我</em>领取了' + t + "<span>红包</span> </div>" : t.length > 6 ? s == t ? '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">我</em>领取了我的<span>红包</span> </div>' : '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">我</em>领取了' + t.substring(0, 6) + "...<span>红包</span> </div>" : s == t ? '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">我</em>领取了我的<span>红包</span> </div>' : '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">我</em>领取了' + t + "<span>红包</span> </div>" : 0 == o ? t.length > 6 ? '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>' + s + "</em>领取了" + t.substring(0, 5) + "...<span>红包</span> </div>" : '<div class="getRedpack"><i class="ic_getRedpack"></i> <em>' + s + "</em>领取了" + t + " <span>红包</span> </div>" : t.length > 6 ? '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">' + s.substring(0, 6) + "领取了</em>" + t + "...<span>红包</span> </div>" : '<div class="getRedpack"><i class="ic_mark"></i><i class="ic_getRedpack"></i> <em class="redcolor">' + s + "领取了</em>" + t + " <span>红包</span> </div>", $(".cashBox").append(l), isrcoll.onCompletion(myScroll), isrcoll.getForBottomOffset() ? (isrcoll.onScrollTo(), $(".goBottom").fadeOut()) : $(".goBottom").fadeIn()
}
function userWinInfo(e) {
    var s = e.userName, a = e.userImage, o = e.userAmount, i = e.winTypeName, t = e.userCode, n = localStorage.getItem("userCode"), d = "";
    d += '<div class="reward">', d += '<div class="reward_img"><img src="' + a + '" alt=""/></div>', d += '<div class="reward_text">', d += n == t ? s.length > 5 ? '<div class="reward_text1">恭喜你中<em>"' + i.substring(0, 3) + '"</em></div>' : '<div class="reward_text1">恭喜你中<em>"' + i.substring(0, 3) + '"</em></div>' : s.length > 5 ? '<div class="reward_text1">恭喜"' + s.substring(0, 5) + '"..中 <em>"' + i.substring(0, 3) + '"</em></div>' : '<div class="reward_text1">恭喜"' + s + '"中 <em>"' + i.substring(0, 3) + '"</em></div>', d += '<div class="reward_text2">获得 <em>' + parseFloat(o).toFixed(2) + "</em> <span>个</span>快乐豆奖励 </div>", d += "</div>", d += "</div>", $(".cashBox").append(d), isrcoll.onCompletion(myScroll), isrcoll.getForBottomOffset() ? (isrcoll.onScrollTo(), $(".goBottom").fadeOut()) : $(".goBottom").fadeIn()
}
function getRedpackInfo(e) {
    var s = (e.amount, e.totalNum, e.time, e.robAmount, e.redpackName), a = e.redpackImage, o = e.redpackType;
    $(".openEndname").html(s), $(".user_img img").attr("src", a), $(".fromWhere").html("来自" + s), 3 == o ? ($(".user_head img").attr("src", a), $(".user_name").html(s)) : 4 == o && $(".user_head img").attr("src", "../images/cashRedpack/ic_head.png")
}
function lookRank(e) {
    var s = e.redpackType, a = "", o = e.list, i = e.totalNum, t = e.period, n = 0, d = 0;
    $(o).each(function (e, s) {
        var o = s.alias,
            i = s.userImage,
            t = s.level,
            l = s.amount,
            c = (s.time, s.userCode),
            r = localStorage.getItem("userCode");

        r == c &&
        ($(".openlate").show(),
            $(".late").hide(),
            $(".openEndNum em").html(parseFloat(l).toFixed(1))), Number(l) > Number(d) && (n = e, d = l),
            a += '<div class="flex-wrap openBoxList" userCode="' + c + '" >',
            a += '<div class="openBoxList_head"><img src="' + i + '" alt=""/></div>',
            a +=
                0 == t ? o.length >= 8 ? '<div class="openBoxList_name"><span>' + o.substring(0, 8) + "...</span></div>" : '<div class="openBoxList_name"><span>' + o + "</span></div>" : o.length >= 8 ? '<div class="openBoxList_name"><span>' + o.substring(0, 8) + '...</span><i class="ic_vip"></i></div>' : '<div class="openBoxList_name"><span>' + o + '</span><i class="ic_vip"></i></div>',
            a += '<div class="openBoxList_num"><em>' + parseFloat(l).toFixed(1) + "</em>豆</div>",
            a += "</div>"
    });
    var l = sessionStorage.getItem("period");
    l == t && ($(".openBox").html(a), $(".openBoxList").eq(n).append('<i class="ic_lucky"></i>'), 3 == s ? i <= 4 && $(".getRedpacknotice").html("已领了" + i + "个红包(共4个红包)") : 4 == s && $(".getRedpacknotice").html("已领了" + i + "个红包。")), isrcoll.onCompletion(myScroll1)
}
function robResult(e) {
    var s = e.redpackType, a = e.msgCode, o = e.amount, i = e.robNum, t = e.robed;
    beans = o, $(".openNum em").html(parseFloat(o).toFixed(1)), $(".welfareBag_num").html("可抢次数：" + i + "次"), 3 == s ? 200 == a ? 0 == t ? ($(".mask2").show(), $(".openRedpack").removeClass("bounceOutUp hide").addClass("bounceIn"), $(".ic_open").addClass("change"), setTimeout(function () {
        robsuccess(o), sw = 0
    }, 1500)) : ($(".main").addClass("hide"), $(".redpackResult").show(), $(".openEndNum em").html(parseFloat(o).toFixed(1)), $(".openlate").show(), $(".late").hide(), history.pushState(null, "", "cashRedpack.html#result"), sw = 0) : 500 == a ? dialog.gray("服务器异常，请求失败", 1500) : 501 == a ? dialog.gray("参数不正确", 1500) : 502 == a ? (dialog.gray("Sessio超时", 1500), setTimeout(function () {
        location.href = "index.html"
    }, 1500)) : 600 == a ? (sw = 0, $(".mask2").show(), $(".noRedpack").removeClass("bounceOutUp hide").addClass("bounceIn")) : 601 == a ? ($(".mask2").show(), $(".noRedpack").removeClass("bounceOutUp hide").addClass("bounceIn"), setTimeout(function () {
        sw = 0
    }, 500)) : 602 == a ? (sw = 0, userCash(), $(".mask2").show(), $(".toBuy").removeClass("bounceOutUp hide").addClass("bounceIn")) : 603 == a ? (sw = 0, dialog.gray("用户未找到", 1500)) : 6031 == a ? (sw = 0, $(".mask2").show(), $(".accountBan").removeClass("bounceOutUp hide").addClass("bounceIn")) : 6032 == a ? (sw = 0, $(".mask2").show(), $(".accountBan").removeClass("bounceOutUp hide").addClass("bounceIn")) : 604 == a ? (sw = 0, $(".mask2").show(), $(".noRedpack").removeClass("bounceOutUp hide").addClass("bounceIn")) : 605 == a && (sw = 0, $(".mask2").show(), $(".noRedpack").removeClass("bounceOutUp hide").addClass("bounceIn")) : 200 == a ? 0 == t ? ($(".mask2").show(), $(".welfareBag").removeClass("bounceOutUp hide").addClass("bounceIn"), $(".ic_open").addClass("change"), setTimeout(function () {
        robsuccess(), sw = 0
    }, 3e3)) : (robsuccess(), sw = 0) : 500 == a ? (sw = 0, dialog.gray("服务器异常，请求失败", 1500)) : 501 == a ? (sw = 0, dialog.gray("参数不正确", 1500)) : 502 == a ? (sw = 0, dialog.gray("Sessio超时", 1500), setTimeout(function () {
        location.href = "index.html"
    }, 1500)) : 600 == a ? (sw = 0, $(".mask2").show(), $(".noWelfareBag").removeClass("bounceOutUp hide").addClass("bounceIn")) : 601 == a || 604 == a ? (sw = 0, $(".mask2").show(), $(".noWelfareBag").removeClass("bounceOutUp hide").addClass("bounceIn")) : 603 == a ? (sw = 0, dialog.gray("用户未找到", 1500)) : 6031 == a ? (sw = 0, $(".mask2").show(), $(".accountBan").removeClass("bounceOutUp hide").addClass("bounceIn")) : 6032 == a ? (sw = 0, $(".mask2").show(), $(".accountBan").removeClass("bounceOutUp hide").addClass("bounceIn")) : 6033 == a ? (sw = 0, dialog.gray("用户可抢次数不足）", 1500)) : 6034 == a && (sw = 0, dialog.gray("用户没有在现金场抢过红包）", 1500))
}
function cashRedpackRule(e) {
    var s = e.amount, a = e.totalNum, o = sessionStorage.getItem("sw");
    "" != o && void 0 != o || ($(".welfareRuleContent p span").html(s + "个/" + a + "包"), $(".mask2").show(), $(".welfareRule").removeClass("bounceOutUp hide").addClass("bounceIn"), sessionStorage.setItem("sw", 1))
}
function system(e) {
    var s = e.text, a = e.title, o = e.image, i = (e.time, e.flag), t = "";
    s.indexOf("免死一次") > 0 ? (t += '<div class="noDie">', t += '<div class="noDie-info">', t += "<p>" + s.split("，")[0] + "</p>", t += "<p>" + s.split("，")[1] + "</p>", t += "</div>", t += "</div> ") : (t += '<div class="textBox">', t += '<div class="ic_head"><img src="' + o + '" alt=""/></div>', t += '<div class="box_right">', t += '<div class="box_title">' + a + "</div>", "温馨提示" == a ? t += '<div class="box_content"><span></span><span></span>' + s + "</div>" : "5" == s ? (t += '<div class="box_content1 white_bg"><span></span><span></span><em>' + s + "</em></div>", time5(5e3)) : t += '<div class="box_content white_bg"><span></span><span></span><em>' + s + "</em></div>", t += "</div>", t += "</div>"), $(".cashBox").append(t), 1 == i && setTimeout(function () {
        intoRoom("")
    }, 6e4), isrcoll.onCompletion(myScroll), isrcoll.getForBottomOffset() ? (isrcoll.onScrollTo(), $(".goBottom").fadeOut()) : $(".goBottom").fadeIn()
}
function sendRedpack(e) {
    var s = e.period, a = e.userName, o = e.userImage, i = e.text, t = (e.time, e.userCode), n = e.redpackType, d = "", l = sessionStorage.getItem("userCode");
    l == t ? (d += '<div class="mybox">', d += '<div class="redpackBox" redpackType="' + n + '"  period="' + s + '">', d += '<div class="myredpack">', d += "<span></span><span></span>", d += '<div class="flex-wrap redpack_top">', d += '<div class="ic_redpack"></div>', d += '<div class="redpack_right">', d += '<div class="redpack_title">' + i + "</div>", d += '<div class="redpack_text">领取红包</div>', d += "</div>", d += "</div>", d += '<div class="kdredpack">快点红包</div>', d += "</div>", d += "</div>", d += '<div class="userInfo_right"><img src="' + o + '" alt=""/></div>', d += "</div>") : (d += '<div class="textBox" period="' + s + '">', d += '<div class="ic_head"><img src="' + o + '" alt=""/></div>', d += '<div class="box_right">', 0 == l ? 3 == n ? d += '<div class="box_title">系统红包</div>' : 4 == n && (d += '<div class="box_title">系统福利红包</div>') : d += '<div class="box_title">' + a + "</div>", d += '<div class="redpackBox" redpackType="' + n + '"  period="' + s + '">', 3 == n ? (d += '<div class="redpack">', d += "<span></span><span></span>", d += '<div class="flex-wrap redpack_top">', d += '<div class="ic_redpack"></div>', d += '<div class="redpack_right">', d += '<div class="redpack_title">' + i + "</div>", d += '<div class="redpack_text">领取红包</div>', d += "</div>", d += "</div>", d += '<div class="kdredpack">快点红包</div>') : 4 == n && (d += '<div class="redpack">', d += '<span></span><span style="border-right: 0.5rem solid #E90100"></span>', d += '<div class="flex-wrap redpack_top welfare_bg">', d += '<div class="ic_redpack"></div>', d += '<div class="redpack_right">', d += '<div class="redpack_title" style="font-size: 1.24rem">' + i + "</div>", d += '<div class="redpack_text">领取红包</div>', d += "</div>", d += "</div>", d += '<div class="kdredpack">快点福利红包</div>'), d += "</div>", d += "</div>", d += "</div>", d += "</div>"), $(".cashBox").append(d), isrcoll.onCompletion(myScroll), isrcoll.getForBottomOffset() ? (isrcoll.onScrollTo(), $(".goBottom").fadeOut(), 3 == n && $(".newRedpack").fadeOut()) : ($(".goBottom").fadeIn(), 3 == n ? ($(".newRedpack_img").attr("src", "../images/redpackKld/ic_redpack.png"), $(".newRedpack").fadeIn()) : 4 == n && ($(".newRedpack").fadeIn(), $(".newRedpack_img").attr("src", "../images/cashRedpack/ic_yellowpack.png")))
}
function nextSendRedpacket(e) {
    var s = (e.text, e.time, e.userId, e.userImage), a = e.userName, o = e.userCode, i = sessionStorage.getItem("userCode"), t = "";
    t += '<div class="flex-wrap nextsend">', t += '<div class="ic_nextsend"><img src="' + s + '" alt=""/></div>', t += i == o ? '<div class="send_person">下一红包将由<em>你</em>发出</div>' : '<div class="send_person">下一红包将由<em>' + a + "</em>发出</div>", t += "</div>", $(".cashBox").append(t), i == o && (1 == type ? $(".cashmoveTop").html("-20.0") : 2 == type ? $(".cashmoveTop").html("-50.0") : 3 == type ? $(".cashmoveTop").html("-100.0") : 4 == type && $(".cashmoveTop").html("-200.0"), $(".cashmoveTop").addClass("amontAddMove"), setTimeout(function () {
        $(".cashmoveTop").removeClass("amontAddMove")
    }, 4e3)), isrcoll.onCompletion(myScroll), isrcoll.getForBottomOffset() ? (isrcoll.onScrollTo(), $(".goBottom").fadeOut()) : $(".goBottom").fadeIn()
}
function sendMessage(e) {
    isrcoll.onCompletion(myScroll), isrcoll.onScrollTo_2();
    var s = e.text, a = (e.time, e.userName), o = e.userImage, i = e.userCode, t = "", n = sessionStorage.getItem("userCode");
    n == i ? (t += '<div class="userInfo clearfix">', t += '<div class="userInfo_left">', t += "<span></span>", t += "<span></span>", t += '<div class="usertext">' + s + "</div>", t += "</div>", t += '<div class="userInfo_right"><img src="' + o + '" alt=""/></div>', t += "</div>", $("#input_info").val("")) : (t += '<div class="flex-wrap otheruserInfo clearfix">', t += '<div class="otherUser_right"><img src="' + o + '" alt=""/></div>', t += '<div class="otheruserInfoContent">', t += '<div class="userName">' + a + "</div>", t += '<div class="otherUser_left">', t += "<span></span>", t += "<span></span>", t += '<div class="usertext">' + s + "</div>", t += "</div>", t += "</div>", t += "</div>"), $(".sendInfo").hide(), $(".ic_more").show(), $(".cashBox").append(t), setTimeout(function () {
        sw1 = 0
    }, 1e3), isrcoll.onCompletion(myScroll), isrcoll.getForBottomOffset() ? (isrcoll.onScrollTo(), $(".goBottom").fadeOut()) : $(".goBottom").fadeIn()
}
function RedbagCord(e) {
    var s = e.totalNum, a = e.lucky, o = e.amountSum, i = sessionStorage.getItem("userName");
    $(".redtotal em").html(o), $(".num").html(s), $(".num1").html(a);
    var t = sessionStorage.getItem("userImage");
    $(".redpackRecord_head_img img").attr("src", "" + t), $(".redRecordName").html(i), $(".join_record").html("参与记录（" + s + "条）")
}
function redbagRank(e) {
    var s = e.list, a = "";
    $(s).each(function (e, s) {
        var o = s.sendUserName, i = s.amount, t = s.time;
        a += '<div class="flex-wrap redpackRecordList">', a += '<div class="dot"></div>', a += '<div class="redpackRecordContent">', a += '<div class="other_name"><em>' + o + "</em>的红包</div>", a += '<div class="redpackRecordTime">' + t + "</div>", a += "</div>", a += '<div class="cashNum"><em>+' + i + "</em>豆</div>", a += "</div>"
    }), $(".redpackRecordBox").html(a), isrcoll.onCompletion(myScroll2)
}
function timing(e) {
    var s = e / 1e3;
    Time = setInterval(function () {
        if (s > 0) {
            var e = Math.floor(s / 60 % 60).toString();
            e.length <= 1 && (e = "0" + e);
            var a = Math.floor(s % 60).toString();
            a.length <= 1 && (a = "0" + a), $(".activity_time em:nth-of-type(2)").html("<span>" + e + "</span><span>分</span><span>" + a + "</span><span>秒</span>")
        } else 0 == s && (clearInterval(Time), clearInterval(interval));
        s--
    }, 1e3)
}
function time5(e) {
    var s = e / 1e3;
    Time = setInterval(function () {
        if (s--, s >= 0) {
            var e = Math.floor(s % 60).toString();
            $(".box_content1:last").html("<span></span><span></span>" + e), 0 == s && $(".box_content1:last").html("<span></span><span></span>Go")
        }
    }, 1e3)
}
function robsuccess(e) {
    $(".mask2").show(), $(".openRedpack").removeClass("bounceIn").addClass("hide"), $(".openResult").removeClass("hide"), $(".ic_open").removeClass("change"), sw = 0
}
function goTool(e) {
    var s = e.propStatus, a = e.list;
    $(a).each(function (a, o) {
        var i = o.propId, t = o.propIdStatus;
        e.propIdTime;
        1 == s && 3 == i && (_propIdStatus = t)
    })
}
function toolInfoList(e) {
    var s = e.list, a = "";
    $(s).each(function (e, s) {
        var o = s.userImage, i = s.userName, t = s.propName, n = s.propCount;
        a += '<li class="flex-wrap">', a += '<img src="' + o + '" alt=""/>', a += '<div class="noticeInfo_text">恭喜“<span>' + i + "</span>”获得 <em>" + n + "张" + t + "</em></div>", a += "</li>"
    }), $(".noticeInfo ul").html(a), clearInterval(infoScroll), infoScroll = setInterval('autoScroll(".noticeInfo")', 3e3)
}
function toolList(e) {
    $(".activityBox").html("");
    var s = e.list, a = "";
    $(s).each(function (e, s) {
        var a = "", o = s.propId, i = s.propName, t = s.propCope, n = s.propOriginalCope, d = s.propImageFlag;
        a += "<li>", a += '<div class="record_text">' + i + '<i class="ic_about"></i></div>', a += '<div class="record_main">', 1 == o ? a += '<img src="../images/cashRedpack/record_bg.png" alt=""/>' : 2 == o ? a += '<img src="../images/cashRedpack/ic_backbag.png" alt=""/>' : 3 == o && (a += '<img src="../images/cashRedpack/look_bag_bg.png" alt=""/>'), a += '<div class="record_timeBox_' + o + '"></div>', a += "</div>", a += d == -1 ? '<div class="exchangeBean" propId="' + o + '"><span><i>' + t + "</i>豆</span></div>" : '<div class="exchangeBean" propId="' + o + '"><span><i>' + t + "</i>豆</span><span>原价:<em>" + n + "豆</em></span></div>", a += 0 == d ? '<div class="left_day_green"><span>新品</span></div>' : '<div class="left_day"><span>剩' + d + "天</span></div>", 1 == o ? a += '<div class="infoBox hide"><span></span>记录板：提供往期100次红包开出结果走势图及统计结果，为期7天，获得后自动使用，可累加。</div>' : 2 == o ? a += '<div class="infoBox revise hide"><span></span>退包卡：抢到红包后，使用“退包卡”可强行退回红包。</div>' : 3 == o && (a += '<div class="infoBox revise1 hide"><span></span>看首包卡：可看到抢第一包红包金额，时长3时，获得后自动使用，可累加。</div>'), a += "</li>", $(".activityBox").prepend(a)
    }), s.length <= 3 && (a += "<li>", a += '<div class="noOpen">', a += '<img src="../images/cashRedpack/ic_addmore.png" alt=""/>', a += "<p>敬请期待</p>", a += "</div>", a += "</li>"), $(".activityBox").append(a)
}
function userToolList(e) {
    var s = e.list;
    $(s).each(function (e, s) {
        var a = "", o = s.propId, i = s.propCount, t = s.propType, n = s.propTime;
        2 == o ? a += '<div class="record_time">拥有' + i + "张</div>" : n > 0 && 1 == t && (a += '<div class="record_time"><i class="ic_time_mark"></i><span class="propTime' + o + '"></span></div>', clearInterval(recordInterval), record_time(n, o)), $(".record_timeBox_" + o).html(a)
    })
}
function lookfirstBag(e) {
    var s = e.amount, a = "";
    a += '<div class="firstBagAmount"><span></span>' + parseFloat(s).toFixed(1) + "个</div>", $(".firstBagAmountBox_" + i).html(a)
}
function getTool(e) {
    var s = e.msgCode, a = e.propType, o = e.propTime, i = e.propCount;
    sw2 = 0, 200 == s ? ($(".againConfirm").removeClass("bounceIn").addClass("hide"), 1 == propId || (2 == propId ? $(".backBagCard").removeClass("hide").addClass("bounceIn") : 3 == propId && $(".lookBagCard").removeClass("hide").addClass("bounceIn")), 1 == a ? o > 0 && (clearInterval(addInterval), add_time(o)) : 0 == a && $(".cardNum").html("已拥有:" + i + "张")) : 500 == s ? dialog.gray("购买失败！", 2e3) : 600 == s && $(".noBeans").removeClass("hide").addClass("bounceIn")
}
function record_time(e, s) {
    var a = e / 1e3;
    recordInterval = setInterval(function () {
        if (a > 0) {
            var e = Math.floor(a / 60 / 60 % 24).toString();
            e.length <= 1 && (e = "0" + e);
            var o = Math.floor(a / 60 % 60).toString();
            o.length <= 1 && (o = "0" + o);
            var i = Math.floor(a % 60).toString();
            i.length <= 1 && (i = "0" + i), 0 == o ? $(".propTime" + s).html(o + "分" + i + "秒") : $(".propTime" + s).html(e + "时" + o + "分"), 0 == a && (clearInterval(recordInterval), $(".propTime" + s).parent().remove())
        } else a <= 0 && (clearInterval(recordInterval), $(".propTime" + s).parent().remove());
        a--
    }, 1e3)
}
function autoScroll(e) {
    $(e).find("ul").animate({marginTop: "-2.14rem"}, 1e3, "linear", function () {
        $(this).css({marginTop: "0px"}).find("li:first").appendTo(this)
    })
}
function add_time(e) {
    var s = e / 1e3;
    addInterval = setInterval(function () {
        if (s > 0) {
            var e = Math.floor(s / 60 / 60 % 24).toString();
            e.length <= 1 && (e = "0" + e);
            var a = Math.floor(s / 60 % 60).toString();
            a.length <= 1 && (a = "0" + a), $(".left_time").html("累计时长：" + e + "时" + a + "分")
        } else 0 == s && clearInterval(addInterval);
        s--
    }, 1e3)
}
var sign = "%x9", k = 0, i = 0, beans = 0, useramoun, openId = localStorage.getItem("openid"), ws, interval, _propIdStatus, recordInterval, addInterval, infoScroll;
$(function () {
});