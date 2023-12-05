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
            <li class="active">内容采集</li>
            <li class="pull-right" style="margin-top:-3px">
                <a class="btn btn-small btn-primary pull-right" href="index.php?c=collection&a=add">添加采集点</a>
            </li>
        </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="20%">名称</th>
                    <th width="5%">最后采集时间</th>
                    <th width="5%">内容操作</th>
                    <th width="10%">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $vo) {?>
                <tr>
                    <td align='center'><?php echo $vo['node_id'];?></td>
                    <td ><?php echo $vo['name'];?></td>
                    <td align='center'><?php echo @date('Y-m-d H:i:s',$vo['lastdate']);?></td>
                    <td align='center'>
                        <a href="index.php?c=collection&a=col_url_list&id=<?php echo $vo['node_id'];?>">采集网址</a> | 
                        <a href="index.php?c=collection&a=col_content&id=<?php echo $vo['node_id'];?>">采集内容</a> | 
                        <a href="index.php?c=collection&a=publist&id=<?php echo $vo['node_id'];?>">内容管理</a>
                    </td>
                    <td align='center'>
                        <a href="index.php?c=collection&a=edit&id=<?php echo $vo['node_id'];?>">修改</a> | 
                        <a href="javascript:void(0)" onclick="return confirmurl('index.php?c=collection&a=delete&id=<?php echo $vo['node_id'];?>','确定删除“<?php echo $vo['name'];?>”吗?')">删除</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr >
                    <td colspan="5"><div class="pagination"><?php echo $page;?></div></td>
                </tr>
            </tfoot>
        </table>
        <div id="posids" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">批量移动</h3>
            </div>
            <div class="modal-body">
                <p style="text-algin:center">loadding......</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
        <script>
            function confirmurl(url,message){
                if(confirm(message)){
                    location.replace(url);
                }
            }
            $(function(){
                $('.listorders').click(function(){
                    if($(this).children('input').length > 0){
                        return false;
                    }else{
                        $(this).html('<input style="width:15px;" id="listorder' + $(this).data('content_id') + '" data-original="' + $(this).html() + '" value="' + $(this).html() + '">');
                        $(this).children('input').focus();
                        $(this).css({padding:'0'});
                    }
                });
                $('.listorders').hover(
                    function(){
                        $(this).css({background:'#CCCCCC'})
                    },
                    function(){
                        $(this).css({background:'#FFFFFF'})
                    }
                );
                $('.listorders').on('blur','input',function(){
                    var content_id = $(this).parent().data('content_id');
                    var listorder = $(this).val();
                    $.post('index.php?c=content&a=listorder',{content_id:content_id,listorder:listorder},function(data){
                        $('#listorder'+data.content_id).parent().css({padding:'0 10px'});
                        if(data.status == 1){
                            $('#listorder'+data.content_id).parent().html(listorder);
                        }else{
                            $('#listorder'+data.content_id).parent().html($('#listorder'+data.content_id).data('original'));
                        }
                    });
                    return false;
                });
                $('#select_all').change(function(){
                    $('.select').prop('checked',$(this).prop('checked'));
                });
                $('#move_all').click(function(){
                    var ids = new Array();
                    $('.select:checked').each(function(){
                        ids.push($(this).val());
                    });
                    ids = ids.join(',');
                    $('#posids').modal({
                        width  : 360,
                        height : 640,
                        remote : 'index.php?c=content&a=move_content&ids='+ids
                    });
                });
                $('#posids').on('hidden', function () {
                    $(this).removeData();
                });
            })
        </script>
    </body>
</html>