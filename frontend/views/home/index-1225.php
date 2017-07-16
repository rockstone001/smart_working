<!--活动列表页 模板-->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <?php include(VIEWPATH . 'include/header.php')?>
                    <div class="weui-navbar p-relative">
                        <div class="weui-navbar__item select" id="citySelectBtn">全部城市</div>
                        <div class="weui-navbar__item select" id="typeSelectBtn">全部类型</div>
                        <div class="weui-navbar__item select" id="timeTypeSelectBtn">1个月内</div>
                        <div></div>
                    </div>
                    <div class="page__bd">
                        <div class="weui-cells list">

                        </div>
                    </div>
                </div>
                <?php include(VIEWPATH . 'include/footer.php')?>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#citySelectBtn').on('click', function () {
                weui.picker(cities, {
                    onChange: function (result) {
                    },
                    onConfirm: function (result) {
                        $('#citySelectBtn').html(result[0]||"全部城市");
                        get_list();
                    },
                    id: "citySelector",
                    triggerElem: this
                });
            });
            $('#typeSelectBtn').on('click', function () {
                weui.picker(lesson_type, {
                    onChange: function (result) {
                    },
                    onConfirm: function (result) {
                        $('#typeSelectBtn').html(result[0]||"全部类型");
                        get_list();
                    },
                    id: "typeSelector",
                    triggerElem: this
                });
            });
            $('#timeTypeSelectBtn').on('click', function () {
                weui.picker(time_type, {
                    onChange: function (result) {
                    },
                    onConfirm: function (result) {
                        $('#timeTypeSelectBtn').html(result[0]);
                        get_list();
                    },
                    id: "timeTypeSelector",
                    triggerElem: this
                });
            });
            get_list();
        });
    </script>
</script>

<!--活动详情 模板 -->
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
                <div class="weui-tabbar padding10">
                    <a class="weui-btn weui-btn_primary" id="joinBtn" data-link="join">马上报名</a>
                </div>
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

