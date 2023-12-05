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
            <li><a href="javascript:void(0)">内容管理</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="javascript:void(0)">内容相关设置</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="index.php?c=content&a=ad">广告管理</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active"><?php echo $info['name'];?></li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="index.php?c=content&a=add_ad&space_id=<?php echo $info['space_id'];?>">添加广告</a>
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="10%">ID</th>
					<th width="15%">广告排序</th>
                    <th width="20%">广告名称</th>
                    <th width="10%">广告图片</th>
                    <th width="20%">链接地址</th>
                    <th width="20%">提示文字</th>
                    <th width="15%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['ad_id'];?></td>
					<td align='center' ><span  class="listorders" data-ad_id="<?php echo $vo['ad_id'];?>"><?php echo $vo['listorder'];?></span></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td ><img style="height:30px;" src="<?php echo $vo['image'];?>"></td>
                    <td ><?php echo $vo['link_url'];?></td>
                    <td ><?php echo $vo['alt'];?></td>
                    <td align='center'>
                        <a href="index.php?c=content&a=edit_ad&id=<?php echo $vo['ad_id'];?>">修改</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=content&a=delete_ad&id=<?php echo $vo['ad_id'];?>','确定删除“<?php echo $vo['name'];?>”吗?')">删除</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr > 
                    <td colspan="7"><div class="pagination"><?php echo $page;?></div></td>
                </tr>
            </tfoot>
        </table>
        <script>
		$(function(){
                $('.listorders').click(function(){
                    if($(this).children('input').length > 0){
                        return false;
                    }else{
                        $(this).html('<input style="width:30px;" id="listorder' + $(this).data('ad_id') + '" data-original="' + $(this).html() + '" value="' + $(this).html() + '">');
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
                    var category_id = $(this).parent().data('ad_id');
                    var listorder = $(this).val();
                    $.post('index.php?c=content&a=ad_listorder',{ad_id:category_id,listorder:listorder},function(data){
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