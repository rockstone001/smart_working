<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">课程名</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $lesson_title?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">课程类型</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $lesson_type?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">开课城市</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php
            echo !empty($city) ? $city : $lesson_city;
            ?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">地址</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php
            echo !empty($address) ? $address : $lesson_address;
            ?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">开课时间</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php
            echo !empty($start_time) ? date('m-d H:i', strtotime($start_time)) . ' 至 ' . date('m-d H:i', strtotime($end_time)) : date('m-d H:i', strtotime($lesson_start_time)) . ' 至 ' . date('m-d H:i', strtotime($lesson_end_time));

            ?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">联系人</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $linkman?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">联系电话</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $contract_number?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">订单号</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $order_id?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">下单时间</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $created_at?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">订单金额</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $charge?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">订单状态</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $state == 1 ? '已支付' : ($state == 0 ? '未支付' : '已过期')?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">报名截止</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $start_time?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $name?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">手机</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $mobile?></label>
    </div>
</div>
<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">留言</label></div>
    <div class="weui-cell__bd">
        <label class="weui-label desc"><?php echo $msg?></label>
    </div>
</div>
