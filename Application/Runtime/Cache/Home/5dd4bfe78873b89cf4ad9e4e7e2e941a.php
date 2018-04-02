<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>系统提示-<?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<!--<link rel="stylesheet" href="/Template/pc/default/Static/css/base.css" type="text/css">-->
<!--<link href="/Template/pc/default/Static/css/tsinformation.css" rel="stylesheet" type="text/css">-->
    <script src="/Template/pc/default/Static/js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Template/pc/default/Static/css/tipDialog.css"/>
    <script type="text/javascript" src="/Template/pc/default/Static/js/tipDialog.js"></script>
</head>
<body>
<!--------头部开始-------------->

<?php if(isset($message)) {?>
<script>
    $(function(){
        tipDialog('<?php echo $message ?>','ok','',1);
        setTimeout(function(){
            window.location='<?php echo($jumpUrl); ?>';
        },1000);
    })
</script>
<?php }else{ ?>
<script>
    $(function(){
        tipDialog('<?php echo $error ?>','error','',1);
        setTimeout(function(){
            window.location='<?php echo($jumpUrl); ?>';
        },1000);
    })
</script>
<?php } ?>
<!--中间内容 end-->

<!--------footer-开始-------------->


</body>
</html>