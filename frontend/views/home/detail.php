<style>
    #signBtn {
        display: block;
        width: 90px;
        line-height: 2em;
        background: #d6d6d6;
        right: 10px;
        text-align: center;
        border-radius: 5px;
        position: absolute;
    }
    #signStatBtn {
        display: block;
        width: 90px;
        line-height: 2em;
        background: #d6d6d6;
        left: 10px;
        text-align: center;
        border-radius: 5px;
        position: absolute;
    }
    .select {
        position: relative;
        float: right;
        width: 76%;
    }
    .select input {
        text-align: center;
        width: 100%;
    }
    .select::after {
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid;
        color: gray;
        content: "";
        height: 0;
        margin-top: 7px;
        pointer-events: none;
        position: absolute;
        right: 0px;
        /*top: 50%;*/
        width: 0;
    }
</style>
<!--活动详情 模板 -->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <div class="weui-navbar p-relative">
                        <div class="weui-navbar__item my_navbar">
                            <a class="mui-icon mui-icon-left-nav" id="detail_title" href="<?php echo config_item('index_url') . '/home/index'?>"></a>
                            <h4 class="title"><?php echo $lesson['title']?></h4>
                        </div>
                    </div>
                    <div class="weui-panel__bd detail_text">
                        <div class="weui-media-box weui-media-box_text">
                            <p class="weui-media-box__desc mui-icon-extra mui-icon-extra-outline">
                                <em>时间：</em><?php
                                $city_selected = isset($lesson['city']) ? explode(',', $lesson['city']) : [];
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
                                <span class="select" id="start_time_wrapper"><input style="" class="weui-input" name="start_time" id="start_time" type="text" value="<?php if($start_time != '') {
//                                        echo config_item('weekday')[date('w', strtotime($start_time))] . ' ';
                                        echo date('m-d H:i', strtotime($start_time));
                                        echo ' 至 ';
                                        echo date('m-d H:i', strtotime($end_time));
