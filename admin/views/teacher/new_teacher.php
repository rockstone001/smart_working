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
                    <a href="<?php echo config_item('index_url') . '/teacher/index'?>">老师管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑老师'; else echo '添加老师';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/teacher/edit/' . $id; else echo config_item('index_url') . '/teacher/new_teacher';?>">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑老师'; else echo '添加老师';?></legend>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">姓名</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="name" name="name" type="text" value="<?php if (isset($name)) echo $name;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">性别</label>
                            <div class="controls">
                                <select name="sex" id="sex">
                                <?php $sex_options = config_item('sex'); foreach($sex_options as $k=>$v) {?>
                                    <option value="<?php echo $k?>" <?php if (isset($sex) && $sex == $k) echo 'selected'?>><?php echo $v?></option>
                                <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">所在地</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="location" name="location" type="text" value="<?php if (isset($location)) echo $location;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">出生年月</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="birthday" name="birthday" type="text" value="<?php if (isset($birthday)) echo $birthday;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">头像</label>
                            <div class="controls" id="upload_wrapper">
                                <input multiple="multiple" id="pic_upload" type="file" name="pic_upload" value="" style="display: none;"/>
                                <button class="btn btn-success" type="button" id="pic_upload_btn">上传图片</button>
                                <ul class="image-list filesContainer">
                                    <?php if(!empty($headimgurl)) {?>
                                    <li class="fileContainer"><a class="close" href="###" onclick="$(this).parent().remove();$('#pic_url').hide();$('#headimgurl').val('');">X</a><span><?php
                                            $tmp = pathinfo($headimgurl);
                                            if (isset($tmp['basename'])) echo $tmp['basename'];
                                            ?></span><p><a href="<?php echo $headimgurl;?>" target="_blank"><img src="<?php echo config_item('index_url') . '/common/preview?file=' . urlencode($headimgurl)?>"></a></p></li>
                                    <?php }?>
                                </ul>
                                <div class="input-append" id="pic_url" <?php if(!empty($headimgurl)) echo 'style="display:block;"';?>>
                                    <input class="input-xlarge" id="headimgurl" type="text" name="headimgurl" value="<?php if(!empty($headimgurl)) echo $headimgurl;?>">
                                    <button class="btn" type="button" id="copy_btn">全选地址</button>
                                </div>
                            </div>
                        </div>

                        <div class="control-group cols_1">
                            <label class="control-label" for="textarea2">履历介绍</label>
                            <div class="controls input-xxlarge">
                                <textarea class="input-xxlarge textarea" placeholder="履历介绍" id="col_1" name="summary">
                                    <?php if (isset($summary)) echo $summary;?>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="button" class="btn" onclick="location.href='<?php echo config_item('index_url') . '/teacher/index'; ?>'"><a href="<?php echo config_item('index_url') . '/teacher/index'; ?>">取消</a></button>
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
<form action="<?php echo config_item('index_url') . '/common/upload/top.setImagePath2'?>" enctype="multipart/form-data" method="POST" target="upload_iframe" id="upload_form2" style="display:none">
</form>
<iframe style="display:none;width:0;height:0;border:0;margin:0;padding:0;position:absolute;" name="upload_iframe"
        id="upload_iframe"></iframe>

