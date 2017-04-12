$(document).ready(function () {
     page.init();

});

/**
 * 页面中一些模块的显示和渲染
 * @type {{init: page.init, showRule: page.showRule, event: page.event}}
 */
var page = {
    init:function () {

        this.showRule();
        this.changeMoney(config.money);

        setInterval(function(){
            $.post("/action.php?openid="+config.openid,{"action":'getMoney'},function(e){
                config.money = e.data;
                page.changeMoney(config.money);
            },'json')
        },2000);

        this.event();

    },

    /**
     * 显示游戏规则
     */
    showRule:function () {
        $(".welfareRule,.mask2").show();
        $(".welfareRule .knowBtn").click(function () {
            $(".welfareRule,.mask2").hide();
            $(".welfareRule .knowBtn").unbind("click");
        });
    },

    /**
     * 游戏货币不足
     */
    showToBuy:function () {
        var html = $(".toBuy_num").html();
        $(".toBuy_num").html(html.replace("--",chat.getRoomUserVirtualMoney()));
        $(".toBuy .beansNum").html(chat.getRoomMoney());
        $(".toBuy,.mask2").show();
        $(".toBuy .ic_yuan_del").click(function () {
            $(".toBuy .ic_yuan_del").unbind('click');
            $(".toBuy,.mask2").hide();

        });
    },

    /**
     * 充值虚拟货币
     */
    showRecharge:function () {
        $(".getKld,.mask2").show();
    },

    showLoading:function () {
        $(".loadMask,.mask2").show();
    },

    /**
     * 抢红包页面
     */
    showOpenRedpack:function (packet_id) {

        $(".openRedpack .ic_open").click(function () {
            chat.rob(packet_id);

            $(".openRedpack").hide();
            $(".openRedpack .ic_open").unbind("click");
        });

        $(".openRedpack,.mask2").show();
    },

    /**
     * 领取成功
     * @param data
     */
    showRobSuccess:function (data) {
        $(".mask2 ").hide();
        $(".redpackResult-con .openlate").show();
        $(".redpackResult-con .late").hide();

        $(".redpackResult .openBox ").empty();

        $(".redpackResult #openWraper ").height("666");
        $(".redpackResult #openScroller ").height("667");


        //信息加载
        var avater = false;
        var nickname = false;
        var packet_number = false;
        $.each(data.rob,function (k,v) {
            var a = template("packet_item",v);
            if($(".redpackResult .openBox .openBoxList").length > 0){
                $(".redpackResult .openBox .openBoxList:last").after(a);
            }else{
                $(".redpackResult .openBox ").append(a);
            }
            if(v.openid == config.openid){
                avater = v.img;
                nickname = v.nickname;
                packet_number = v.packet_number;
            }
        });

        //头部信息
        $(".redpackResult-con .user_img img").attr("src",avater);
        $(".redpackResult-con  .openEndname").html(nickname);
        $(".redpackResult .openEndNum em").html(packet_number);

        $(".redpackResult-con").show();
    },

    /**
     * 用户领取手慢了
     */
    showRobFailed:function (data) {
        //加载红包结果信息。

        $(".noRedpack .lookluck").click(function () {
            $(".noRedpack,.mask2").hide();
            $(".noRedpack .lookluck").unbind('click');
            //
            page.showRedpackRecordNoMe(data.packet_id,data);
        });

        $(".noRedpack,.mask2").show();

    },

    /**
     * 没有我的红包领取记录
     */
    showRedpackRecordNoMe:function (packet_id,data) {
        $(".redpackResult-con .openlate").hide();
        $(".redpackResult-con .late").show();

        //头部信息

        $(".redpackResult .openBox ").empty();

        $(".redpackResult #openWraper ").height("666");
        $(".redpackResult #openScroller ").height("700");

        
        var avater = false;
        var nickname = false;
        var packet_number = false;
        //信息加载
        $.each(data.rob,function (k,v) {
            var a = template("packet_item",v);
            if($(".redpackResult .openBox .openBoxList").length > 0){
                $(".redpackResult .openBox .openBoxList:last").after(a);
            }else{
                $(".redpackResult .openBox ").append(a);
            }

            avater = v.img;
            nickname = v.nickname;
            packet_number = v.packet_number;
        });

        $(".redpackResult-con .user_img img").attr("src",avater);
        $(".redpackResult-con  .openEndname").html(nickname);
        $(".redpackResult .openEndNum em").html(packet_number);

        $(".redpackResult-con").show();
    },

    /**
     * 红包领取记录
     */
    showRedpackRecord:function (data) {

        $(".mask2 ").hide();
        $(".redpackResult-con .openlate").hide();
        $(".redpackResult-con .late").hide();

        $(".redpackResult .openBox ").empty();

        $(".redpackResult #openWraper ").height("611");
        $(".redpackResult #openScroller ").height("612");


        //信息加载
        var avater = false;
        var nickname = false;
        var packet_number = false;
        $.each(data.rob,function (k,v) {
            var a = template("packet_item",v);

            if($(".redpackResult .openBox .openBoxList").length > 0){
                $(".redpackResult .openBox .openBoxList:last").after(a);
            }else{
                $(".redpackResult .openBox ").append(a);
            }
            avater = v.img;
            nickname = v.nickname;
            packet_number = v.packet_number;
        });

        //头部信息
        $(".redpackResult-con .user_img img").attr("src",avater);
        $(".redpackResult-con  .openEndname").html(nickname);
        $(".redpackResult .openEndNum em").html(packet_number);

        $(".redpackResult-con").show();
    },

    changeMoney:function (num) {
        num = parseFloat(num);
        num = num.toFixed(2);

        $("#money i ").html(num);
    },

    /**
     * 用户信息加载完成后调用
     */
    userLoadSuccess:function () {
        var money = chat.getRoomMoney();
        $(".kld-number").attr("data",money);
        $(".kld-number em").html(money);
        var userMoney = chat.getRoomUserVirtualMoney();
        $(".getKld .mykld em").html(userMoney);
    },

    event:function () {
        /**
         * 游戏货币不足关闭
         */
        $(".toBuy .ic_yuan_del").click(function () {
            $(".toBuy,.mask2").hide();
        });

        /**
         * 充值关闭
         */
        $(".getKld .title").click(function () {
            $(".getKld,.mask2").hide();
        });

        /**
         * 关闭领取页面
         */
        $(".openRedpack .ic_reddel").click(function () {
            $(".openRedpack,.mask2").hide();
        });

        $(".noRedpack .ic_reddel").click(function () {
            $(".noRedpack,.mask2").hide();
        });

        /**
         * 充点钱去看看
         */
        $(".toBuy .buyBtn,#recharge").click(function () {
            $(".toBuy,.mask2").hide();
            //
            page.showRecharge();
        });

        $(".redpackResult .openEndTitle span").click(function () {
            $(".redpackResult").hide();
        });

        /**
         * 充值减少豆
         */
        $(".kldNumber .kld-reduce").click(function () {
            var kld_number = parseInt($(" .kldNumber .kld-number em").html());
            var number_step = parseInt($(".kld-number").attr("data"));
            var r = kld_number - number_step;
            if(r<number_step){
                r = number_step;
            }
            $(" .kldNumber .kld-number em").html(r);
        });

        /**
         * 充值添加豆
         */
        $(".kldNumber .kld-add").click(function () {
            var kld_number = parseInt($(" .kldNumber .kld-number em").html());
            var number_step = parseInt($(".kld-number").attr("data"));
            var r = kld_number + number_step;
            $(" .kldNumber .kld-number em").html(r);
        });

        $("#withdraw").click(function(){
            window.location.href = 'http://chat.codeception.cn/withdraw.php?openid='+config.openid;
        });
        
        $("#show_rule").click(function () {
            page.showRule();
        });
    }
}