<!--报名页面模板-->
<script type="text/html" id="tpl_join">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <div class="weui-navbar p-relative">
                        <div class="weui-navbar__item my_navbar">
                            <a class="js_item mui-icon mui-icon-left-nav" id="detail_title" data-link="detail"></a>
                            <h4 class="title"></h4>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="bd">
                            <div class="weui_panel_bd">
                                <div class="img_text">
                                    <div class="left_img">
                                    </div>
                                    <div class="right_text"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="bd">
                            <div class="weui_cells weui_cells_form">
                                <div class="weui_cell">
                                    <div class="weui_cell_hd"><label class="weui_label">姓名</label></div>
                                    <div class="weui_cell_bd weui_cell_primary">
                                        <input id="name" class="weui_input" type="text" placeholder="请输入姓名号">
                                    </div>
                                </div>
                                <div class="weui_cell">
                                    <div class="weui_cell_hd"><label class="weui_label">电话</label></div>
                                    <div class="weui_cell_bd weui_cell_primary">
                                        <input id="mobile" class="weui_input" type="number" pattern="[0-9]*" placeholder="请输入电话号码">
                                    </div>
                                </div>
                                <div class="weui_cell">
                                    <div class="weui_cell_hd"><label class="weui_label">留言</label></div>
                                    <div class="weui_cell_bd weui_cell_primary">
                                        <textarea class="weui_textarea" placeholder="请输入留言" rows="3" id="msg"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="weui_cells">
                                <div class="weui_cell">
                                    <div class="weui_cell_bd weui_cell_primary">
                                        <p class="">支付金额</p>
                                    </div>
                                    <div class="weui_cell_ft price mui-icon-extra mui-icon-extra-prech"></div>
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
    <div id="loadingToast" class="weui_loading_toast" style="display:none;">
        <div class="weui_mask_transparent"></div>
        <div class="weui_toast">
            <div class="weui_loading">
                <div class="weui_loading_leaf weui_loading_leaf_0"></div>
                <div class="weui_loading_leaf weui_loading_leaf_1"></div>
                <div class="weui_loading_leaf weui_loading_leaf_2"></div>
                <div class="weui_loading_leaf weui_loading_leaf_3"></div>
                <div class="weui_loading_leaf weui_loading_leaf_4"></div>
                <div class="weui_loading_leaf weui_loading_leaf_5"></div>
                <div class="weui_loading_leaf weui_loading_leaf_6"></div>
                <div class="weui_loading_leaf weui_loading_leaf_7"></div>
                <div class="weui_loading_leaf weui_loading_leaf_8"></div>
                <div class="weui_loading_leaf weui_loading_leaf_9"></div>
                <div class="weui_loading_leaf weui_loading_leaf_10"></div>
                <div class="weui_loading_leaf weui_loading_leaf_11"></div>
            </div>
            <p class="weui_toast_content">报名提交中</p>
        </div>
    </div>
    <div class="weui_dialog_alert" id="tips_dialog" style="display: none;">
        <div class="weui_mask"></div>
        <div class="weui_dialog">
            <div class="weui_dialog_hd"><strong class="weui_dialog_title title"></strong></div>
            <div class="weui_dialog_bd content"></div>
            <div class="weui_dialog_ft">
                <a href="javascript:;" class="weui_btn_dialog primary">确定</a>
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
    var detail_id = 0;
    <?php
        $cities = config_item('cities');
        $city_formatted = [[
            'label' => '全部城市',
            'value' => ''
        ]];

        foreach ($cities as $c) {
            $city_formatted[] = [
                'label' => $c['name'],
                'value' => $c['name']
            ];
        }
        echo 'var cities = ' . json_encode($city_formatted) . ';';

        $lesson_type = config_item('lesson_type');
        $lesson_type_formatted = [[
            'label' => '全部类型',
            'value' => ''
        ]];

        foreach ($lesson_type as $c) {
            $lesson_type_formatted[] = [
                'label' => $c,
                'value' => $c
            ];
        }
        echo 'var lesson_type = ' . json_encode($lesson_type_formatted) . ';';

        $time_type = config_item('time_type');
        $time_type_formatted = [];

        foreach ($time_type as $k=>$c) {
            $time_type_formatted[] = [
                'label' => $k,
                'value' => $k
            ];
        }
        echo 'var time_type = ' . json_encode($time_type_formatted) . ';';
    ?>
    window.onload = function(){
    };
    var list_url = '<?php echo config_item('index_url')?>/home/get_list';
    var detail_url = '<?php echo config_item('index_url')?>/home/detail/';
    var teacher_url = '<?php echo config_item('index_url')?>/home/get_teacher/';
    var order_url = '<?php echo config_item('index_url')?>/home/order';
    function get_list()
    {
        var city = $('#citySelectBtn').html();
        var type = $('#typeSelectBtn').html();
        var startTime = $('#timeTypeSelectBtn').html();
        $.getJSON(list_url, {
            city: city,
            type: type,
            start_time: startTime
        }, function(data) {
//            console.log(data);
            if (data.code == 0) {
                var html = '';
                for (var i = 0; i < data.msg.length; i ++) {
                    html += '<a class="weui-cell weui-cell_access lesson_item" href="javascript:;" data-link="detail" data-id="' + data.msg[i].id + '" data-title="' + data.msg[i].title + '">';
                    html += '<div class="weui-cell__hd"><img src="' + data.msg[i].image + '" alt="" style="width:60px;margin-right:5px;display:block"></div>';                     html += '<div class="weui-cell__bd right5"><p>' + data.msg[i].title + '</p></div>';
                    html += '<div class="weui-cell__ft">' + data.msg[i].start_time.substr(0, 10) + '</div></a>';
                }
            }
            $('.list').html(html);
            $('.lesson_item').on('click', function(){
                window.pageManager.go($(this).data('link'));
                var title = $(this).data('title');
                var id = $(this).data('id');
                setTimeout(function(){
                    $('.detail .title').html(title);
                    $('#joinBtn').on('click', function(){
                        window.pageManager.go($(this).data('link'));
                        setTimeout(function(){
                            get_join_page(title, id);
                        }, 100);

                    });
                }, 100);

                get_detail(id);
            });
        });
    }

    function get_detail(id)
    {
        $.get(detail_url + id, function(html) {

            setTimeout(function(){
                $('.detail_text').html(html);
            }, 100);
//            $('#submitBtn').on('click', function(){
//                window.pageManager.go($(this).data('link'));
//            });
        });
    }

    function get_join_page(title, id){
        $('.join .title').html(title);
        $('.join .price').html($('#price').html());
        $.getJSON(teacher_url + id, function(data){
            if (data.code == 0) {
                $('.join .left_img').html('<img src="' + data.msg.headimgurl + '"/>');
                $('.join .right_text').html(data.msg.summary);
                $('#submitBtn').on('click', function(){
                    var name = $('#name').val();
                    var mobile = $('#mobile').val();
                    var msg = $('#msg').val();
                    if (check_order_submit(name, mobile)) {
                        $('#loadingToast').show();
                        $('#submitBtn').off();
                        $.getJSON(order_url, {
                            id:id,
                            name:name,
                            mobile:mobile,
                            msg:msg
                        }, function(data){
                            alert(data.appId);
                            jsApiCall(data);
                        });
                    }
                });
            }
        });
    }

    function check_order_submit(name, mobile) {
        $('#tips_dialog .title').html('错误提示');
        if (/^\s*$/.test(name)) {
            $('#tips_dialog').show().on('click', '.weui_btn_dialog', function () {
                $('#tips_dialog').hide();
            });
            $('#tips_dialog .content').html('姓名不能为空');
            return false;
        }
        if (!/^\d{11}$/.test(mobile)) {
            $('#tips_dialog').show().on('click', '.weui_btn_dialog', function () {
                $('#tips_dialog').hide();
            });
            $('#tips_dialog .content').html('手机格式错误');
            return false;
        }
        return true;
    }

    function jsApiCall(params)
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            params,
            function(res){
                WeixinJSBridge.log(res.err_msg);
                alert(res.err_code+res.err_desc+res.err_msg);
            }
        );
    }
//这里有一个很大的问题 模板和数据不能互相通信 后期将要使用vue.js模板绑定数据  或者使用其他的模板引擎
</script>