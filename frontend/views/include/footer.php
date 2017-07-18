<div class="weui-tabbar">
    <a href="<?php echo config_item('index_url') . '/home'?>" class="weui-tabbar__item <?php
        $action  = strtolower($this->router->method);
        $class = strtolower($this->router->class);
    if (in_array($action, ['index']) && in_array($class, ['home'])) {
        echo 'weui-bar__item_on';
    }?> mui-icon mui-icon-home" style="font-size: 25px;">
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a href="###" class="weui-tabbar__item mui-icon mui-icon-chatbubble <?php
    $action  = strtolower($this->router->method);
    if (in_array($action, ['mine'])) {
        echo 'weui-bar__item_on';
    }?>" style="font-size: 25px;">
        <p class="weui-tabbar__label">全部信息</p>
        <ul class="link">
            <li data-link="<?php echo config_item('index_url') . '/publish/my_merchant'?>">潮流照片</li>
            <li data-link="<?php echo config_item('index_url') . '/pulishb/others_merchant'?>">VMD照片</li>
            <li data-link="<?php echo config_item('index_url') . '/publish/my_merchant'?>">卖场照片</li>
            <li data-link="<?php echo config_item('index_url') . '/pulishb/others_merchant'?>">友商卖场照片</li>

        </ul>
    </a>
    <a href="###" class="weui-tabbar__item mui-icon mui-icon-compose <?php
    $action  = strtolower($this->router->method);
    if (in_array($action, ['profile'])) {
        echo 'weui-bar__item_on';
    }?>" style="font-size: 25px;">
        <p class="weui-tabbar__label">发布信息</p>
        <ul class="link">
            <li data-link="<?php echo config_item('index_url') . '/publish/my_merchant'?>">卖场照片</li>
            <li data-link="<?php echo config_item('index_url') . '/pulishb/others_merchant'?>">友商卖场照片</li>
        </ul>
    </a>
    <a href="<?php echo config_item('index_url') . '/survey/survey_list'?>" class="weui-tabbar__item mui-icon-extra mui-icon-extra-people <?php
    if (in_array($class, ['survey'])) {
        echo 'weui-bar__item_on';
    }?>" style="font-size: 25px;">
        <p class="weui-tabbar__label">我</p>
    </a>
</div>

