<style>
    .yijian {
        margin-bottom: 20px;
    }
    .yijian p {
        margin: 0px;
        padding:0px;
    }
    .yijian .nickname {
        display: inline-block;
    }
    .yijian .avatar {
        display: inline-block;
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }
    .yijian .text {
        display: inline-block;
        background-color: #d6d6d6;
        margin-left: 20px;
        border-radius: 10px;
        padding: 10px;
    }
</style>
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
                    <a href="<?php echo config_item('index_url') . '/survey/index'?>">问卷调查管理</a> <span class="divider">/</span>
                </li>
                <li class="active">
                    <!--                    <a href="#">Settings</a> <span class="divider">/</span>-->
                    问卷调查统计
                </li>
                <!--                <li class="active">Tools</li>-->
            </ul>
        </div>
    </div>
</div>
<div class="panel-body" style="padding-bottom:0px;">
    <h4><?php echo $survey['title'];?></h4>
    <?php $index = 0; foreach($survey['questions'] as $k => $v) {
        if ($v['type'] != 'text') {
        ?>
    <div id="main<?php echo $k?>" style="width: 100%;height:300px;"></div>
    <hr/>
    <?php } else { ?>
    <div>
        <h4><?php echo ($index + 1) . '、' . $v['question']?></h4>
        <?php if (isset($stat[$index])) {foreach ($stat[$index] as $text => $user) {?>
        <div class="yijian">
            <img class="avatar" src="<?php echo $user['avatar'] ?>" />
            <p class="nickname"><?php echo $user['nickname']?></p>
            <p class="text"><?php echo $text;?></p>
        </div>
        <?php }}?>
    </div>
    <?php }
        $index ++;
    }?>

</div>
<script>
    window.onload = function () {
        <?php $index = 0; foreach($survey['questions'] as $k => $v) {?>
        var myChart = echarts.init(document.getElementById('main<?php echo $k?>'));
        var option<?php echo $k?> = {
            title : {
                text: '<?php echo (++$index) . '、' . $v['question']?>',
                subtext: '',
                x:'left'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'right',
                data: [<?php $i = 0; foreach ($v['answer'] as $kk => $vv) {
                    echo "'$vv'";
                    if (++$i != count($v['answer'])) echo ',';
                    }?>]
            },
            series : [
                {
                    name: '',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:[
                        <?php $i = 0; foreach ($v['answer'] as $kk => $vv) {?>{value:<?php echo isset($stat[$k][$kk]) ? $stat[$k][$kk] : 0;?>, name:'<?php echo $vv;?>'}<?php
                            if (++$i != count($v['answer'])) echo ',';
                        }?>
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        myChart.setOption(option<?php echo $k?>);
        <?php }?>
    };
</script>