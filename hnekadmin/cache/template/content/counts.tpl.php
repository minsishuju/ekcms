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
            <li class="active">数据统计</li>
        </ul>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="9">共计<?php echo $total;?>条数据，昨天新增<?php echo $yesterday;?>条数据，前天新增<?php echo $day_before;?>条数据，大前天新增<?php echo $before_that;?>条数据。</th>
                </tr>
                <tr>
                    <th width="150">栏目名称</th>
                    <th width="100">栏目类型</th>
                    <th width="150">数据量（今日新增<?php echo $today;?>）</th>
                    <th width="150">导航显示</th>
                    <th width="100">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td>
                        <?php for ($i=1;$i<$vo['stort'];$i++) {?>
                        &nbsp;&nbsp;&nbsp;
                        <?php } ?>
                        <?php if ($vo['parent_id'] != 0) { ?>
                        |--
                        <?php } ?>
                        <?php echo $vo['name'];?>
                    </td>
                    <td align='center'><?php if ($vo['type_id'] == 1) { ?>文章<?php } elseif ($vo['type_id'] == 2) { ?>图集<?php } elseif ($vo['type_id'] == 3) { ?>单页<?php } elseif ($vo['type_id'] == 4) { ?>链接<?php } ?></td>
                    <td align='center'>
                        <?php if ($vo['type_id'] != 4 && !$vo['child'] && $vo['type_id'] != 3) { ?>
                        <?php echo @intval($vo['num']);?>（<?php echo @intval($vo['num_y']);?>）
                        <?php } ?>
                    </td>
                    <td align='center'><?php if ($vo['is_show'] == 1) { ?>√<?php } else { ?>X<?php } ?></td>
                    <td align='center'>
                        <?php if ($vo['type_id'] == 4 || ($vo['child'] && $vo['type_id'] != 3)) { ?>
                        <a href="javascript:void(0);">
                        <?php } else { ?>
                        <a href="index.php?c=content&a=lists&id=<?php echo $vo['category_id'];?>" target="mainFrame">
                        <?php } ?>
                            内容管理
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>