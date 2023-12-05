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
        <title>E营销管理系统</title>
    </head>
    <body>
        <form action="index.php?c=shop&a=goods" method="post" class="form-inline">
            <ul class="breadcrumb">
                <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
                <li><a href="javascript:void(0)">商品管理</a> <span class="divider">&gt;&gt;</span></li>
                <li class="active">商品列表&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                <li>
                    <b class="kserico">快速搜索：</b>
                    分类：
                    <select name="category_id">
                        <option value="0">全部分类</option>
                        <?php foreach ($category as $val) {?>
                        <option value="<?php echo $val['category_id'];?>" <?php if ($_POST['category_id'] == $val['category_id']) { ?>selected="selected"<?php } ?>><?php echo $val['name'];?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" class="btn" value="搜 索">
                </li>
                <li class="pull-right" style="margin-top:-3px">
                    <a class="btn btn-small btn-primary pull-right" href="index.php?c=shop&a=goods_add">添加商品</a>
                </li>
            </ul>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">排序</th>
                    <th width="5%">ID</th>
                    <th width="20%">商品名称</th>
                    <th width="5%">图片</th>
                    <th width="15%">销量</th>
                    <th width="5%">上架</th>
                    <th width="5%">推荐</th>
                    <th width="15%">添加时间</th>
                    <th width="10%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><span  class="listorders" data-goods_id="<?php echo $vo['goods_id'];?>"><?php echo $vo['listorder'];?></span></td>
                    <td align='center'><?php echo $vo['goods_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td align='center'><img src="<?php echo $vo['image'];?>" style="width:30px;height:30px;" /></td>
                    <td align='center'><?php echo $vo['sales'];?></td>
                    <td align='center'><?php if ($vo['shelf'] == 1) { ?>是<?php } else { ?>否<?php } ?></td>
                    <td align='center'><?php if ($vo['is_pos'] == 1) { ?>是<?php } else { ?>否<?php } ?></td>
                    <td align='center'><?php echo @date('Y-m-d H:i:s',$vo['add_time']);?></td>
                    <td align='center'>
                        <a href="index.php?c=shop&a=goods_edit&id=<?php echo $vo['goods_id'];?>">修改</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=shop&a=goods_delete&id=<?php echo $vo['goods_id'];?>','确定删除“<?php echo $vo['name'];?>”吗?')">删除</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr > 
                    <td colspan="9"><div class="pagination"><?php echo $page;?></div></td>
                </tr>
            </tfoot>
        </table>
        <script>
            function confirmurl(url,message){
                if(confirm(message)){
                    location.replace(url);
                }
            }
            $(function(){
                $('.listorders').click(function(){
                    if($(this).children('input').length > 0){
                        return false;
                    }else{
                        $(this).html('<input style="width:15px;" id="listorder' + $(this).data('goods_id') + '" data-original="' + $(this).html() + '" value="' + $(this).html() + '">');
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
                    var goods_id = $(this).parent().data('goods_id');
                    var listorder = $(this).val();
                    $.post('index.php?c=shop&a=listorder_goods',{goods_id:goods_id,listorder:listorder},function(data){
                        $('#listorder'+data.goods_id).parent().css({padding:'0 10px'});
                        if(data.status == 1){
                            $('#listorder'+data.goods_id).parent().html(listorder);
                        }else{
                            $('#listorder'+data.goods_id).parent().html($('#listorder'+data.goods_id).data('original'));
                        }
                    });
                    return false;
                });
            })
        </script>
    </body>
</html>