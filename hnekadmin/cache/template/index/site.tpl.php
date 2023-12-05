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
        <title>易科互联E营销管理系统</title>
    </head>
    <body>
        <form action="index.php?c=index&a=site" method="post" class="form-inline">
        <ul class="breadcrumb">
            <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="javascript:void(0)">站点管理</a> <span class="divider">&nbsp;&nbsp;</span></li>
            <li>
                <b class="kserico">快速搜索：</b>
                <select name="type">
                    <option <?php if ($_POST['type'] == 1) { ?>selected="selected"<?php } ?> value="1">站点ID</option>
                    <option <?php if ($_POST['type'] == 2) { ?>selected="selected"<?php } ?> value="2">站点名称</option>
                    <option <?php if ($_POST['type'] == 3) { ?>selected="selected"<?php } ?> value="3">站点域名</option>
                </select> 
                <input name="name" class="ipt" type="text" value="<?php echo $_POST['name'];?>"> 
                <input type="submit" class="btn" value="搜 索">
            </li>
        </ul>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="70">ID</th>
                    <th width="150">站点名称</th>
                    <th width="150">站点域名</th>
                    <th width="70">联系人</th>
                    <th width="100">联系电话</th>
                    <th width="80">添加时间</th>
                    <th width="70">状态</td>
                    <th width="250">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['site_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td ><?php echo $vo['siteurl'];?></td>
                    <td ><?php echo $vo['contacts'];?></td>
                    <td ><?php echo $vo['phone'];?></td>
                    <td align='center'><?php echo $vo['add_time'];?></td>
                    <td align='center'><?php if ($vo['status'] == 1) { ?>√<?php } else { ?>X<?php } ?></td>
                    <td align='center'>
                        <a href="index.php?c=index&a=change&site_id=<?php echo $vo['site_id'];?>" target="_top">管理</a> |
                        <a href="index.php?c=index&a=site_edit&id=<?php echo $vo['site_id'];?>">修改</a> | 
						<a href="index.php?c=index&a=update_ad&id=<?php echo $vo['site_id'];?>">更新小程序广告</a> | 
						<a href="index.php?c=index&a=update_page&id=<?php echo $vo['site_id'];?>">更新小程序单页</a> | 
						<a href="index.php?c=index&a=update_category&id=<?php echo $vo['site_id'];?>">更新小程序分类</a> | 
						<a href="index.php?c=index&a=update_content&id=<?php echo $vo['site_id'];?>">更新小程序文章</a> | 
                        <?php if ($vo['status'] == 1) { ?>
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=index&a=site_close&id=<?php echo $vo['site_id'];?>','确定关停该站点吗?')">关停</a>
                        <?php } else { ?>
                        <a href="index.php?c=index&a=site_open&id=<?php echo $vo['site_id'];?>">开通</a>
                        <?php } ?>
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