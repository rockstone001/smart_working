<ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
    <?php if (in_array('user/index', $actions_alloowed)) {?>
    <li class="<?php echo  strtolower($this->router->class) == 'user' ? 'active' : '';?>">
        <a href="<?php echo config_item('index_url') . '/user/index'?>"><i class="icon-chevron-right"></i>用户管理</a>
    </li>
    <?php } if (in_array('role/index', $actions_alloowed)) {?>
    <li class="<?php echo  strtolower($this->router->class) == 'role' ? 'active' : '';?>">
        <a href="<?php echo config_item('index_url') . '/role/index'?>"><i class="icon-chevron-right"></i>角色管理</a>
    </li>
    <?php } if (in_array('privilege/index', $actions_alloowed)) {?>
    <li class="<?php echo  strtolower($this->router->class) == 'privilege' ? 'active' : '';?>">
        <a href="<?php echo config_item('index_url') . '/privilege/index'?>"><i class="icon-chevron-right"></i>权限管理</a>
    </li>
    <?php } if (in_array('company/index', $actions_alloowed)) {?>
        <li class="<?php echo  strtolower($this->router->class) == 'company' ? 'active' : '';?>">
            <a href="<?php echo config_item('index_url') . '/company/index'?>"><i class="icon-chevron-right"></i>分公司管理</a>
        </li>
    <?php } if (in_array('city/index', $actions_alloowed)) {?>
        <li class="<?php echo  strtolower($this->router->class) == 'city' ? 'active' : '';?>">
            <a href="<?php echo config_item('index_url') . '/city/index'?>"><i class="icon-chevron-right"></i>城市管理</a>
        </li>
    <?php } if (in_array('store/index', $actions_alloowed)) {?>
        <li class="<?php echo  strtolower($this->router->class) == 'store' ? 'active' : '';?>">
            <a href="<?php echo config_item('index_url') . '/store/index'?>"><i class="icon-chevron-right"></i>卖场管理</a>
        </li>
    <?php } ?>
</ul>
