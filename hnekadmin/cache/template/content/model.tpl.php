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
            <li class="active">模型管理</li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="javascript:void(0);" id="add_model">添加模型</a>
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="20%">模型名称</th>
                    <th width="60%">模型描述</th>
                    <th width="15%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['model_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td ><?php echo $vo['description'];?></td>
                    <td align='center'>
                        <a href="index.php?c=content&a=model_field&model_id=<?php echo $vo['model_id'];?>">字段管理</a> | 
                        <a class="edit_model" href="javascript:void(0)" data-model_id="<?php echo $vo['model_id'];?>">修改</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=content&a=delete_model&id=<?php echo $vo['model_id'];?>','确定删除“<?php echo $vo['name'];?>”吗?')">删除</a>
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
        <div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"></h3>
            </div>
            <div class="modal-body">
                <p style="text-algin:center">loadding......</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                <button class="btn btn-primary" id="modal_submit" data-dismiss="modal" aria-hidden="true">确定</button>
            </div>
        </div>
        <script>
            $(function(){
                $('#add_model').click(function(){
                    $('#myModalLabel').html('添加模型');
                    $('#modal').removeData();
                    $('#modal').modal({
                        remote:'index.php?c=content&a=add_model'
                    });
                });
                $('.edit_model').click(function(){
                    $('#myModalLabel').html('修改模型');
                    var model_id = $(this).data('model_id');
                    $('#modal').removeData();
                    $('#modal').modal({
                        remote:'index.php?c=content&a=edit_model&id='+model_id
                    });
                });
                $('#modal').on('hidden', function () {
                    $(this).removeData();
                })
                $('#modal_submit').click(function(){
                    $('#modal_form').submit();
                });
            });
            function confirmurl(url,message){
                if(confirm(message)){
                    location.replace(url);
                }
            }
        </script>
    </body>
</html>