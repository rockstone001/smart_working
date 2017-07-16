<style>
    .no-margin-top {
        margin-top: 0px;
    }
    .weui-mask {
        /*display: none;*/
    }
    #detail_title {
        float: left;
    }
    #join_form .title {
        position: absolute;
        width: 100%;
        text-align: center;
        left: 0px;
        z-index: -1;
    }
    #mine_link {
        width: auto;
        color :#000;
        font-size: 15px;
        height: 24px;
        line-height: 24px;
        float: right;
        margin-right: 10px;
    }
    .toolbar .toolbar-inner {
        z-index: 99999;
    }
    .toolbar .picker-button {
        z-index: 99999;
    }
    .red {
        color:red;
    }
</style>
<!--活动详情 模板 -->
<script type="text/html" id="tpl_home">
    <div class="page tabbar" id="join_form">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <div class="weui-navbar p-relative">
                        <div class="weui-navbar__item my_navbar">
                            <h4 class="title">编辑个人信息<?php //echo $lesson['title']?></h4>
                            <a class="mui-icon mui-icon-left-nav" id="detail_title" href="javascript:;"></a>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="bd">
                            <div class="weui-cells weui-cells_form no-margin-top">
                                <form id="profile_form">
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label"><span class="red">*</span>姓名</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input name="username" id="username" class="weui-input" type="text" placeholder="请输入姓名" value="<?php if(isset($userinfo['username'])) echo $userinfo['username'];?>">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label"><span class="red">*</span>性别</label></div>
                                    <div class="weui-cell__bd">
                                        <input class="weui-input" name="gender" id="gender" type="text" value="<?php if(isset($userinfo['gender'])) echo $userinfo['gender'];?>" placeholder="请选择">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label"><span class="red">*</span>出生日期</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input class="weui_input weui-input" name="birthday" id="birthday" type="text" value="<?php if(isset($userinfo['birthday'])) echo $userinfo['birthday'];?> " placeholder="请选择">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label"><span class="red">*</span>常住地址</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input class="weui_input weui-input" name="location" id="location" type="text" value="<?php if(isset($userinfo['location'])) echo $userinfo['location'];?>" placeholder="请选择">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><label class="weui-label"><span class="red">*</span>手机号码</label></div>
                                    <div class="weui-cell__bd weui-cell_primary">
                                        <input name="mobile" id="mobile" class="weui-input" type="number" pattern="[0-9]*" placeholder="请输入电话号码" value="<?php if(isset($userinfo['mobile'])) echo $userinfo['mobile'];?>">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label">身份证号码</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input class="weui_input weui-input" name="IDCard" id="IDCard" type="text" value="<?php if(isset($userinfo['IDCard'])) echo $userinfo['IDCard'];?>" placeholder="请输入身份证号">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label">微信</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input class="weui_input weui-input" name="wechat" id="wechat" type="text" value="<?php if(isset($userinfo['wechat'])) echo $userinfo['wechat'];?>" placeholder="请输入微信">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label">邮箱</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input class="weui_input weui-input" name="email" id="email" type="text" value="<?php if(isset($userinfo['email'])) echo $userinfo['email'];?>" placeholder="请输入邮箱">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label"><span class="red">*</span>学历</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input class="weui-input" name="education" id="education" type="text" value="<?php if(isset($userinfo['education'])) echo $userinfo['education'];?>" placeholder="请选择">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label">毕业院校</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input name="academy" id="academy" class="weui-input" type="text" placeholder="请输入毕业院校" value="<?php if(isset($userinfo['academy'])) echo $userinfo['academy'];?>">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label">专业</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input name="major" id="major" class="weui-input" type="text" placeholder="请输入专业" value="<?php if(isset($userinfo['major'])) echo $userinfo['major'];?>">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label"><span class="red">*</span>学员类别</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input class="weui-input" name="type" id="type" type="text" value="<?php if(isset($userinfo['type'])) echo $userinfo['type'];?>" placeholder="请选择">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label"><span class="red">*</span>从医年限</label></div>
                                    <div class="weui_cell__bd weui-cell_primary">
                                        <input class="weui-input" name="years" id="years" type="text" value="<?php if(isset($userinfo['years'])) echo $userinfo['years'];?>" placeholder="请选择">
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd" style="width: 100%"><label class="weui-label" style="width: 100%"><span class="red">*</span>曾参加中医课程</label></div>
                                </div>
                                <div class="weui-cells weui-cells_form">
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd">
                                            <textarea class="weui-textarea" placeholder="请输入曾参加的中医课程(没有, 请填写: 无) " rows="3" name="lessons" id="lessons"><?php if(isset($userinfo['lessons'])) echo $userinfo['lessons'];?></textarea>
                                            <div class="weui-textarea-counter"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui_cell__hd"><label class="weui-label">对课程期望</label></div>
                                </div>
                                <div class="weui-cells weui-cells_form">
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd">
                                            <textarea class="weui-textarea" placeholder="请输入对课程的期望" rows="3" name="msg" id="msg"><?php if(isset($userinfo['msg'])) echo $userinfo['msg'];?></textarea>
                                            <div class="weui-textarea-counter"></div>
                                        </div>
                                    </div>
                                </div>
                                </form>

                            </div>
                            <label class="weui-agree weui-agree__text">
                                红色 <span class="red">*</span> 项表示必填项
                            </label>
                            <div class="weui-btn-area">
                                <a class="weui-btn weui-btn_primary" href="javascript:" id="saveProfile">保存个人信息</a>
                            </div>
                        </div>
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
            <p class="weui-toast__content">正在保存...</p>
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
            $('#detail_title').on('click', function(){
                <?php if (empty($lesson_id)) { ?>
                location.href = '<?php echo config_item('index_url')?>/home/profile';
                <?php } else { ?>
                location.href = '<?php echo config_item('index_url')?>/home/detail?id=<?php echo $lesson_id?>';
                <?php }?>
            });
            FastClick.attach(document.body);
            $('#join_form textarea').on('click', function(){
                $(this).focus();
//                $(this)[0].selectionStart = $(this)[0].value.length;
            });
            $('#join_form .weui-input').on('click', function(){
                $(this).focus();
            });
            $('.js_item').on('click', function(){
                var link = $(this).data('link');
                window.pageManager.go(link);
            });
            $("#location").cityPicker({
                title: "选择出生地",
                showDistrict: false
            });
            $("#gender").picker({
                title: "请选择性别",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['男', '女']
                    }
                ],
                onChange: function(p, v, dv) {
                },
                onClose: function(p, v, d) {
                }
            });

            $("#birthday").datetimePicker({
                times: function () {
                    return [
                    ];
                },
                onChange: function (picker, values, displayValues) {
                },
            });

            $('#education').picker({
                title: "请选择学历",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['博士', '硕士', '本科', '专科', '高中', '中专', '初中']
                    }
                ],
                inputValue: '本科',
                onChange: function(p, v, dv) {
                },
                onClose: function(p, v, d) {
                }
            });

            $('#type').picker({
                title: "请选择学员类型",
                cols: [
                    {
                        textAlign: 'center',
                        values: ['中医爱好者', '养生行业从业人员', '中医诊所医师', '医院医师', '其他']
                    }
                ],
                inputValue: '本科',
                onChange: function(p, v, dv) {
                },
                onClose: function(p, v, d) {
                }
            });
            $('#years').picker({
                title: "请选择从医年限",
                cols: [
                    {
                        textAlign: 'center',
                        values: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30]
                    }
                ],
                inputValue: '本科',
                onChange: function(p, v, dv) {
                },
                onClose: function(p, v, d) {
                }
            });

            $('#saveProfile').on('click', function(){
//                console.log($('#profile_form').serialize());
                if (check_order_submit()) {
                    $('#loadingToast').show();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo config_item('index_url')?>/home/profile_save',
                        data: $('#profile_form').serialize(),
                        dataType: 'json',
                        success: function(data) {
                            $('#loadingToast').hide();
                            $('#tips_dialog .title').html('操作提示');
    //                        console.log(data);
                            if (data.code == 0) {
                                $('#tips_dialog .content').html('保存成功');
                                $('#tips_dialog').show();
                                $('#tips_dialog .weui-dialog__btn').on('click', function() {
                                    <?php if (empty($lesson_id)) { ?>
                                    location.href = '<?php echo config_item('index_url')?>/home/profile';
                                    <?php } else { ?>
                                    location.href = '<?php echo config_item('index_url')?>/home/join?id=<?php echo $lesson_id?>';
                                    <?php }?>
                                });
                            } else {
                                $('#tips_dialog .content').html(data.msg);
                                $('#tips_dialog').show();
                            }
                        },
                        error: function() {
                            $('#loadingToast').hide();
                        }
                    })
                }
            });
            $('#tips_dialog .weui-dialog__btn').on('click', function() {
                $('#tips_dialog').hide();
            });

        });
        function check_order_submit() {
            var name = $('#username').val();
            var gender = $('#gender').val();
            var mobile = $('#mobile').val();
            var type = $('#type').val();
            var years = $('#years').val();
            var lessons = $('#lessons').val();
            var location = $('#location').val();
            var birthday = $('#birthday').val();
            var education = $('#education').val();

            $('#tips_dialog .title').html('错误提示');
            if (/^\s*$/.test(name)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('姓名不能为空');
                return false;
            }
            if (/^\s*$/.test(gender)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('性别不能为空');
                return false;
            }
            if (/^\s*$/.test(birthday)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('出生日期不能为空');
                return false;
            }
            if (/^\s*$/.test(location)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('常住地址不能为空');
                return false;
            }
            if (!/^\d{11}$/.test(mobile)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('手机格式错误');
                return false;
            }
            if (/^\s*$/.test(education)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('学历不能为空');
                return false;
            }
            if (/^\s*$/.test(type)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('学员类别不能为空');
                return false;
            }
            if (/^\s*$/.test(years)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('从医年限不能为空');
                return false;
            }
            if (/^\s*$/.test(lessons)) {
                $('#tips_dialog').show().on('click', '.weui-dialog__btn', function () {
                    $('#tips_dialog').hide();
                });
                $('#tips_dialog .content').html('曾参加中医课程不能为空');
                return false;
            }
            return true;
        }
</script>
</script>
