<div class="row-fluid">
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Success</h4>
    </div>

    <div class="block">
        <div class="navbar navbar-inner block-header">
            <ul class="breadcrumb">
                <i class="icon-chevron-left hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
                <i class="icon-chevron-right show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
                <li class="active">
                    <!--                    <a href="#">Dashboard</a> <span class="divider">/</span>-->
                    <a href="<?php echo config_item('index_url') . '/menu/index'?>">菜单管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑菜单'; else echo '新菜单';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/menu/edit/' . $id; else echo config_item('index_url') . '/menu/new_menu';?>">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑菜单'; else echo '新菜单';?></legend>

                        <div class="control-group">
                            <label class="control-label" for="focusedInput">菜单名</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="name" name="name" type="text" value="<?php if (isset($name)) echo $name;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">链接</label>
                            <div class="controls">
<!--                                <input class="input-xxlarge focused" id="link" name="link" type="text" value="--><?php //if (isset($link)) echo $link;?><!--">-->
                                <select name="link" id="link">
                                    <?php foreach ($links as $v) {?>
                                        <option value="<?php echo $v['link'];?>" <?php if(isset($link) && $link == $v['link']) echo 'selected'; ?>><?php echo $v['title'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="focusedInput">自定义链接</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="custom_link" name="custom_link" type="text" value="<?php if (isset($custom_link)) echo $custom_link;?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">父菜单</label>
                            <div class="controls">
                                <select name="parent_id" id="parent_id">
                                    <?php foreach ($menu as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($parent_id) && $parent_id == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="focusedInput">排列顺序</label>
                            <div class="controls">
                                <input class="input-large focused" id="sequence" name="sequence" type="text" value="<?php if (isset($sequence)) echo $sequence;?>">
                            </div>
                        </div>


                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="reset" class="btn"><a href="<?php echo config_item('index_url') . '/menu/index'; ?>">取消</a></button>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- 以下两个元素 是上传图片使用的 -->
<form action="<?php echo config_item('index_url') . '/common/upload/top.setImagePath'?>" enctype="multipart/form-data" method="POST" target="upload_iframe" id="upload_form" style="display:none">
</form>
<iframe style="display:none;width:0;height:0;border:0;margin:0;padding:0;position:absolute;" name="upload_iframe"
        id="upload_iframe"></iframe>

