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
    .bd img {
        width: 90%;
    }
</style>
<div class="container" id="container">
    <div class="article">
        <h1 class="demos-title"><?php echo $lesson_title;?></h1>
        <div class="bd">
            <img src="<?php echo config_item('index_url')?>/home/get_qrcode?lesson_id=<?php echo $lesson_id?>" />
        </div>
    </div>
</div>