<?php
//    print_r($lessons); die();
?>
<style>
    .search_result {
    }
    .search_result li {
        height: 30px;
        line-height: 30px;
        width: 300px;
    }
    .search_result li:hover {
        background-color: #d6d6d6;
    }
</style>
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
                    <a href="<?php echo config_item('index_url') . '/order/index'?>">订单管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    添加订单
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <?php if (!isset($lesson_id)) {?>
                <form class="form-horizontal" method="get" action="<?php echo config_item('index_url') . '/order/new_order';?>">
                    <fieldset>
                        <legend>添加订单</legend>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">选择课程</label>
                            <div class="controls">
                                <select name="lesson_id">
                                    <?php
                                        foreach ($lessons as $lesson) {
                                    ?>
                                        <option value="<?php echo $lesson['id']?>"><?php echo $lesson['title']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>


                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="button" class="btn" onclick="location.href='<?php echo config_item('index_url') . '/order/index'; ?>'"><a href="<?php echo config_item('index_url') . '/order/index'; ?>">取消</a></button>
                        </div>
                    </fieldset>
                </form>
                <?php } else {?>
                    <form class="form-horizontal" method="post" action="<?php echo config_item('index_url') . '/order/new_order?lesson_id=' . $lesson_id;?>">
                        <fieldset>
                            <legend>添加订单</legend>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">课程名</label>
                                <div class="controls">
                                    <input class="input-xxlarge focused" type="text" value="<?php echo $lesson['title']?>" readonly = "true">
                                </div>
                            </div>
                            <?php
                            $start_times = json_decode($lesson['start_times'], true);
                            $end_times = json_decode($lesson['end_times'], true);
                            $addresses = json_decode($lesson['addresses'], true);
                            ?>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">开课时间</label>
                                <div class="controls">
                                    <select id="start_time" class="input-xxlarge focused">
                                        <?php
                                        for ($i = 0; $i < count($start_times); $i ++) {
                                            ?>
                                            <option value="<?php echo $i?>">
                                                <?php
                                                echo date('m-d H:i', strtotime($start_times[$i]));
                                                echo ' 至 ';
                                                echo date('m-d H:i', strtotime($end_times[$i]));
                                                ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="index" value="0" id="index"/>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">开课地址</label>
                                <div class="controls">
                                    <select id="address" class="input-xxlarge focused">
                                        <?php
                                        for ($i = 0; $i < count($addresses); $i ++) {
                                            ?>
                                            <option value="<?php echo $i?>">
                                                <?php
                                                echo $addresses[$i];
                                                ?>
                                            </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">价格</label>
                                <div class="controls">
                                    <input class="input-xxlarge focused" type="text" value="<?php echo $lesson['charge']?>" name="price">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">关联用户</label>
                                <div class="controls">
                                    <input AUTOCOMPLETE="off" class="input-xxlarge focused" type="text" value="" placeholder="请输入用户昵称关键字" id="key">
                                    <input type="hidden" name="uid" id="uid" value="0"/>
                                    <ul style="margin: 0px; padding: 0px;" class="search_result">
                                    </ul>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">保存</button>
                                <button type="button" class="btn" onclick="location.href='<?php echo config_item('index_url') . '/order/index'; ?>'"><a href="<?php echo config_item('index_url') . '/order/index'; ?>">取消</a></button>
                            </div>
                        </fieldset>
                    </form>
                <?php }?>
            </div>
        </div>
    </div>
</div>

<script>
    var search_url = '<?php echo config_item('index_url')?>/user/get_users';
    window.onload = function () {
        $('#key').on('keyup', function () {
            var key = $(this).val();
            if (key != '') {
                $.getJSON(search_url + '?key=' + key, function(data) {
                    var html = '';
                    for (var i = 0; i < data.length; i ++) {
                        html += '<li data-id="' + data[i].id + '">' + data[i].nickname + ' : ' + data[i].username + '</li>'
                    }
                    $('.search_result').html(html);
                    $('.search_result li').on('click', function() {
                        $('#uid').val($(this).data('id'));
                        $('#key').val($(this).html());
                        $('.search_result').html('');
                    });
                });
            }
        })

        $('#start_time').on('change', function() {
//            console.log('start_time change');
            var index = $(this).val();
            $('#index').val(index);
            $('#address').val(index);
        });
        $('#address').on('change', function() {
//            console.log('address change');
            var index = $(this).val();
            $('#index').val(index);
            $('#start_time').val(index);
        });
    };
</script>