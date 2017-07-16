<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="<?php echo $desc;?>" />
    <meta name="keywords" content="<?php echo $keywords;?>" />
    <title><?php echo $title?></title>
    <?php
    foreach ($css as $v) {
        ?>
        <link rel='stylesheet' href='<?php echo $v; ?>' type='text/css'/>
        <?php
    }
    ?>
</head>
<body ontouchstart>
<div class="container" id="container">
</div>
<?php echo $content_for_layout?>
<?php
foreach ($js as $v) {
    ?>
    <script src="<?php echo $v;?>"></script>
    <?php
}
?>
</body>
</html>

