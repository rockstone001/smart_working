<?php
//print_r($roles); die();
?>

<div class="row-fluid">
    <div class="alert alert-success" id="msg">
<!--        <button type="button" class="close" data-dismiss="alert">&times;</button>-->
        <h4>Success</h4>
    </div>

    <div class="block">
        <div class="navbar navbar-inner block-header">
            <ul class="breadcrumb">
                <i class="icon-chevron-left hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
                <i class="icon-chevron-right show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
                <li class="active">
                    <!--                    <a href="#">Dashboard</a> <span class="divider">/</span>-->
                    <a href="<?php echo config_item('index_url') . '/user/index'?>">用户管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑用户'; else echo '新用户';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/user/edit/' . $id; else echo config_item('index_url') . '/user/new_user';?>" id="user_form">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑用户'; else echo '新用户';?></legend>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">用户名</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="username" name="username" type="text" value="<?php if (isset($username)) echo $username;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">员工编号</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="employee_id" name="employee_id" type="text" value="<?php if (isset($employee_id)) echo $employee_id;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">密码</label>
                            <div class="controls">
                                <input class="input-xxlarge" id="password" name="password" type="password" value="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">密码确认</label>
                            <div class="controls">
                                <input class="input-xxlarge" id="re-password" name="re-password" type="password" value="">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">手机号</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="mobile" name="mobile" type="text" value="<?php if (isset($mobile)) echo $mobile;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">电子邮箱</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="email" name="email" type="text" value="<?php if (isset($email)) echo $email;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">家庭住址</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="address" name="address" type="text" value="<?php if (isset($address)) echo $address;?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">角色</label>
                            <div class="controls">
                                <select name="role_id" id="role_id">
                                    <?php foreach ($roles as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($role_id) && $role_id == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">所属分公司</label>
                            <div class="controls">
                                <select name="company_id" id="company_id">
                                    <?php foreach ($companies as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($company_id) && $company_id == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">所属城市</label>
                            <div class="controls">
                                <select name="city_id" id="city_id">
                                    <?php foreach ($cities as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($city_id) && $city_id == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">所属卖场</label>
                            <div class="controls">
                                <select name="store_id" id="store_id">
                                    <?php foreach ($stores as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($store_id) && $store_id == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">所属部门</label>
                            <div class="controls">
                                <select name="department" id="department">
                                    <?php foreach ($departments as $v) {?>
                                        <option value="<?php echo $v;?>" <?php if(isset($department) && $department == $v) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">所在职位</label>
                            <div class="controls">
                                <select name="position" id="position">
                                    <?php foreach ($positions as $v) {?>
                                        <option value="<?php echo $v;?>" <?php if(isset($position) && $position == $v) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group" style="height: 0px; border-top: 1px dashed #d6d6d6;">
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">头像</label>
                            <div class="controls">
                                <?php
                                    if (!empty($headimgurl)) {
                                ?><img style="width: 100px;" src="<?php echo $headimgurl;?>"><?php }?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="focusedInput">昵称</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" type="text" value="<?php if (isset($nickname)) echo $nickname;?>" id="nickname" readonly="readonly">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">性别</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" type="text" value="<?php if (empty($sex)) echo '未知'; elseif ($sex == 1) echo '男'; else echo '女';?>" id="sex" readonly="readonly">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">国家</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" type="text" value="<?php if (isset($country)) echo $country;?>" id="country" readonly="readonly">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">省份</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" type="text" value="<?php if (isset($province)) echo $province;?>" id="province" readonly="readonly">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">城市</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" type="text" value="<?php if (isset($city)) echo $city;?>" id="city" readonly="readonly">
                            </div>
                        </div>
                        <div class="control-group" style="height: 0px; border-top: 1px dashed #d6d6d6;">
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="focusedInput">身份证照片</label>
                            <div class="controls">
                                <?php
                                if (!empty($ID_photo1)) {
                                    ?><img style="width: 100px;" src="<?php echo $ID_photo1;?>"><?php }
                                if (!empty($ID_photo2)) {
                                    ?><img style="width: 100px;" src="<?php echo $ID_photo2;?>"><?php }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">工资卡照片</label>
                            <div class="controls">
                                <?php
                                if (!empty($salary_photo1)) {
                                    ?><img style="width: 100px;" src="<?php echo $salary_photo1;?>"><?php }
                                if (!empty($salary_photo2)) {
                                    ?><img style="width: 100px;" src="<?php echo $salary_photo2;?>"><?php }
                                ?>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" id="submit_btn">保存</button>
                            <button type="reset" class="btn"><a href="<?php echo config_item('index_url') . '/user/index'; ?>">取消</a></button>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
<script>
    var company_city_store = <?php echo json_encode($company_city_store);?>;
    var cities = <?php echo json_encode($cities, JSON_FORCE_OBJECT)?>;
    var stores = <?php echo json_encode($stores, JSON_FORCE_OBJECT)?>;
</script>

<!--操作提示 Modal -->
<div class="modal fade" id="operate_dialog" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">操作提示</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">确定</button>
            </div>
        </div>
    </div>
</div>