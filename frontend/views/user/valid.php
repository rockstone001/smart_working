<!--验证员工信息首页 模板-->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <div class="page__bd center">
                        <p><img src="<?php echo config_item('img_url')?>/logo_basichouse.jpg" style="width: 30%; margin-top: 30%;"/></p>
                        <p class="title2">SMART WORKING</p>
                        <p class="sub_title2">智能办公平台</p>
                        <a href="javascript:;" class="weui-btn weui-btn_default js_item a" data-link="detail">员工信息验证</a>
                    </div>
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

<!--验证员工信息 模板 -->
<script type="text/html" id="tpl_detail">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <div class="weui-navbar p-relative">
                        <div class="weui-navbar__item my_navbar">
                            <a class="js_item mui-icon mui-icon-left-nav" id="detail_title" data-link="home"></a>
                            <h4 class="title">员工信息验证</h4>
                        </div>
                    </div>
                    <div class="weui-panel__bd detail_text">
                        <div class="weui-cells weui-cells_form">
                            <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
                            <div class="weui-cell__bd">
                            <input class="weui-input" type="text" placeholder="请输入姓名" id="username">
                            </div>
                            </div>
                            <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">员工编号</label></div>
                            <div class="weui-cell__bd">
                            <input class="weui-input" type="text" placeholder="请输入员工编号" id="employee_id">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="weui-btn-area">
                    <a class="weui-btn weui-btn_primary" href="javascript:" id="vButton">验证</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- loading toast -->
    <div id="loadingToast" style="display: none;">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
    <i class="weui-loading weui-icon_toast"></i>
    <p class="weui-toast__content">正在验证...</p>
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
        var get_code_timer = 0;
        $('#get_vcode_btn').on('click', function() {
            if (get_code_timer == 0) {
                $(this).addClass('gray');
                get_code_timer = 30;
                djs()
            }
        });
        function djs() {
            if (--get_code_timer > 0) {
                $('#get_vcode_btn').html('获取验证码(' + get_code_timer + ')');
                setTimeout(djs, 1000);
            } else {
                $('#get_vcode_btn').html('获取验证码');
                $('#get_vcode_btn').removeClass('gray');
            }
        }

        $('#vButton').on('click', function(){
            var username = $('#username').val();
            var employee_id = $('#employee_id').val();

            $('#tips_dialog .title').html('错误提示');
            if (/^\s*$/.test(username)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('姓名不能为空');
                return false;
            }
            if (/^\s*$/.test(employee_id)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('员工编号不能为空');
                return false;
            }

            $('#loadingToast').show();
            $.post('<?php echo config_item('index_url')?>/user/valid', {
                username: username,
                employee_id: employee_id
            }, function(data) {
                $('#loadingToast').hide();
                $('#tips_dialog .content').html(data.msg);
                if (data.code == '0' ) {
                    $('#tips_dialog .title').html('操作提示');
                    $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                        $('#tips_dialog').hide();
                        location.href = '<?php echo config_item('index_url')?>/home/index';
                    });
                } else {
                    $('#tips_dialog .title').html('错误提示');
                    $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                        $('#tips_dialog').hide();
                    });
                }
            }, 'json');
        });
    });
</script>
</script>

