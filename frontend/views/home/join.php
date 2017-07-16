<!--活动详情 模板 -->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <div class="weui-navbar p-relative">
                        <div class="weui-navbar__item my_navbar">
                            <a class="js_item mui-icon mui-icon-left-nav" id="detail_title"></a>
                            <h4 class="title">提交报名</h4>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="bd">
                            <div class="weui_panel_bd">
                                <div class="img_text">
                                    <div class="left_img">
                                        <img src="<?php echo config_item('img_url') . 'logo.jpg'?>"/>
                                    </div>
                                    <div class="right_text">
                                        传千年中医经典，承至精中医技法
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="bd">
                            <div class="weui-cells">
                                <div class="weui-cell">
                                    <div class="weui-cell__bd">
                                        <p>课程名</p>
                                    </div>
                                    <div class="weui-cell__ft"><?php echo $lesson['title']?></div>
                                </div><?php
                                $start_times = json_decode($lesson['start_times'], true);
                                $end_times = json_decode($lesson['end_times'], true);
                                $start_time = '';
                                $end_time = '';
                                if (isset($start_times[$index])) $start_time = $start_times[$index];
                                if (isset($end_times[$index])) $end_time = $end_times[$index];
                                $addresses = json_decode($lesson['addresses'], true);
                                $address = '';
                                if (isset($addresses[$index])) $address = $addresses[$index];
                                ?>
                                <div class="weui-cell">
                                    <div class="weui-cell__bd">
                                        <p>开课时间</p>
                                    </div>
                                    <div class="weui-cell__ft"><?php echo date('m-d H:i', strtotime($start_time));?>&nbsp;至&nbsp;<?php echo date('m-d H:i', strtotime($end_time)); ?></div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__bd">
                                        <p>开课地址</p>
                                    </div>
                                    <div class="weui-cell__ft"><?php echo $address;?></div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__bd weui-cell_primary">
                                        <p class="">支付金额</p>
                                    </div>
                                    <div class="weui-cell__ft price mui-icon-extra mui-icon-extra-prech"><?php echo $lesson['charge']?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="weui-tabbar padding10">
                    <a class="weui-btn weui-btn_primary" id="submitBtn">提交报名</a>
                </div>
            </div>
        </div>
    </div>
    <!-- loading toast -->
    <div id="loadingToast" style="display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-loading weui-icon_toast"></i>
            <p class="weui-toast__content">数据加载中</p>
        </div>
    </div>

    <div class="weui-dialog_alert" id="tips_dialog" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd"><strong class="weui-dialog__title title"></strong></div>
            <div class="weui-dialog__bd content"></div>
            <div class="weui-dialog__ft">
                <a href="javascript:;" class="primary weui-dialog__btn">确定</a>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('.js_item').on('click', function(){
                var link = $(this).data('link');
                window.pageManager.go(link);
            });
            $('#detail_title').on('click', function(){
                location.href = '<?php echo config_item('index_url')?>/home/detail?id=<?php echo $lesson['id']?>&index=<?php echo $index?>';
            });
            $('#submitBtn').on('click', function(){
                if (1) {
                    $('#loadingToast').show();
//                        $('#submitBtn').off();
                    $.getJSON(order_url, {
                        id:<?php echo $lesson['id']?>
                    }, function(data){
//                            alert(data.appId);
                        // 预下单成功
                        $('#loadingToast').hide();
                        if (data && data.msg == "" && data.jsparams && data.tips) {
                            jsApiCall(data.jsparams, data.tips);
                        } else {
                            $('#tips_dialog .content').html(data.msg);
                            if (data.code == '0' ) {
                                $('#tips_dialog .title').html('操作提示');
                                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                                    $('#tips_dialog').hide();
                                    location.href = mine_url;
                                });
                            } else {
                                $('#tips_dialog .title').html('错误提示');
                                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                                    $('#tips_dialog').hide();
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
</script>

<script>
    var teacher_url = '<?php echo config_item('index_url')?>/home/get_teacher/';
    var order_url = '<?php echo config_item('index_url')?>/home/order?index=<?php echo $index?>';
    var home_url = '<?php echo config_item('index_url')?>/home/index';
    var mine_url = '<?php echo config_item('index_url')?>/home/mine';
    window.onload = function(){
        <?php
        $wechat = new WeChat();
        $jssdk = new JSSDK($wechat)
        ?>
        var _sdk = <?php echo json_encode($jssdk->getSignPackage($wechat))?>;
        wx.config({
            debug: false,// 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: _sdk.appId, // 必填，公众号的唯一标识
            timestamp: _sdk.timestamp, // 必填，生成签名的时间戳
            nonceStr: _sdk.nonceStr, // 必填，生成签名的随机串
            signature: _sdk.signature,// 必填，签名，见附录1
            jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });
        wx.ready(function(){
            //分享给朋友
            wx.onMenuShareAppMessage({
                title: '【道生微课堂】<?php echo $lesson['title'];?>', // 分享标题
                desc: '<?php echo $lesson['address'];?>', // 分享描述
                link: '<?php echo config_item('index_url') . '/home/detail?id=' . $lesson['id']?>', // 分享链接
                imgUrl: '<?php echo config_item('img_url') . 'logo.jpg'?>', // 分享图标
                type: 'link', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            //分享到朋友圈
            wx.onMenuShareTimeline({
                title: '【道生微课堂】<?php echo $lesson['title'];?>', // 分享标题
                link: '<?php echo config_item('index_url') . '/home/detail?id=' . $lesson['id']?>', // 分享链接
                imgUrl: '<?php echo config_item('img_url') . 'logo.jpg'?>', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    };
function get_join_page(title, id){
    $('.join .title').html(title);
    $('.join .price').html($('#price').html());


}

function check_order_submit(name, mobile) {
    $('#tips_dialog .title').html('错误提示');
    if (/^\s*$/.test(name)) {
        $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
            $('#tips_dialog').hide();
        });
        $('#tips_dialog .content').html('姓名不能为空');
        return false;
    }
    if (!/^\d{11}$/.test(mobile)) {
        $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
            $('#tips_dialog').hide();
        });
        $('#tips_dialog .content').html('手机格式错误');
        return false;
    }
    return true;
}

function jsApiCall(params, tips)
{
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        params,
        function(res){
//                WeixinJSBridge.log(res.err_msg);
            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                //支付成功
                $('#tips_dialog .title').html('操作提示');
                $('#tips_dialog .content').html(tips);
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                    location.href = mine_url;
                });
            }
        }
    );
}
</script>