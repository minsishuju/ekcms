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
                <li class="active">礼包列表&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                <li class="pull-right" style="margin-top:-3px">
                    <a class="btn btn-small btn-primary pull-right" href="index.php?c=shop&a=package_add">添加礼包</a>
                </li>
            </ul>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="20%">礼包名称</th>
                    <th width="5%">价格</th>
                    <th width="5%">销量</th>
                    <th width="5%">上架</th>
                    <th width="15%">添加时间</th>
                    <th width="10%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['package_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td align='center'><?php echo $vo['price'];?></td>
                    <td align='center'><?php echo $vo['sales'];?></td>
                    <td align='center'><?php if ($vo['shelf'] == 1) { ?>是<?php } else { ?>否<?php } ?></td>
                    <td align='center'><?php echo @date('Y-m-d H:i:s',$vo['add_time']);?></td>
                    <td align='center'>
                        <a href="index.php?c=shop&a=package_edit&id=<?php echo $vo['package_id'];?>">修改</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=shop&a=package_delete&id=<?php echo $vo['package_id'];?>','确定删除“<?php echo $vo['name'];?>”吗?')">删除</a>
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
            function confirmurl(url,message){
                if(confirm(message)){
                    location.replace(url);
                }
            }
        </script>
    </body>
</html>