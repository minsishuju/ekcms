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
            <li><a href="javascript:void(0)">内容相关设置</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">SEO长尾词</li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="javascript:void(0);" id="add_seotail">添加SEO长尾词</a>
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="15%">ID</th>
                    <th width="40%">长尾词</th>
                    <th width="30%">位置</th>
                    <th width="15%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['tail_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td align='center'><?php if ($vo['prefix'] == 1) { ?>后缀<?php } else { ?>前缀<?php } ?></td>
                    <td align='center'>
                        <a href="javascript:void(0)" class="edit_seotail" data-tail_id="<?php echo $vo['tail_id'];?>">修改</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=content&a=delete_seotail&id=<?php echo $vo['tail_id'];?>','确定删除“<?php echo $vo['name'];?>”吗?')">删除</a>
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
        <div id="tags_category" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            function confirmurl(url,message){
                if(confirm(message)){
                    location.replace(url);
                }
            }
            $(function(){
                $('#add_seotail').click(function(){
                    $('#myModalLabel').html('添加SEO长尾词');
                    $('#tags_category').modal({
                        remote:'index.php?c=content&a=add_seotail'
                    });
                });
                $('.edit_seotail').click(function(){
                    $('#myModalLabel').html('修改SEO长尾词');
                    var tail_id = $(this).data('tail_id');
                    $('#tags_category').modal({
                        remote:'index.php?c=content&a=edit_seotail&id='+tail_id
                    });
                });
                $('#tags_category').on('hidden', function () {
                    $(this).removeData();
                })
                $('#modal_submit').click(function(){
                    $('#modal_form').submit();
                });
            });
        </script>
    </body>
</html>