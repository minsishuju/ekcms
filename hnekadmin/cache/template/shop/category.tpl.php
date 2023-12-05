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
        <script src="<?php echo __PUBLIC__;?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/bootstrap.min.js" ></script>
        <title>E营销管理系统</title>
    </head>
    <body>
        <ul class="breadcrumb">
            <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="javascript:void(0)">商城管理</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="javascript:void(0)">分类管理</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">分类列表</li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="index.php?c=shop&a=add_category">添加分类</a>
            </li>
        </ul>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="50">排序</th>
                    <th width="50">ID</th>
                    <th width="100">分类名称</th>
                    <th width="100">分类图片</th>
                    <th width="50">导航显示</th>
                    <th width="150">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><span  class="listorders" data-category_id="<?php echo $vo['category_id'];?>"><?php echo $vo['listorder'];?></span></td>
                    <td align='center'><?php echo $vo['category_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td align='center'><img src="<?php echo $vo['image'];?>" width="30" height="30"></td>
                    <td align='center'><?php if ($vo['is_show'] == 1) { ?>√<?php } else { ?>X<?php } ?></td>
                    <td align='center'>
                        <a href="index.php?c=shop&a=edit_category&id=<?php echo $vo['category_id'];?>">修改</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=shop&a=delete_category&id=<?php echo $vo['category_id'];?>','确定删除该栏目及其数据吗?')">删除</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <script>
            $(function(){
                $('.listorders').click(function(){
                    if($(this).children('input').length > 0){
                        return false;
                    }else{
                        $(this).html('<input style="width:15px;" id="listorder' + $(this).data('category_id') + '" data-original="' + $(this).html() + '" value="' + $(this).html() + '">');
                        $(this).children('input').focus();
                        $(this).css({padding:'0'});
                    }
                });
                $('.listorders').hover(
                    function(){
                        $(this).css({background:'#CCCCCC'})
                    },
                    function(){
                        $(this).css({background:'#FFFFFF'})
                    }
                );
                $('.listorders').on('blur','input',function(){
                    var category_id = $(this).parent().data('category_id');
                    var listorder = $(this).val();
                    $.post('index.php?c=shop&a=category_listorder',{category_id:category_id,listorder:listorder},function(data){
                        $('#listorder'+data.category_id).parent().css({padding:'0 10px'});
                        if(data.status == 1){
                            $('#listorder'+data.category_id).parent().html(listorder);
                        }else{
                            $('#listorder'+data.category_id).parent().html($('#listorder'+data.category_id).data('original'));
                        }
                    });
                    return false;
                });
            });
            function confirmurl(url,message){
                if(confirm(message)){
                    location.replace(url);
                }
            }
        </script>
    </body>
</html>