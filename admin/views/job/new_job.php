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
                    <a href="<?php echo config_item('index_url') . '/job/index'?>">职位管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '编辑职位'; else echo '新职位';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/job/edit/' . $id; else echo config_item('index_url') . '/job/new_job';?>">
                    <fieldset>
                        <legend><?php if (isset($id)) echo '编辑职位'; else echo '新职位';?></legend>
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
                            <label class="control-label" for="focusedInput">职位</label>
                            <div class="controls">
                                <input class="input-large focused" id="title" name="title" type="text" value="<?php if (isset($title)) echo $title;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">部门</label>
                            <div class="controls">
                                <input class="input-large focused" id="department" name="department" type="text" value="<?php if (isset($department)) echo $department;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">招聘人数</label>
                            <div class="controls">
                                <input class="input-large focused" id="number" name="number" type="text" value="<?php if (isset($number)) echo $number;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">工作经验</label>
                            <div class="controls">
                                <input class="input-large focused" id="experience" name="experience" type="text" value="<?php if (isset($experience)) echo $experience;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">学历要求</label>
                            <div class="controls">
                                <select name="degree" id="degree">
                                    <?php
                                    $degrees = config_item('degrees');
                                    foreach ($degrees as $v) {?>
                                        <option value="<?php echo $v;?>" <?php if(isset($degree) && $degree == $v) echo 'selected'; ?>><?php echo $v;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">截止日期</label>
                            <div class="controls">
                                <input class="input-large focused" id="expire" name="expire" type="text" value="<?php if (isset($expire)) echo $expire;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">职位描述</label>
                            <div class="controls">
                                <textarea rows="8" name="description" class="input-xxlarge"><?php if (isset($description)) echo $description;?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">职位需求</label>
                            <div class="controls">
                                <textarea rows="8" name="requirement" class="input-xxlarge"><?php if (isset($requirement)) echo $requirement;?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">薪水</label>
                            <div class="controls">
                                <input class="input-large focused" id="salary" name="salary" type="text" value="<?php if (isset($salary)) echo $salary;?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">外链</label>
                            <div class="controls">
                                <input class="input-xxlarge focused" id="link" name="link" type="text" value="<?php if (isset($link)) echo $link;?>">
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
                            <button type="button" class="btn" onclick="location.href='<?php echo config_item('index_url') . '/job/index'; ?>'"><a href="<?php echo config_item('index_url') . '/job/index'; ?>">取消</a></button>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>

