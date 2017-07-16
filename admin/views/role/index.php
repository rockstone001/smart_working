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
                    <a href="<?php echo config_item('index_url') . '/role/index'?>">角色管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    角色列表
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
            <?php if (in_array('role/new_role', $actions_alloowed)) {?>
            <div class="btn-group float_right">
                <a href="<?php echo config_item('index_url') . '/role/new_role'?>"><button class="btn btn-success">新角色 <i class="icon-plus icon-white"></i></button></a>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<div class="panel-body" style="padding-bottom:0px;">
    <div id="toolbar" class="btn-group">
        <?php if (in_array('role/new_role', $actions_alloowed)) {?>
        <button id="btn_add" type="button" class="btn" data-link="<?php echo config_item('index_url') . '/role/new_role'?>">
            <span class="glyphicon glyphicon-plus" aria-hidden="true">新角色</span>
        </button>
        <?php } if (in_array('role/edit', $actions_alloowed)) {?>
        <button id="btn_edit" type="button" class="btn" data-link="<?php echo config_item('index_url') . '/role/edit'?>">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true">编辑</span>
        </button>
        <?php } if (in_array('role/assign', $actions_alloowed)) {?>
        <button id="btn_assign" type="button" class="btn" data-link="<?php echo config_item('index_url') . '/role/assign'?>">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true">分配权限</span>
        </button>
        <?php } if (in_array('role/remove', $actions_alloowed)) {?>
        <button id="btn_delete" type="button" class="btn" data-link="<?php echo config_item('index_url') . '/role/remove'?>">
            <span class="glyphicon glyphicon-remove" aria-hidden="true">删除</span>
        </button>
        <?php }?>
    </div>
    <table id="post_list"></table>
</div>
<script>
    var list_url = "<?php echo config_item('index_url') . '/role/get_list'?>";
    var remove_url = "<?php echo config_item('index_url') . '/role/remove'?>";
</script>

<!--删除提示 Modal -->
<div class="modal fade" id="remove_dialog" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">操作提示</h4>
            </div>
            <div class="modal-body" data-options="">
                您确定要删除这些角色吗?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success cancel-btn" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-danger confirm-btn" onclick="doRemove()">确定</button>
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

