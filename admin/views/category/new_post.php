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
                    <a href="<?php echo config_item('index_url') . '/category/index'?>">分类管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑分类'; else echo '新分类';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/category/edit/' . $id; else echo config_item('index_url') . '/category/new_cate';?>">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑分类'; else echo '新分类';?></legend>

                        <div class="control-group">
                            <label class="control-label" for="focusedInput">分类名</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="name" name="name" type="text" value="<?php if (isset($name)) echo $name;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">配图</label>
                            <div class="controls" id="upload_wrapper">
                                <input multiple="multiple" id="pic_upload" type="file" name="pic_upload" value="" style="display: none;"/>
                                <button class="btn btn-success" type="button" id="pic_upload_btn">上传图片</button>
                                <ul class="image-list filesContainer">
                                    <?php if(!empty($main_pic)) {?>
                                    <li class="fileContainer"><a class="close" href="###" onclick="$(this).parent().remove();$('#pic_url').hide();$('#main_pic').val('');">X</a><span><?php
                                            $tmp = pathinfo($main_pic);
                                            if (isset($tmp['basename'])) echo $tmp['basename'];
                                            ?></span><p><a href="<?php echo $main_pic;?>" target="_blank"><img src="<?php echo config_item('index_url') . '/common/preview?file=' . urlencode($main_pic)?>"></a></p></li>
                                    <?php }?>
                                </ul>
                                <div class="input-append" id="pic_url" <?php if(!empty($main_pic)) echo 'style="display:block;"';?>>
                                    <input class="input-xlarge" id="main_pic" type="text" name="main_pic" value="<?php if(!empty($main_pic)) echo $main_pic;?>">
                                    <button class="btn" type="button" id="copy_btn">全选地址</button>
                                </div>
                            </div>
                        </div>

                        <div class="control-group cols_1">
                            <label class="control-label" for="textarea2">描述</label>
                            <div class="controls input-xxlarge">

                                <textarea class="input-xxlarge textarea" placeholder="第一列正文" id="desc" name="desc">
                                    <?php if (isset($desc)) echo $desc;?>
                                </textarea>
                            </div>
                        </div>

                        <div class="control-group cols_1">
                            <label class="control-label" for="textarea2">列表样式</label>
                            <div class="controls">
                                <select name="list_style" id="parent_id">
                                    <?php
                                    $list_styles = config_item('list_style');
                                    foreach ($list_styles as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($list_style) && $list_style == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="reset" class="btn"><a href="<?php echo config_item('index_url') . '/category/index'; ?>">取消</a></button>
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

