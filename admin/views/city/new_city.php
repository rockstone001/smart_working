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
                    <a href="<?php echo config_item('index_url') . '/city/index'?>">城市管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑城市'; else echo '新城市';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/city/edit/' . $id; else echo config_item('index_url') . '/city/new_city';?>" id="city_form">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑城市'; else echo '新城市';?></legend>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">城市名</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="name" name="name" type="text" value="<?php if (isset($name)) echo $name;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">所属分公司</label>
                            <div class="controls">
                                <select name="company_id" id="company_id">
                                    <?php foreach ($companies as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($company_id) && $company_id == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" id="submit_btn">保存</button>
                            <button type="reset" class="btn"><a href="<?php echo config_item('index_url') . '/city/index'; ?>">取消</a></button>
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