<ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
    <?php if (in_array('brand/index', $actions_alloowed)) {?>
        <li class="<?php echo  strtolower($this->router->class) == 'brand' ? 'active' : '';?>">
            <a href="<?php echo config_item('index_url') . '/brand/index'?>"><i class="icon-chevron-right"></i>品牌管理</a>
        </li>

    <?php } if (in_array('lesson/index', $actions_alloowed)) {?>
    <li class="<?php echo  strtolower($this->router->class) == 'lesson' ? 'active' : '';?>">
        <a href="<?php echo config_item('index_url') . '/lesson/index'?>"><i class="icon-chevron-right"></i>课程管理</a>
    </li>
    <?php } if (in_array('order/index', $actions_alloowed)) {?>
        <li class="<?php echo  strtolower($this->router->class) == 'order' ? 'active' : '';?>">
            <a href="<?php echo config_item('index_url') . '/order/index'?>"><i class="icon-chevron-right"></i>订单管理</a>
        </li>
    <?php } if (in_array('lessonstat/index', $actions_alloowed)) {?>
        <li class="<?php echo  strtolower($this->router->class) == 'lessonstat' ? 'active' : '';?>">
            <a href="<?php echo config_item('index_url') . '/lessonstat/index'?>"><i class="icon-chevron-right"></i>课程报名统计</a>
        </li>
    <?php } if (in_array('survey/index', $actions_alloowed)) {?>
        <li class="<?php echo  strtolower($this->router->class) == 'survey' ? 'active' : '';?>">
            <a href="<?php echo config_item('index_url') . '/survey/index'?>"><i class="icon-chevron-right"></i>问卷统计</a>
        </li>
    <?php }?>


<!--    <li>-->
<!--        <a href="interface.html"><i class="icon-chevron-right"></i> UI & Interface</a>-->
<!--    </li>-->
<!--    <li>-->
<!--        <a href="#"><span class="badge badge-success pull-right">731</span> Orders</a>-->
<!--    </li>-->

</ul>
