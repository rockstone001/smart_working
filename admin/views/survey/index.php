<div class="row-fluid">
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Success</h4>
    </div>
    <div class="navbar">
        <div class="navbar-inner">
            <ul class="breadcrumb">
                <i class="icon-chevron-left hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
                <i class="icon-chevron-right show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
                <li class="">
                    <!--                    <a href="#">Dashboard</a> <span class="divider">/</span>-->
                    <a href="<?php echo config_item('index_url') . '/survey/index'?>">问卷统计管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    问卷列表
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
    </div>
</div>
<div class="panel-body" style="padding-bottom:0px;">
    <div id="toolbar" class="btn-group">
        <?php if (in_array('survey/survey_stat', $actions_alloowed)) {?>
        <button id="btn_view" type="button" class="btn" data-link="<?php echo config_item('index_url') . '/survey/survey_stat'?>">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true">查看统计</span>
        </button>
        <?php }?>
    </div>
    <table id="post_list"></table>
</div>
<script>
    var list_url = "<?php echo config_item('index_url') . '/survey/get_list'?>";
</script>
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

