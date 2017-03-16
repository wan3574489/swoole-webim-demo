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

        //事件绑定
        $(document).on("click",'.packet',function (e) {
            e.stopPropagation();
            alert($(this).data('packet'));
            return false;
        });
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