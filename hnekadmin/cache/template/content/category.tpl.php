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
            <li><a href="javascript:void(0)">栏目管理</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">栏目列表</li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="index.php?c=content&a=add_category">添加栏目</a>
                <a class="btn btn-small btn-primary pull-right" style="margin-right:5px" href="index.php?c=content&a=update_categorys_cache">更新栏目缓存</a>
            </li>
        </ul>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="50">排序</th>
                    <th width="50">ID</th>
                    <th width="100">栏目名称</th>
                    <th width="50">数据量</th>
                    <th width="100">栏目类型</th>
                    <th width="70">预览</th>
                    <th width="50">导航显示</th>
                    <th width="150">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><span  class="listorders" data-category_id="<?php echo $vo['category_id'];?>"><?php echo $vo['listorder'];?></span></td>
                    <td align='center'><?php echo $vo['category_id'];?></td>
                    <td >
                    <?php for ($i=1;$i<$vo['stort'];$i++) {?>
                    &nbsp;&nbsp;&nbsp;
                    <?php } ?>
                    <?php if ($vo['parent_id'] != 0) { ?>
                    |--
                    <?php } ?>
                    <?php echo $vo['name'];?>
                    </td>
                    <td align='center'>
                        <?php if ($vo['type_id'] == 1 || $vo['type_id'] == 2) { ?>
                        <a href="index.php?c=content&a=lists&id=<?php echo $vo['category_id'];?>"><?php echo $vo['num'];?></a>
                        <?php } ?>&nbsp;
                    </td>
                    <td align='center'><?php if ($vo['type_id'] == 1) { ?>文章<?php } elseif ($vo['type_id'] == 2) { ?>图集<?php } elseif ($vo['type_id'] == 3) { ?>单页<?php } elseif ($vo['type_id'] == 4) { ?>链接<?php } ?></td>
                    <td align='center'><a target="_blank" href="<?php echo $vo['url'];?>">PC版</a> | <a target="_blank" href="index.php?c=index&a=preview&url=<?php echo @urlencode($vo['url']);?>" >手机版</a></td>
                    <td align='center'><?php if ($vo['is_show'] == 1) { ?>√<?php } else { ?>X<?php } ?></td>
                    <td align='center'>
                        <?php if ($vo['type_id'] == 4 ||($vo['type_id'] != 3 && $vo['child'])) { ?>
                        <span style="color:#CCC">内容管理</span> | 
                        <?php } else { ?>
                        <a href="index.php?c=content&a=lists&id=<?php echo $vo['category_id'];?>">内容管理</a> | 
                        <?php } ?>
                        <?php if ($vo['type_id'] == 4 || $vo['type_id'] == 3 || $vo['child']) { ?>
                        <span style="color:#CCC">批量移动</span> | 
                        <?php } else { ?>
                        <a href="javascript:void(0);" class="move" data-category_id="<?php echo $vo['category_id'];?>">批量移动</a> | 
                        <?php } ?>
                        <a href="index.php?c=content&a=edit_category&id=<?php echo $vo['category_id'];?>">修改</a> | 
                        <?php if ($vo['child'] AND $vo['main_category']=='1') { ?>
                        <span style="color:#CCC">删除</span>
                        <?php } else { ?>
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=content&a=delete_category&id=<?php echo $vo['category_id'];?>','确定删除该栏目及其数据吗?')">删除</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div id="posids" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">批量移动</h3>
            </div>
            <div class="modal-body">
                <p style="text-algin:center">loadding......</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
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
                    $.post('index.php?c=content&a=category_listorder',{category_id:category_id,listorder:listorder},function(data){
                        $('#listorder'+data.category_id).parent().css({padding:'0 10px'});
                        if(data.status == 1){
                            $('#listorder'+data.category_id).parent().html(listorder);
                        }else{
                            $('#listorder'+data.category_id).parent().html($('#listorder'+data.category_id).data('original'));
                        }
                    });
                    return false;
                });
                $('.move').click(function(){
                    var category_id = $(this).data('category_id');
                    $('#posids').modal({
                        width  : 360,
                        height : 640,
                        remote : 'index.php?c=content&a=move&category_id=' + category_id
                    });
                });
                $('#posids').on('hidden', function () {
                    $(this).removeData();
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