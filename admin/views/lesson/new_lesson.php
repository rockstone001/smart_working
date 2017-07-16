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
                    <a href="<?php echo config_item('index_url') . '/lesson/index'?>">课程管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑课程'; else echo '添加课程';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/lesson/edit/' . $id; else echo config_item('index_url') . '/lesson/new_lesson';?>">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑课程'; else echo '添加课程';?></legend>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">课程名</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="title" name="title" type="text" value="<?php if (isset($title)) echo $title;?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">老师</label>
                            <div class="controls">
                                <select name="teacher_id" id="teacher_id">
                                <?php if (isset($teachers['total'], $teachers['rows']) && $teachers['total'] > 0) {
                                    foreach ($teachers['rows'] as $v) {
                                ?>
                                    <option value="<?php echo $v['id']?>"><?php echo $v['name'];?></option>
                                <?php }}?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">课程图片</label>
                            <div class="controls" id="upload_wrapper">
                                <input multiple="multiple" id="pic_upload" type="file" name="pic_upload" value="" style="display: none;"/>
                                <button class="btn btn-success" type="button" id="pic_upload_btn">上传图片</button>
                                <ul class="image-list filesContainer">
                                    <?php if(!empty($image)) {?>
                                        <li class="fileContainer"><a class="close" href="###" onclick="$(this).parent().remove();$('#pic_url').hide();$('#image').val('');">X</a><span><?php
                                                $tmp = pathinfo($image);
                                                if (isset($tmp['basename'])) echo $tmp['basename'];
                                                ?></span><p><a href="<?php echo $image;?>" target="_blank"><img src="<?php echo config_item('index_url') . '/common/preview?file=' . urlencode($image)?>"></a></p></li>
                                    <?php }?>
                                </ul>
                                <div class="input-append" id="pic_url" <?php if(!empty($image)) echo 'style="display:block;"';?>>
                                    <input class="input-xlarge" id="image" type="text" name="image" value="<?php if(!empty($image)) echo $image;?>">
                                    <button class="btn" type="button" id="copy_btn">全选地址</button>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">类型</label>
                            <div class="controls">
                                <select name="sex" id="sex">
                                    <?php $lesson_types = config_item('lesson_type'); foreach($lesson_types as $v) {?>
                                        <option value="<?php echo $v?>" <?php if (isset($lesson_type) && $lesson_type == $v) echo 'selected'?>><?php echo $v?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">课程收费</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="charge" name="charge" type="text" value="<?php if (isset($charge)) echo $charge;?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">已报名人数</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="join_num" name="join_num" type="number" value="<?php if (isset($join_num)) echo $join_num; else echo '0'?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">可报名人数</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="limit_num" name="limit_num" type="number" value="<?php if (isset($limit_num)) echo $limit_num;?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">选择城市</label>
                            <div class="controls" >
                                <select id="city_selected">
                                    <?php
                                    $city_selected = isset($cities) ? explode(',', $cities) : [];
                                    $cities = config_item('cities');
                                    foreach($cities as $v) {
                                        ?>
                                        <option value="<?php echo $v['abbr']?>"><?php echo $v['name'];?></option>
                                    <?php }?>
                                </select>
                                <button type="button" class="btn" onclick="add_city()">添加</button>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">已添加城市</label>
                            <div class="controls" id="cities"><?php
                                foreach ($city_selected as $city) {
                                    Html::tag($city, 'remove_city');
                                }
                                ?></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">地址</label>
                            <div class="controls" id="address_wrapper">
                                <?php
                                if (isset($addresses)) {
                                $addresses = json_decode($addresses, true);
                                    if (!empty($addresses)) {
                                    $index = 0;
                                    foreach ($addresses as $v) {
                                ?>
                                <div style="margin-top: 5px; display:block;" class="input-prepend address">
                                    <span class="add-on"><?php echo $city_selected[$index++];?></span>
                                    <input class="input-xxlarge" type="text" placeholder="地址" value="<?php echo $v;?>" name="addresses[]">
                                </div>
                                <?php }}}?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">开始时间</label>
                            <div class="controls" id="start_time_wrapper">
                                <?php
                                if (isset($start_times)) {
                                    $start_times = json_decode($start_times, true);
                                    if (!empty($start_times)) {
                                    $index = 0;
                                    foreach ($start_times as $k => $v) {
                                        $id = md5(array_sum(explode(' ', microtime()))) . rand(1, 1000);
                                ?>
                                    <div class="date form_datetime start_time" data-date="<?php echo $v;?>" data-date-format="yyyy-mm-dd hh:ii" data-link-field="start_time_<?php echo $id;?>">
                                        <div class="input-prepend" style="margin-top: 5px">
                                            <span class="add-on"><?php echo $city_selected[$index++]?></span>
                                            <input size="16" type="text" value="<?php echo $v;?>" readonly>
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                        <input type="hidden" id="start_time_<?php echo $id?>" name="start_times[]" value="<?php echo $v;?>" />
                                    </div>
                                <?php }}}?>
                            </div>
                        </div>

                        <div class="control-group" >
                            <label class="control-label">结束时间</label>
                            <div class="controls" id="end_time_wrapper">
                                <?php
                                if (isset($end_times)) {
                                $end_times = json_decode($end_times, true);
                                if (!empty($end_times)) {
                                $index = 0;
                                foreach ($end_times as $k => $v) {
                                    $id = md5(array_sum(explode(' ', microtime()))) . rand(1, 1000);
                                    ?>
                                    <div class="date form_datetime end_time" data-date="<?php echo $v;?>" data-date-format="yyyy-mm-dd hh:ii" data-link-field="end_time_<?php echo $id;?>">
                                        <div class="input-prepend" style="margin-top: 5px">
                                            <span class="add-on"><?php echo $city_selected[$index++]?></span>
                                            <input size="16" type="text" value="<?php echo $v;?>" readonly>
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                        <input type="hidden" id="end_time_<?php echo $id?>" name="end_times[]" value="<?php echo $v;?>" />
                                    </div>
                                <?php }}}?>
                            </div>
                        </div>


                        <div class="control-group">
                            <label class="control-label">联系人</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="linkman" name="linkman" type="text" value="<?php if (isset($linkman)) echo $linkman;?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">联系电话</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="contract_number" name="contract_number" type="text" value="<?php if (isset($contract_number)) echo $contract_number;?>">
                            </div>
                        </div>

                        <div class="control-group cols_1">
                            <label class="control-label" for="textarea2">活动详情</label>
                            <div class="controls input-xxlarge">
                                <textarea class="input-xxlarge textarea" placeholder="课程详情" id="col_1" name="detail">
                                    <?php if (isset($detail)) echo $detail;?>
                                </textarea>
                            </div>
                        </div>

<!--                        <div class="control-group cols_1">-->
<!--                            <label class="control-label" for="textarea2">课程摘要</label>-->
<!--                            <div class="controls input-xxlarge">-->
<!--                                <textarea class="input-xxlarge textarea" placeholder="课程摘要" id="col_2" name="summary">-->
<!--                                    --><?php //if (isset($summary)) echo $summary;?>
<!--                                </textarea>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="button" class="btn" onclick="location.href='<?php echo config_item('index_url') . '/lesson/index'; ?>'"><a href="<?php echo config_item('index_url') . '/lesson/index'; ?>">取消</a></button>
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
<iframe style="display:none;width:0;height:0;border:0;margin:0;padding:0;position:absolute;" name="upload_iframe" id="upload_iframe"></iframe>
<script>
    window.onload = function(){
        $('.form_datetime').datetimepicker({
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });
    };

</script>

