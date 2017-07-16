<!--验证员工信息首页 模板-->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-cells weui-cells_form" style="background-color: #efeff6;">
                <div class="page__bd">
                    <div class="weui-cells__title">个人头像</div>
                    <div class="weui-cells">
                        <div class="weui-cell">
                            <div class="weui-uploader">
                                <div class="weui-uploader__bd">
                                    <ul class="weui-uploader__files" style="float: left;" id="headerUploaderFiles">
                                        <?php if (!empty($user['headimgurl'])) {?>
                                            <li class="weui-uploader__file" style="">
                                                <img src="<?php echo $user['headimgurl'];?>" style="width: 79px; height: 79px;"/>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="weui-uploader__input-box" style="display: <?php if (empty($user['headimgurl'])) echo ''; else echo 'none'?>">
                                        <input id="headerUploader" class="weui-uploader__input" type="file" accept="image/*" multiple="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="weui-cells__title">身份证正反面</div>
                    <div class="weui-cells">
                        <div class="weui-cell">
                            <div class="weui-uploader">
                                <div class="weui-uploader__bd">
                                    <ul class="weui-uploader__files" id="IDUploaderFiles" style="float: left;">
                                        <?php if (!empty($userinfo['ID_photo1'])) {?>
                                        <li class="weui-uploader__file" style="">
                                            <img src="<?php echo $userinfo['ID_photo1'];?>" style="width: 100%;" id="ID_photo1"/>
                                        </li>
                                        <?php } if (!empty($userinfo['ID_photo2'])) {?>
                                        <li class="weui-uploader__file" style="">
                                            <img src="<?php echo $userinfo['ID_photo2'];?>" style="width: 100%;" id="ID_photo2"/>
                                        </li>
                                        <?php }?>
                                    </ul>
                                    <div class="weui-uploader__input-box" style="display: <?php if (empty($userinfo['ID_photo1']) || empty($userinfo['ID_photo2'])) echo ''; else echo 'none'?>">
                                        <input id="IDUploader" class="weui-uploader__input" type="file" accept="image/*" multiple="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">身份证</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" id="IDCard" placeholder="请输入身份证号码" value="<?php if (!empty($userinfo['IDCard'])) echo $userinfo['IDCard'];?>">
                            </div>
                        </div>
                    </div>

                    <div class="weui-cells__title">工资卡正反面</div>
                    <div class="weui-cells">
                        <div class="weui-cell">
                            <div class="weui-uploader">
                                <div class="weui-uploader__bd">
                                    <ul class="weui-uploader__files" id="salaryUploaderFiles" style="float: left;">
                                        <?php if (!empty($userinfo['salary_photo1'])) {?>
                                            <li class="weui-uploader__file" style="">
                                                <img src="<?php echo $userinfo['salary_photo1'];?>" style="width: 100%;" id="salary_photo1"/>
                                            </li>
                                        <?php } if (!empty($userinfo['salary_photo2'])) {?>
                                            <li class="weui-uploader__file" style="">
                                                <img src="<?php echo $userinfo['salary_photo2'];?>" style="width: 100%;" id="salary_photo2"/>
                                            </li>
                                        <?php }?>
                                    </ul>
                                    <div class="weui-uploader__input-box" style="display: <?php if (empty($userinfo['salary_photo1']) || empty($userinfo['salary_photo2'])) echo ''; else echo 'none'?>">
                                        <input id="salaryUploader" class="weui-uploader__input" type="file" accept="image/*" multiple="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">工资卡</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" id="salary_card" placeholder="请输入工资卡卡号" value="<?php if (!empty($userinfo['salary_card'])) echo $userinfo['salary_card'];?>">
                            </div>
                        </div>
                    </div>

                    <div class="weui-cells__title">员工基本信息</div>
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" id="username" placeholder="请输入姓名" value="<?php if (!empty($user['username'])) echo $user['username'];?>">
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">电子邮箱</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" id="email" placeholder="请输入电子邮箱" value="<?php if (!empty($user['email'])) echo $user['email'];?>">
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">手机号码</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" id="mobile" placeholder="请输入手机号码" value="<?php if (!empty($user['mobile'])) echo $user['mobile'];?>">
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">住宅地址</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" type="text" id="address" placeholder="请输入住宅地址" value="<?php if (!empty($user['address'])) echo $user['address'];?>">
                            </div>
                        </div>
                    </div>
                    <div class="weui-btn-area">
                        <a class="weui-btn weui-btn_primary" href="javascript:" id="submitBtn">修改</a>
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
            <div class="weui-dialog__hd"><strong class="weui-dialog__title title">操作提示</strong></div>
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
            var img_serverID = {};
            var img_localID = {};
            var img_key = [];
            //身份证上传
            $('#IDUploaderFiles li img').on('click', choose_one_ID);
            $('#IDUploader').on('click', choose_ID);

            //工资卡上传
            $('#salaryUploaderFiles li img').on('click', choose_one_ID);
            $('#salaryUploader').on('click', choose_salary);

            //头像上传
            $('#headerUploader').on('click', choose_header);
            $('#headerUploaderFiles li img').on('click', choose_header);


            //确认修改
            $('#submitBtn').on('click', function() {
                for (var key in img_localID) {
                    img_key.push(key);
                }
                upload2Weixin();
            });

            $('#tips_dialog .weui-dialog__btn').on('click', function() {
                $('#tips_dialog').hide();
            });

            //为确保上传图片的正确性, 使用串行上传
            function upload2Weixin()
            {
                var key = img_key.shift();
                if (key) {
                    wx.uploadImage({
                        localId: img_localID[key], // 需要上传的图片的本地ID，由chooseImage接口获得
                        isShowProgressTips: 1, // 默认为1，显示进度提示
                        success: function (res) {
                            img_serverID[key] = res.serverId; // 返回图片的服务器端ID
                            upload2Weixin();
                        }
                    });
                } else {
                    submit2Server();
                }

            }

            function submit2Server()
            {
                $('#loadingToast').show();
                var data = {
                    username: $('#username').val(),
                    mobile: $('#mobile').val(),
                    email: $('#email').val(),
                    address: $('#address').val(),
                    IDCard: $('#IDCard').val(),
                    salary_card: $('#salary_card').val()
                };
                for (var key in img_serverID) {
                    data[key] = img_serverID[key];
                }
                $.post('<?php echo config_item('index_url')?>/user/modify', data, function(data) {
                    $('#loadingToast').hide();
                    if (data.code == 0) {
                        $('#tips_dialog .content').html(data.msg);
                        $('#tips_dialog').show();
                    }
                }, 'json');
            }

            function choose_ID()
            {
                var count = 2 - $('#IDUploaderFiles li').length;
                wx.chooseImage({
                    count: count,
                    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['album'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        //var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                        var html = '';
                        var index_first = $('#IDUploaderFiles li').length + 1;
                        if (window.__wxjs_is_wkwebview) {
                            //ios
                            for (var key in res.localIds) {
                                var index_current = index_first;
                                img_localID['ID_photo' + index_current] = res.localIds[key];
                                html += '<li id="headimg" class="weui-uploader__file" style=""><img src="" style="width: 79px; height: 79px;" id="ID_photo' + (index_first ++) + '" /></li>';
                                //显示图片
                                (function(index){
                                    wx.getLocalImgData({
                                        localId: res.localIds[key], // 图片的localID
                                        success: function (res) {
                                            var localData = res.localData; // localData是图片的base64数据，可以用img标签显示
                                            $('#ID_photo' + index).attr('src', localData);
                                        }
                                    });
                                })(index_current);

                            }
                        } else {
                            //安卓
                            for (var key in res.localIds) {
                                img_localID['ID_photo' + index_first] = res.localIds[key];
                                html += '<li class="weui-uploader__file" style=""><img src="' + res.localIds[key] + '" style="width: 79px; height: 79px;" id="ID_photo' + (index_first ++) + '"/></li>';
                            }
                        }

                        $('#IDUploaderFiles').html($('#IDUploaderFiles').html() + html);
                        if ($('#IDUploaderFiles li').length >= 2) {
                            $('#IDUploader').parent().hide();
                        }
                        $('#IDUploaderFiles li img').on('click', choose_one_ID);
                    },
                    fail: function (res) {
                        alert(res.errMsg);
                    }
                });
            }

            function choose_one_ID()
            {
                var parent = $(this).parent();
                var id = $(this).attr('id');
                wx.chooseImage({
                    count: 1,
                    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['album'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        //var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                        var html = '';
                        if (window.__wxjs_is_wkwebview) {
                            //ios
                            for (var key in res.localIds) {
                                img_localID[id] = res.localIds[key];
                                html += '<img src="" style="width: 79px; height: 79px;" id="' + id + '" />';
                                //显示图片
                                wx.getLocalImgData({
                                    localId: res.localIds[key], // 图片的localID
                                    success: function (res) {
                                        var localData = res.localData; // localData是图片的base64数据，可以用img标签显示
                                        $('#' + id).attr('src', localData);
                                    }
                                });
                            }
                        } else {
                            //安卓
                            for (var key in res.localIds) {
                                img_localID[id] = res.localIds[key];
                                html += '<img src="' + res.localIds[key] + '" style="width: 79px; height: 79px;" id="' + id + '"/>';
                            }
                        }

                        parent.html(html);
                        $('#' + id).on('click', choose_one_ID);
                    },
                    fail: function (res) {
                        alert(res.errMsg);
                    }
                });
            }

            function choose_salary()
            {
                var count = 2 - $('#salaryUploaderFiles li').length;
                wx.chooseImage({
                    count: count,
                    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['album'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        //var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                        var html = '';
                        var index_first = $('#salaryUploaderFiles li').length + 1;
                        if (window.__wxjs_is_wkwebview) {
                            //ios
                            for (var key in res.localIds) {
                                var index_current = index_first;
                                img_localID['salary_photo' + index_current] = res.localIds[key];
                                html += '<li id="headimg" class="weui-uploader__file" style=""><img src="" style="width: 79px; height: 79px;" id="salary_photo' + (index_first ++) + '" /></li>';
                                //显示图片
                                (function(index){
                                    wx.getLocalImgData({
                                        localId: res.localIds[key], // 图片的localID
                                        success: function (res) {
                                            var localData = res.localData; // localData是图片的base64数据，可以用img标签显示
                                            $('#salary_photo' + index).attr('src', localData);
                                        }
                                    });
                                })(index_current);

                            }
                        } else {
                            //安卓
                            for (var key in res.localIds) {
                                img_localID['salary_photo' + index_first] = res.localIds[key];
                                html += '<li class="weui-uploader__file" style=""><img src="' + res.localIds[key] + '" style="width: 79px; height: 79px;" id="salary_photo' + (index_first ++) + '"/></li>';
                            }
                        }

                        $('#salaryUploaderFiles').html($('#salaryUploaderFiles').html() + html);
                        if ($('#salaryUploaderFiles li').length >= 2) {
                            $('#salaryUploader').parent().hide();
                        }
                        $('#salaryUploaderFiles li img').on('click', choose_one_ID);
                    },
                    fail: function (res) {
                        alert(res.errMsg);
                    }
                });
            }

            function choose_header(){
                wx.chooseImage({
                    count: 1, // 默认9
                    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                    sourceType: ['album'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        //var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                        var html = '';
                        if (window.__wxjs_is_wkwebview) {
                            //ios
                            for (var key in res.localIds) {
                                img_localID.headimgurl = res.localIds[key];
                                html += '<li id="headimg" class="weui-uploader__file" style=""><img src="" style="width: 79px; height: 79px;" id="header_img_' + key + '" /></li>';
                                //显示图片
                                wx.getLocalImgData({
                                    localId: res.localIds[key], // 图片的localID
                                    success: function (res) {
                                        var localData = res.localData; // localData是图片的base64数据，可以用img标签显示
                                        $('#header_img_' + key).attr('src', localData);
                                    }
                                });
                            }

                        } else {
                            //安卓
                            for (var key in res.localIds) {
                                img_localID.headimgurl = res.localIds[key];
                                html += '<li id="headimg" class="weui-uploader__file" style=""><img src="' + res.localIds[key] + '" style="width: 79px; height: 79px;"/></li>';
                            }
                        }
                        $('#headerUploaderFiles').html(html);
                        $('#headerUploader').parent().hide();
                        $('#headerUploaderFiles li img').on('click', choose_header);
                    },
                    fail: function (res) {
                        alert(res.errMsg);
                    }
                });
            }
        });
    </script>
</script>

<script>
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
        jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone',
            'chooseImage', 'previewImage', 'getLocalImgData', 'uploadImage'
        ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
    wx.ready(function(){
        //分享给朋友
        wx.onMenuShareAppMessage({
            title: '<?php echo 'ceshi';?>', // 分享标题
            desc: '<?php echo 'desc';?>', // 分享描述
            link: '<?php echo config_item('index_url') . '/home/index';?>', // 分享链接
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
            title: '<?php echo 'test';?>', // 分享标题
            link: '<?php echo config_item('index_url') . '/home/index'?>', // 分享链接
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

