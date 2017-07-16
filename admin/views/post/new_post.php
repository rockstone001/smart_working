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
                    <a href="<?php echo config_item('index_url') . '/post/index'?>">文章管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑文章'; else echo '新文章';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/post/edit/' . $id; else echo config_item('index_url') . '/post/new_post';?>">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑文章'; else echo '新文章';?></legend>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">所属分类</label>
                            <div class="controls">
                                <select name="cate_id" id="cate_id">
                                    <?php foreach ($category as $k=>$v) {?>
                                    <option value="<?php echo $k?>" <?php if (isset($cate_id) && $cate_id == $k) echo 'selected';?>><?php echo $v?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">标题</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="title" name="title" type="text" value="<?php if (isset($title)) echo $title;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">副标题</label>
                            <div class="controls">
                                <textarea rows="3" name="sub_title" class="input-xxlarge"><?php if (isset($sub_title)) echo $sub_title;?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">概述</label>
                            <div class="controls">
                                <textarea rows="3" name="summary" class="input-xxlarge"><?php if (isset($summary)) echo $summary;?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">主配图</label>
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

                        <div class="control-group">
                            <label class="control-label">副配图</label>
                            <div class="controls" id="upload_wrapper2">
                                <input multiple="multiple" id="pic_upload2" type="file" name="pic_upload" value="" style="display: none;"/>
                                <button class="btn btn-success" type="button" id="pic_upload_btn2">上传图片</button>
                                <ul class="image-list2 filesContainer">
                                    <?php if(!empty($vice_pic)) {?>
                                        <li class="fileContainer"><a class="close" href="###" onclick="$(this).parent().remove();$('#pic_url2').hide();$('#vice_pic').val('');">X</a><span><?php
                                                $tmp = pathinfo($vice_pic);
                                                if (isset($tmp['basename'])) echo $tmp['basename'];
                                                ?></span><p><a href="<?php echo $vice_pic;?>" target="_blank"><img src="<?php echo config_item('index_url') . '/common/preview?file=' . urlencode($vice_pic)?>"></a></p></li>
                                    <?php }?>
                                </ul>
                                <div class="input-append" id="pic_url2" <?php if(!empty($vice_pic)) echo 'style="display:block;"';?>>
                                    <input class="input-xlarge" id="vice_pic" type="text" name="vice_pic" value="<?php if(!empty($vice_pic)) echo $vice_pic;?>">
                                    <button class="btn" type="button" id="copy_btn2">全选地址</button>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">正文样式</label>
                            <div class="controls">
                                <select name="cols_num" id="cols_num">
                                    <option value="1" <?php if (isset($cols_num) && $cols_num == 1) echo 'selected';?>>1列</option>
                                    <option value="2" <?php if (isset($cols_num) && $cols_num == 2) echo 'selected';?>>2列</option>
                                    <option value="3" <?php if (isset($cols_num) && $cols_num == 3) echo 'selected';?>>3列</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group cols_1">
                            <label class="control-label" for="textarea2">第一列正文</label>
                            <div class="controls input-xxlarge">

                                <textarea class="input-xxlarge textarea" placeholder="第一列正文" id="col_1" name="col_1">
                                    <?php if (isset($col_1)) echo $col_1;?>
                                </textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">第一列宽度</label>
                            <div class="controls">
                                <select name="col_1_class" id="col_1_class">
                                    <?php for($i = 1; $i < 13; $i++) {?>
                                        <option value="span<?php echo $i;?>" <?php if(isset($col_1_class) && $col_1_class == 'span' . $i) echo 'selected'; elseif (!isset($col_1_class) && $i == 12) echo 'selected'; ?>><?php echo $i;?>/12</option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group cols_2" <?php if (isset($col_2)) echo 'style="display:block"';?>>
                            <label class="control-label" for="textarea2">第二列正文</label>
                            <div class="controls input-xxlarge">
                                <textarea class="input-xxlarge textarea" placeholder="第二列正文" rows="15" id="col_2" name="col_2">
                                    <?php if (isset($col_2)) echo $col_2;?>
                                </textarea>
                            </div>
                        </div>
                        <div class="control-group cols_2" <?php if (isset($col_2)) echo 'style="display:block"';?>>
                            <label class="control-label">第二列宽度</label>
                            <div class="controls">
                                <select name="col_2_class" id="col_2_class">
                                    <?php for($i = 1; $i < 13; $i++) {?>
                                        <option value="span<?php echo $i;?>" <?php if(isset($col_2_class) && $col_2_class == 'span' . $i) echo 'selected'?>><?php echo $i;?>/12</option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group cols_3" <?php if (isset($col_3)) echo 'style="display:block"';?>>
                            <label class="control-label" for="textarea2">第三列正文</label>
                            <div class="controls input-xxlarge">
                                <textarea class="input-xxlarge textarea" placeholder="第三列正文" rows="15" id="col_3" name="col_3">
                                    <?php if (isset($col_3)) echo $col_3;?>
                                </textarea>
                            </div>
                        </div>
                        <div class="control-group cols_3" <?php if (isset($col_3)) echo 'style="display:block"';?>>
                            <label class="control-label">第三列宽度</label>
                            <div class="controls">
                                <select name="col_3_class" id="col_3_class">
                                    <?php for($i = 1; $i < 13; $i++) {?>
                                    <option value="span<?php echo $i;?>" <?php if(isset($col_3_class) && $col_3_class == 'span' . $i) echo 'selected'?>><?php echo $i;?>/12</option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="focusedInput">所属位置</label>
                            <div class="controls">
                                <?php
                                foreach($tag as $t) {?>
                                <label class="checkbox inline">
                                    <input type="checkbox"  value="<?php echo $t?>" name="tags[]" <?php if (isset($tags) && in_array($t, $tags)) echo 'checked';?> /> <?php echo $t?>
                                </label>
                                <?php }?>
                            </div>
                        </div>
                        <div class="control-group cols_1">
                            <label class="control-label" for="textarea2">文章模板</label>
                            <div class="controls">
                                <select name="post_style">
                                    <?php
                                    $post_styles = config_item('post_style');
                                    foreach ($post_styles as $k=>$v) {?>
                                        <option value="<?php echo $k;?>" <?php if(isset($post_style) && $post_style == $k) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="button" class="btn" onclick="location.href='<?php echo config_item('index_url') . '/post/index'; ?>'"><a href="<?php echo config_item('index_url') . '/post/index'; ?>">取消</a></button>
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

