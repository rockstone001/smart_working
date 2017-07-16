<?php
//print_r($orders);
?>
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
                    <a href="<?php echo config_item('index_url') . '/lessonstat/index'?>">课程报名统计</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    <?php if (isset($id)) echo '查看详情';?>
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <form class="form-horizontal" method="post" action="<?php if (isset($id)) echo config_item('index_url') . '/lessonstat/detail/' . $id; else echo config_item('index_url') . '/lessonstat/detail';?>">
                    <fieldset>
                        <legend><?php if (isset($id)) echo $title . ' <span style="color:gray; font-size:16px;">( 听课费 : ' . $charge . ' )</span>';?></legend>

                        <?php if (count($orders['rows']) > 0) {?>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>用户昵称</th>
                                <th>姓名</th>
                                <th>手机</th>
                                <th>留言</th>
                                <th>订单号</th>
                                <th>微信订单号</th>
                                <th>金额</th>
                                <th>银行类型</th>
                                <th>订单创建时间</th>
                                <th>付款时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for ($i = 0; $i < count($orders['rows']); $i ++) {
                                $order = $orders['rows'][$i];
                                ?>
                                <tr>
                                    <td><?php echo $i+1?></td>
                                    <td><?php echo $order['nickname']?></td>
                                    <td><?php echo $order['name']?></td>
                                    <td><?php echo $order['mobile']?></td>
                                    <td><?php echo $order['msg']?></td>
                                    <td><?php echo $order['order_id']?></td>
                                    <td><?php echo $order['transaction_id']?></td>
                                    <td><?php echo $order['amount']/100?></td>
                                    <td><?php echo $order['bank_type']?></td>
                                    <td><?php echo $order['created_at']?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($order['time_end']))?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <?php }?>

                        <div class="form-actions">
                            <button type="button" class="btn" onclick="location.href='<?php echo config_item('index_url') . '/lessonstat/index'; ?>'"><a href="<?php echo config_item('index_url') . '/lessonstat/index'; ?>">返回</a></button>
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

