<?php if (!defined('IN_FW')) exit('Access Denied');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/bootstrap_min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/css.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>js/uploadify/uploadify.css" media="all" />
    <script src="<?php echo __PUBLIC__;?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/bootstrap.min.js" ></script>
    <title>E营销管理系统</title>
</head>
<body>
    <ul class="breadcrumb">
        <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">内容管理</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">内容相关设置</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active">附件管理</li>
    </ul>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td >
                    <ul id="image_box" class="clearfix">
                        <?php if(is_array($list)){foreach ((array)$list as $val) {?>
                        <li>
                            <button type="button" data-attachment_id="<?php echo $val['attachment_id'];?>" class="close">×</button>
                            <img src="/<?php echo $val['path'];?>">
                            <span><?php echo $val['name'];?></span>
                        </li>
                        <?php }} ?>
                    </ul>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr >
                <td><div class="pagination"><?php echo $page;?></div></td>
            </tr>
        </tfoot>
    </table>
    <script>
        $(function(){
            $('.close').click(function(){
                var attachment_id = $(this).data('attachment_id');
                if(confirm('确定删除该图片吗?此操作不可恢复。')){
                    location.replace('index.php?c=content&a=images_delete&id='+attachment_id);
                }
            });
        });
    </script>
</body>
</html>