//                                        echo '(' .config_item('weekday')[date('w', strtotime($end_time))] . ')';
                                    } ?>" placeholder="请选择开课时间"></span>
                            </p>
                            <p class="weui-media-box__desc mui-icon-extra mui-icon-extra-find">
                                <em>地点：</em>
                                <span class="select" id="address_wrapper"><input style="" class="weui-input" name="address" id="address" type="text" value="<?php if($address != '') echo $address;?>" placeholder="请选择开课地址"></span>
                            </p>
                            <p class="weui-media-box__desc mui-icon-extra mui-icon-extra-gold">
                                <em>价格：</em>
                                <span id="price"><?php echo $lesson['charge'];?>元</span>
                            </p>
                            <p class="weui-media-box__desc mui-icon-extra mui-icon-extra-peoples">
                                <em>已报名人数：</em>
                                <span><?php echo $lesson['join_num']?>人</span>
                            </p>
                            <p class="weui-media-box__desc mui-icon-extra mui-icon-extra-peoples">
                                <em>剩余可报名人数：</em>
                                <span><?php echo $lesson['limit_num']?>人</span>
                            </p>
                            <p class="weui-media-box__desc mui-icon-extra mui-icon-extra-people">
                                <em>联系人：</em>
                                <span><?php echo $lesson['linkman']?></span>
                            </p>
                            <p class="weui-media-box__desc mui-icon-extra mui-icon-extra-phone">
                                <em>联系电话：</em>
                                <span><?php echo $lesson['contract_number']?></span>
                            </p>
                        </div>
                        <div class="weui-media-box weui-media-box_text">
                            <h3 class="weui-media-box__title">嘉宾介绍</h3>
                            <div class="panel">
                                <div class="bd">
                                    <div class="weui_panel_bd">
                                        <div class="img_text">
                                            <div class="left_img">
                                                <img src="<?php echo $teacher['headimgurl']?>"/>
                                            </div>
                                            <div class="right_text"><h4><?php echo $teacher['name'];?></h4><?php echo $teacher['summary']?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="weui-media-box weui-media-box_text">
                            <h3 class="weui-media-box__title">活动详情</h3>
                            <article class="my_article">
                                <?php echo $lesson['detail'];?>
                            </article>
                        </div>

                    </div>
                </div>
                <?php if (date('U') < strtotime($lesson['end_time'])) {?>
                <div class="weui-tabbar padding10">
                    <?php if ($is_admin) {?>
                        <a class="" id="signStatBtn">签到统计</a>
                    <?php }?>
                    <a class="weui-btn weui-btn_primary" id="joinBtn">马上报名</a>
                    <?php if ($is_admin) {?>
                        <a class="" id="signBtn">签到二维码</a>
                    <?php }?>
                </div>
                <?php } else if ($is_admin) {?>
                    <div class="weui-tabbar padding10">
                        <a class="" id="signStatBtn">签到统计</a>
                        <a class="weui-btn weui-btn_primary" style="visibility: hidden">马上报名</a>
                        <a class="" id="signBtn">签到二维码</a>
                    </div>
                <?php }?>
            </div>
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
            var start_times = <?php
                echo '[';
                $index = 0;
                for ($index = 0; $index < count($start_times); $index ++) {
                    if ($index > 0) {
                        echo ',';
                    }
                    echo "'" . date('m-d H:i', strtotime($start_times[$index]));
//                                        echo '(' .config_item('weekday')[date('w', strtotime($start_time))] . ')';
                    echo " 至 ";
                    echo date('m-d H:i', strtotime($end_times[$index]));
//                                        echo '(' .config_item('weekday')[date('w', strtotime($end_time))] . ')';
                    echo "'";
                }

                echo '];';
                ?>
            var addresses = <?php
                echo '[';
                $index = 0;
                for ($index = 0; $index < count($addresses); $index ++) {
                    if ($index > 0) {
                        echo ',';
                    }
                    echo "'" . $addresses[$index];
                    echo "'";
                }

                echo '];';
                ?>
            FastClick.attach(document.body);
            $('.js_item').on('click', function(){
                var link = $(this).data('link');
                window.pageManager.go(link);
            });
            <?php if (isset($has_userinfo)  && $has_userinfo) {?>
            $('#joinBtn').on('click', function(){
                var index = get_index($('#address').val(), addresses);
                location.href = '<?php echo config_item('index_url')?>/home/join?id=<?php echo $id?>' + '&index=' + index;
            });
            <?php } else { ?>
            $('#joinBtn').on('click', function(){
                $('#tips_dialog .title').html('操作提示');
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                    location.href = '<?php echo config_item('index_url')?>/home/profile_edit?lesson_id=<?php echo $id?>';
                });
                $('#tips_dialog .content').html('请先填写个人信息');
            });
            <?php }?>
            <?php if ($is_admin) {?>
            $('#signBtn').on('click', function() {
                location.href = '<?php echo config_item('index_url')?>/home/qrcode?lesson_id=<?php echo $id?>';
            });
            $('#signStatBtn').on('click', function() {
                location.href = '<?php echo config_item('index_url')?>/home/sign_stat?lesson_id=<?php echo $id?>';
            });
            <?php }?>
            init_address();
            init_start_times();

            function  init_start_times()
            {
                $('#start_time').picker({
                    title: "请选择开课时间",
                    cols: [
                        {
                            textAlign: 'center',
                            values: start_times
                        }
                    ],
                    onChange: function(p, v, dv) {
                        var value = addresses[get_index(v, start_times)];
                        var html = '<input style="" class="weui-input" name="address" id="address" type="text" value="'  + value + '" placeholder="请选择开课地址">';
                        $('#address_wrapper').html(html);
                        init_address();
                    },
                    onClose: function(p, v, d) {
                    }
                });
            }

            function init_address()
            {
                $('#address').picker({
                    title: "请选择开课地址",
                    cols: [
                        {
                            textAlign: 'center',
                            values: addresses
                        }
                    ],
                    onChange: function(p, v, dv) {
                        var value = start_times[get_index(v, addresses)];
                        var html = '<input style="" class="weui-input" name="start_time" id="start_time" type="text" value="' + value + '" placeholder="请选择开课时间">';
                        $('#start_time_wrapper').html(html);
                        init_start_times();
                    },
                    onClose: function(p, v, d) {
                    },
                    close: function () {
                        console.log('close');
                    }
                });
            }
        });
        function get_index(v, arr) {
            for (var index = 0; index < arr.length; index ++) {
                if (arr[index] == v) {
                    break;
                }
            }
            return index;
        }


</script>
</script>




<script>
    var teacher_url = '<?php echo config_item('index_url')?>/home/get_teacher/';
    var order_url = '<?php echo config_item('index_url')?>/home/order';
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


</script>