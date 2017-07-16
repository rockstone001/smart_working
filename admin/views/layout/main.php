<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta name="description" content="<?php echo $header_desc;?>" />
    <meta name="keywords" content="<?php echo $header_keywords;?>" />
    <title><?php echo $header_title?></title>
    <?php
        foreach ($css as $v) {
            ?>
    <link rel='stylesheet' href='<?php echo $v; ?>' type='text/css'/>
    <?php
        }
    ?>
    <!--[if lt IE 9]>
    <script src="<?php echo config_item('js_url');?>html5shiv.js"></script>
    <script src="<?php echo config_item('js_url');?>respond.js"></script>
    <![endif]-->
</head>
<body>
<?php include(VIEWPATH . 'include/header.php')?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3" id="sidebar">
        <?php include(dirname(__FILE__) . '/../include/' . $left_side);?>
        </div>
        <div class="span9" id="content">
            <?php echo $content_for_layout?>
        </div>
    </div>
</div>
<?php include(VIEWPATH . 'include/footer.php')?>
<?php
foreach ($js as $v) {
    ?>
    <script src="<?php echo $v;?>"></script>
    <?php
}
?>

</body>
</html>