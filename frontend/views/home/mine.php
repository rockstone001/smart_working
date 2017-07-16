<!--订单列表页 模板-->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <?php include(VIEWPATH . 'include/mine_header.php')?>
                    <div class="seperator"></div>
                    <div class="page__bd">
                        <div class="weui-cells__title">我的活动</div>
                        <div class="weui-cells list">
                            <a class="weui-cell weui-cell_access" href="javascript:;">
                                <div class="weui-cell__bd">
                                    <p>helo</p>
                                </div>
                                <div class="weui-cell__ft">已支付</div>
                            </a>
                            <a class="weui-cell weui-cell_access" href="javascript:;">
                                <div class="weui-cell__bd">
                                    <p>cell standard</p>
                                </div>
                                <div class="weui-cell__ft">未支付</div>
                            </a>

                        </div>
                    </div>
                </div>
                <?php include(VIEWPATH . 'include/footer.php')?>
            </div>
        </div>
    </div>
    <script>

    </script>
</script>

<!--订单详情 模板 -->
<script type="text/html" id="tpl_detail">
    <div class="page tabbar">
    <div class="page__bd" style="height: 100%;">
    <div class="weui-tab">
    <div class="weui-tab__panel">
    <div class="weui-navbar p-relative">
    <div class="weui-navbar__item my_navbar">
    <a class="js_item mui-icon mui-icon-left-nav" id="detail_title" data-link="home"></a>
    <h4 class="title"></h4>
    </div>
    </div>
    <div class="weui-panel__bd detail_text"></div>
    </div>
    <div class="weui-tabbar padding10" id="payBtn">
        <a class="weui-btn weui-btn_primary" id="joinBtn">完成支付</a>
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
    });
</script>
</script>

<script>
    var order_list_url = '<?php echo config_item('index_url')?>/order/mine';
    var order_detail_url = '<?php echo config_item('index_url')?>/order/detail/';
    var re_order_url = '<?php echo config_item('index_url')?>/order/reorder';
    var mine_url = '<?php echo config_item('index_url')?>/home/mine';
    function get_order_list() {
        $.getJSON(order_list_url, function(data) {
            if (data.code == 0) {
                var html = '';
                for (var i = 0; i < data.msg.length; i ++) {
                    html += '<a class="weui-cell weui-cell_access order_item" href="javascript:;" data-link="detail" data-id="' + data.msg[i].id + '" data-title="' + data.msg[i].title + '" data-state="' + data.msg[i].state + '">';
                    html += '<div class="weui-cell__bd"><p>' + data.msg[i].title + '</p></div>';
                    html += '<div class="weui-cell__ft">' + (data.msg[i].state == 1 ? '<span class="green">已支付</span>' : (data.msg[i].state == 0 ? '<span class="red">未支付</span>' : '<span class="gray">已过期</span>')) + '</div></a>';
                }
            }
            $('.list').html(html);
            $('.order_item').on('click', function(){
                window.pageManager.go($(this).data('link'));
                var title = $(this).data('title');
                var id = $(this).data('id');
                var state = $(this).data('state');
                setTimeout(function(){
                    $('.detail .title').html('订单详情');
                    if (state) {
                        $('#payBtn').hide();
                    } else {
                        $('#payBtn').show();
                    }
                }, 100);

                get_order_detail(id);
            });
        });

    }
    window.onload = function() {
        setTimeout(function(){
            get_order_list();
        }, 100);

    };

    function get_order_detail(id)
    {
        $.get(order_detail_url + id, function(html) {

            setTimeout(function(){
                $('.detail_text').html(html);
            }, 100);
            $('#joinBtn').on('click', function(){
                $('#loadingToast').show();
                $('#joinBtn').off();
                $.getJSON(re_order_url, {
                    id:id
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
            });
        });
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