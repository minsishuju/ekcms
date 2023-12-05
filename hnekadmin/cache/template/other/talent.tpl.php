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
            <li><a href="javascript:void(0)">模块管理</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">招聘管理</li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="index.php?c=other&a=add_job_position">添加职位</a>
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="15%">职位名称</th>
                    <th width="10%">职位类别</th>
                    <th width="10%">工作地点</th>
                    <th width="10%">招聘人数</th>
                    <th width="10%">申请人数（最新）</th>
                    <th width="10%">招聘状态</th>
                    <th width="10%">刷新时间</th>
                    <th width="10%">添加时间</th>
                    <th width="10%">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['position_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td align='center' ><?php echo $vo['type'];?></td>
                    <td ><?php echo $vo['address'];?></td>
                    <td align='center' ><?php echo $vo['number'];?></td>
                    <td align='center' ><?php echo $vo['resume_num'];?>(<?php echo $vo['resume_today_num'];?>)</td>
                    <td align='center' ><?php if ($vo['status'] == 1) { ?>招聘中<?php } elseif ($vo['status'] == 2) { ?>已结束<?php } else { ?>未开始<?php } ?></td>
                    <td align='center' ><?php echo @date('Y-m-d',$vo['update_time']);?></td>
                    <td align='center' ><?php echo @date('Y-m-d',$vo['add_time']);?></td>
                    <td align='center'>
                        <a href="index.php?c=other&a=list_resume&position_id=<?php echo $vo['position_id'];?>">查看申请</a> | 
                        <a href="index.php?c=other&a=update_job&position_id=<?php echo $vo['position_id'];?>">刷新</a> | 
                        <a href="index.php?c=other&a=edit_job_position&id=<?php echo $vo['position_id'];?>">修改</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=other&a=delete_job_position&id=<?php echo $vo['position_id'];?>','确定删除“<?php echo @iStripslashes($vo['name']);?>”及其所有求职信息吗?')">删除</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr > 
                    <td colspan="10"><div class="pagination"><?php echo $page;?></div></td>
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