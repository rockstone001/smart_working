<style>
    .demos-title {
        text-align: center;
        font-size: 20px;
        font-weight: 400;
        margin: 10px 15%;
    }
    .bd {
        text-align: center;

    }
    .bd a {
        width: 90%;
    }
    .gray {
        color:gray;
    }
</style>
<header class="demos-header">
    <h1 class="demos-title"><?php echo $lesson['title'];?> - 签到统计</h1>
</header>
<div class="bd">
    <div class="page__bd">
        <div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>姓名</p>
                </div>
                <div class="weui-cell__bd">签到时间</div>
            </div>
            <?php foreach ($orders as $v) {?>
            <div class="weui-cell">
                <div class="weui-cell__bd gray">
                    <p><?php echo $v['name']?></p>
                </div>
                <div class="weui-cell__bd gray"><?php echo $v['updated_at']?></div>
            </div>
            <?php }?>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <p>签到人数</p>
                </div>
                <div class="weui-cell__bd"><?php echo count($orders)?></div>
            </div>
        </div>
    </div>
</div>