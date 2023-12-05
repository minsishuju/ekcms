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
            <li><a href="javascript:void(0)">会员管理</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">会员列表</li>
        </ul>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="70">ID</th>
                    <th width="150">用户名</th>
                    <th width="150">昵称</th>
                    <th width="100">邮箱</th>
                    <th width="150">电话</th>
                    <th width="150">积分</th>
                    <th width="150">状态</th>
                    <th width="150">注册时间</th>
                    <th width="100">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['member_id'];?></td>
                    <td ><?php echo $vo['username'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td align='center'><?php echo $vo['email'];?></td>
                    <td align='center'><?php echo $vo['phone'];?></td>
                    <td align='center'><?php echo $vo['point'];?></td>
                    <td align='center'><?php if ($vo['status'] == 1) { ?>√<?php } else { ?>X<?php } ?></td>
                    <td align='center'><?php echo @date('Y-m-d H:i:s',$vo['add_time']);?></td>
                    <td align='center'>
                        <a href="index.php?c=member&a=edit&id=<?php echo $vo['member_id'];?>">详细</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=member&a=delete&id=<?php echo $vo['member_id'];?>','确定删除该会员吗?')">删除</a>
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
        </script>
    </body>
</html>