var packet = {

    /**
     * 初始化数据
     * @param data
     */
    initRoom:function (data) {
        data.system_avatar = "/static/images/avatar/f1/f_6.jpg";
        var html = template('system_init', data);
        $("#chatLineHolder-a").append(html);
        chat.scrollDiv('chat-lists');


        packet.event();
    },

    event:function () {

     
        //事件绑定
        $(document).on("click",'.packet',function (e) {

            e.stopPropagation();
            if(!chat.canRob()){
                page.showToBuy();
                return false;
            }
            var packet_id = $(this).data("packet");
            chat.checkRob(packet_id);
            return;

            if(packet.isCachePacket(packet_id)){
                chat.rob(packet_id);
                //packet.showCachePacket(packet_id);
                return false;
            }
            page.showOpenRedpack(packet_id);
            return false;
        });

    },

    isCachePacket:function (packet_id) {
        var k = "cache_packet_"+packet_id;
        var packet = chat.data.storage.getItem(k);
        if(typeof(packet) != 'undefined' && packet != '' && packet != null){
            return true;
        }
        return false;
    },
    
    showCachePacket:function (packet_id) {
        //alert("YES");
        var k = "cache_packet_"+packet_id;
        var packet = chat.data.storage.getItem(k);
        console.log(packet);
    },
    
    cachePacket:function (packet_id,data) {
        var k = "cache_packet_"+packet_id;
        chat.data.storage.setItem(k,JSON.stringify(data));
    },

    robCheck:function (data) {
        var packet_id = data.packet_id;
        chat.data.storage.setItem("virtual_money",data.virtual_money);

        //用户没有钱
        if(data.no_money == 0){
            page.showToBuy();
            return false;
        }
        //用户已经领取
        if(data.iamisrob > 0){
            page.showRedpackRecord(data);
            return ;
        }
        //用户手慢
        if(data.rob.length >=4){
            page.showRobFailed(data);
            return ;
        }
        //正常领取
        page.showOpenRedpack(packet_id);
        return false;
    },

    robSuccess:function (data) {
        console.log("Success");
        console.log(data);

        page.showRobSuccess(data);

    },

    robFailed:function (data) {
        console.log(data);
        packet.cachePacket(data.packet_id,data);
        var code = data.error_code;
        switch (code){
            //红包领取完成
            case 1000:
                page.showRobFailed(data);
                break;
            //用户钱不够
            case 1010:
                page.showRedpackRecord(data);
                break;
            //已经领取
            case 1011:
                page.showRedpackRecord(data);
                break;
            default:
                break;
        }

    },

    /**
     * 下一个红包即将发出
     * @param data
     */
    who_send_next_packet:function(data){
        data.system_avatar = "/static/images/avatar/f1/f_6.jpg";
        var html = template('system_prompt_next_packet', data);
        $("#chatLineHolder-a").append(html);
        chat.scrollDiv('chat-lists');
    },

    packet_number :1,
    /**
     * 红包发出倒计时五秒
     * @param data
     */
    next_packet_last:function (data) {
        data.system_avatar = "/static/images/avatar/f1/f_6.jpg";
        data.number = this.packet_number;
        var html = template('system_prompt_next_packet_done', data);
        $("#chatLineHolder-a").append(html);
        chat.scrollDiv('chat-lists');

        var i = 4;
        var interval = setInterval(function () {
            if(i==0){
                clearInterval(interval);
                //go
                $(".countdown_number",".prompt_"+ data.number).html("Go");
                return ;
            }
            $(".countdown_number",".prompt_"+ data.number).html(i);
            i--;
        },1000);

        this.packet_number++;
    },

    /**
     * 红包信息
     * @param data
     */
    packet:function (data) {
        var html = template('system_packet_info', data);
        $("#chatLineHolder-a").append(html);
        chat.scrollDiv('chat-lists');
    },

    /**
     * 用户领取了红包
     * @param data
     */
    user_rob_packet:function (data) {
        var html = template('system_user_rob_packet_info', data);
        $("#chatLineHolder-a").append(html);
        chat.scrollDiv('chat-lists');
    },

    /**
     * 下一个红包谁发出来
     * @param data
     */
    next_packet_which_send:function (data) {
        var html = template('system_prompt_next_packet_who_send', data);
        $("#chatLineHolder-a").append(html);
        chat.scrollDiv('chat-lists');
    }
    
}