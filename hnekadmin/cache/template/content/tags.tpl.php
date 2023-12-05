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
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/bootstrap.min.js" ></script>
    <title>E营销管理系统</title>
</head>
<body>
    <ul class="breadcrumb">
        <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">内容管理</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">内容相关设置</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active">标签管理</li>
        <li class="pull-right" style="margin-top:-3px">
            <a class="btn btn-small btn-primary pull-right" href="javascript:void(0);" id="add_tags_category">添加分类</a>
        </li>
    </ul>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">分类</th>
                <th width="90%">标签</th>
                <th width="5%">管理操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $vo) {?>
            <tr>
                <td align='center'><?php echo $vo['name'];?></td>
                <td class="tag_category">
                    <?php foreach ($vo['tags'] as $val) {?>
                    <span class="tags" data-tags="<?php echo $val['tags_id'];?>"><font class="edit_tags"><?php echo @iStripslashes($val['name']);?></font><a href="javascript:void(0);" class="delete_tags">×</a></span>
                    <?php } ?>
                    <div class="input-append">
                        <input class="span1" type="text">
                        <button class="btn add_tags" data-category="<?php echo $vo['category_id'];?>" type="button">确定</button>
                    </div>
                </td>
                <td align='center'>
                    <a href="javascript:void(0)" class="edit_tags_category" data-category="<?php echo $vo['category_id'];?>">修改</a>&nbsp;|&nbsp;
                    <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=content&a=delete_tags_category&id=<?php echo $vo['category_id'];?>','确定删除“<?php echo $vo['name'];?>”吗?')">删除</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
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
        $(function(){
            $('#add_tags_category').click(function(){
                $('#myModalLabel').html('添加标签分类');
                $('#tags_category').modal({
                    remote:'index.php?c=content&a=add_tags_category'
                });
            });
            $('.edit_tags_category').click(function(){
                $('#myModalLabel').html('修改标签分类');
                var category_id = $(this).data('category');
                $('#tags_category').modal({
                    remote:'index.php?c=content&a=edit_tags_category&category_id='+category_id
                });
            });
            $('#tags_category').on('hidden', function () {
                $(this).removeData();
            })
            $('#modal_submit').click(function(){
                $('#modal_form').submit();
            });
            
            $('.add_tags').click(function(){
                var _this = $(this);
                var tags_name = $(this).prev('input').val();
                var category_id = $(this).data('category');
                if(tags_name != ''){
                    $.post('index.php?c=content&a=add_tags',{name:tags_name,category_id:category_id},function(data){
                        if(data.status == 1){
                            _this.prev('input').val('');
                            _this.parent().before('<span class="tags" data-tags="'+data.tags_id+'"><font class="edit_tags">'+data.tags_name+'</font><a href="javascript:void(0);" class="delete_tags">×</a>');
                            
                        }else{
                            alert(data.msg);
                        }
                    })
                }
            });
            $('.tag_category').on('click','.edit_tags',function(){
                var _this = $(this);
                var tags_id = _this.parent().data('tags');
                $('#myModalLabel').html('修改标签');
                $('#tags_category').modal({
                    remote:'index.php?c=content&a=edit_tags&tags_id='+tags_id
                });
            });
            $('.tag_category').on('click','.delete_tags',function(){
                var _this = $(this);
                var tags_name = _this.prev().html();
                var tags_id = _this.parent().data('tags');
                if(confirm('你确定删除“'+tags_name+'”么？')){
                    $.get('index.php?c=content&a=delete_tags&tags_id='+tags_id,function(data){
                        if(data.status == 1){
                            _this.parent().remove();
                        }else{
                            alert(data.msg);
                        }
                    })
                }
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