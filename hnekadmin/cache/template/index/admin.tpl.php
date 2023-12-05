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
        <form action="index.php?c=index&a=site" method="post" class="form-inline">
        <ul class="breadcrumb">
            <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="javascript:void(0)">账号管理</a> <span class="divider">&nbsp;&nbsp;</span></li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="index.php?c=index&a=admin_add">添加账号</a>
            </li>
        </ul>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="70">ID</th>
                    <th width="150">昵称</th>
                    <th width="150">账号</th>
                    <th width="150">上次登录时间</th>
                    <th width="150">上次登录IP</th>
                    <th width="100">添加时间</th>
                    <th width="70">状态</td>
                    <th width="100">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['admin_id'];?></td>
                    <td ><?php echo $vo['nickname'];?></td>
                    <td ><?php echo $vo['user_name'];?></td>
                    <td ><?php echo $vo['last_login_time'];?></td>
                    <td ><?php echo $vo['ip_address'];?></td>
                    <td align='center'><?php echo $vo['add_time'];?></td>
                    <td align='center'><?php if ($vo['isvalid'] == 1) { ?>√<?php } else { ?>X<?php } ?></td>
                    <td align='center'>
                        <a href="index.php?c=index&a=admin_edit&id=<?php echo $vo['admin_id'];?>">修改</a> | 
                        <?php if ($vo['isvalid'] == 1) { ?>
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=index&a=admin_close&id=<?php echo $vo['admin_id'];?>','确定禁用该账号吗?')">禁用</a> |
                        <?php } else { ?>
                        <a href="index.php?c=index&a=admin_open&id=<?php echo $vo['admin_id'];?>">启用</a> |
                        <?php } ?>
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=index&a=admin_delete&id=<?php echo $vo['admin_id'];?>','确定删除该账号吗?')">删除</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr> 
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
        </script>
    </body>
</html>