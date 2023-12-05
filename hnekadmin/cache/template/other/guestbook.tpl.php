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
        <ul class="breadcrumb">
            <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="javascript:void(0)">模块管理</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">留言管理</li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">用户名称</th>
                    <th width="5%">性别</th>
                    <th width="10%">联系QQ</th>
                    <th width="10%">电子邮箱</th>
                    <th width="10%">手机</th>
                    <th width="10%">联系地址</th>
                    <th width="10%">相关内容</th>
                    <th width="10%">留言内容</th>
                    <th width="10%">留言时间</th>
                    <th width="10%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['guestbook_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td ><?php if ($vo['sex'] == 1) { ?>男<?php } else { ?>女<?php } ?></td>
                    <td ><?php echo $vo['qq'];?></td>
                    <td ><?php echo $vo['email'];?></td>
                    <td ><?php echo $vo['tel'];?></td>
                    <td ><?php echo $vo['address'];?></td>
                    <td ><?php echo $vo['title'];?></td>
                    <td ><?php echo @iCutstr($vo['introduce'],45);?></td>
                    <td ><?php echo @date('Y-m-d H:i:s',$vo['add_time']);?></td>
                    <td align='center'>
                        <a href="index.php?c=other&a=reply_guestbook&id=<?php echo $vo['guestbook_id'];?>">回复</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=other&a=delete_guestbook&id=<?php echo $vo['guestbook_id'];?>','确定删除“<?php echo @iStripslashes($vo['name']);?>”的留言吗?')">删除</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr > 
                    <td colspan="11"><div class="pagination"><?php echo $page;?></div></td>
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