<!--订单列表页 模板-->
<script type="text/html" id="tpl_home">
    <div class="page tabbar">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <?php include(VIEWPATH . 'include/mine_header.php')?>
                    <div class="seperator"></div>
                    <div class="page__bd">
                        <div class="weui-cells__title">我的信息</div>
                        <div class="cell">
                            <div class="bd">
                                <div class="weui-cells no-margin-top">
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">姓名</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['username'])) echo $userinfo['username'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">性别</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['gender'])) echo $userinfo['gender'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">出生日期</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['birthday'])) echo $userinfo['birthday'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">常驻地址</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['location'])) echo $userinfo['location'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">手机号码</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['mobile'])) echo $userinfo['mobile'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">身份证号码</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['IDCard'])) echo $userinfo['IDCard'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">微信</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['wechat'])) echo $userinfo['wechat'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">邮箱</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['email'])) echo $userinfo['email'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">学历</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['education'])) echo $userinfo['education'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">毕业院校</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['academy'])) echo $userinfo['academy'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">专业</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['major'])) echo $userinfo['major'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">学员类别</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['type'])) echo $userinfo['type'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">从医年限</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['years'])) echo $userinfo['years']; else echo '0'?>年</div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">曾参加中医课程</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['lessons'])) echo $userinfo['lessons'];?></div>
                                    </div>
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd"><label class="weui-label">对课程期望</label></div>
                                        <div class="weui-cell__ft"><?php if(isset($userinfo['msg'])) echo $userinfo['msg'];?></div>
                                    </div>
                                    <div class="weui-btn-area">
                                        <a class="weui-btn weui-btn_primary" href="javascript:" id="editProfile">编辑个人信息</a>
                                    </div>
                                    <p style="height: 30px;"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include(VIEWPATH . 'include/footer.php')?>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#editProfile').on('click', function() {
                location.href = '<?php echo config_item('index_url')?>/home/profile_edit';
            });
        });
    </script>
</script>
