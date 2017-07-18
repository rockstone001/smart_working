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
                    <a href="<?php echo config_item('index_url') . '/store/index'?>">卖场管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑卖场'; else echo '新卖场';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/store/edit/' . $id; else echo config_item('index_url') . '/store/new_store';?>" id="store_form">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑卖场'; else echo '新卖场';?></legend>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">卖场名</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="name" name="name" type="text" value="<?php if (isset($name)) echo $name;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">所属城市</label>
                            <div class="controls">
                                <select name="city_id" id="city_id">
                                    <?php foreach ($cities as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($city_id) && $city_id == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">地址</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="address" name="address" type="text" value="<?php if (isset($address)) echo $address;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">联系电话</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="telephone" name="telephone" type="text" value="<?php if (isset($telephone)) echo $telephone;?>">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" id="submit_btn">保存</button>
                            <button type="reset" class="btn"><a href="<?php echo config_item('index_url') . '/store/index'; ?>">取消</a></button>
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