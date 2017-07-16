<div class="row-fluid">
    <div class="alert alert-success" id="msg" style="<?php if ($if_show_tips) echo 'display:block';?>">
<!--        <button type="button" class="close" data-dismiss="alert">&times;</button>-->
        <h4>保存成功</h4>
    </div>

    <div class="block">
        <div class="navbar navbar-inner block-header">
            <ul class="breadcrumb">
                <i class="icon-chevron-left hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
                <i class="icon-chevron-right show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
                <li class="active">
                    <!--                    <a href="#">Dashboard</a> <span class="divider">/</span>-->
                    <a href="<?php echo config_item('index_url') . '/role/index'?>">角色管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    分配权限
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php echo config_item('index_url') . '/role/assign/' . $id;?>" id="role_form">
                    <fieldset>
                        <legend></legend>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">角色</label>
                            <div class="controls">
                                <label class="inline" style="margin-bottom: 0px;padding-top: 5px;">
                                    <?php echo $role['name'] . '(' . $role['desc'] . ')';?>
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">权限</label>
                            <div class="controls">
                                <?php foreach ($privileges as $p) {?>
                                <label class="checkbox inline">
                                    <input type="checkbox" name="privileges[]" value="<?php echo $p['id']?>" <?php if (in_array($p['id'], $privilege_selected)) echo 'checked';?> ><?php echo $p['desc']?>
                                </label>
                                <?php }?>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" id="submit_btn">保存</button>
                            <button type="reset" class="btn"><a href="<?php echo config_item('index_url') . '/role/index'; ?>">取消</a></button>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>

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