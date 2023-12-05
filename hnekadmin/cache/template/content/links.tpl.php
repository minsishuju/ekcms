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
            <li><a href="javascript:void(0)">内容管理</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="javascript:void(0)">推广管理</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">友情链接</li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="index.php?c=content&a=add_links">添加友链</a>
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="15%">ID</th>
                    <th width="40%">网站名称</th>
                    <th width="30%">网站LOGO</th>
                    <th width="15%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['links_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td ><img src="<?php echo $vo['image'];?>" style="height:30px;"></td>
                    <td align='center'>
                        <a href="index.php?c=content&a=edit_links&id=<?php echo $vo['links_id'];?>">修改</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=content&a=delete_links&id=<?php echo $vo['links_id'];?>','确定删除“<?php echo $vo['name'];?>”吗?')">删除</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr > 
                    <td colspan="4"><div class="pagination"><?php echo $page;?></div></td>
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