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
</style>
<div class="container" id="container">
    <div class="article">
        <h1 class="demos-title"><?php echo $lesson_title;?></h1>
        <p style="height: 30px"></p>
        <div class="bd">
            <?php echo $msg?>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
        $('.bd a').on('click', function(){
//            console.log($(this).data('link'));
            location.href = $(this).data('link');
        });
    };
</script>