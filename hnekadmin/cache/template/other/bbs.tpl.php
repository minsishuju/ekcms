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
            <li class="active"><a href="index.php?c=other&a=bbs">论坛管理</a></li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">楼主昵称</th>
                    <th width="10%">IP地址</th>
                    <th width="10%">话题内容</th>
                    <th width="10%">留言时间</th>
                    <th width="10%">查看该话题回复</th>
                    <th width="10%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['bbs_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td ><?php echo $vo['ip'];?></td>
                    <td ><?php echo @iCutstr($vo['title'],75);?></td>
                    <td ><?php echo @date('Y-m-d H:i:s',$vo['addtime']);?></td>
                    <td ><a href="index.php?c=other&a=bbs_show&id=<?php echo $vo['bbs_id'];?>">查看回复</a></td>
                    <td align='center'>
                        <?php if ($vo['is_show']=='0') { ?>
                        <a href="javascript:void(0)" onClick="return confirmurl('index.php?c=other&a=change&id=<?php echo $vo['bbs_id'];?>','确定通过审核吗?')"><font color=red>未审核</font></a>
                        <?php } else { ?> 
                        通过
                        <?php } ?>
                        |
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=other&a=delete_bbs&id=<?php echo $vo['bbs_id'];?>','确定删除“<?php echo @iStripslashes($vo['name']);?>”的留言吗?')">删除</a>                       
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