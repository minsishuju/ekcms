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
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/jquery.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/bootstrap.min.js" ></script>
    <title>E营销管理系统</title>
</head>
<body>
    <ul class="breadcrumb">
        <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">内容管理</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">推广管理</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active">添加友情链接</li>
    </ul>
    <form action="" method="post" class="form-search">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td align="right" width="20%"><strong>网站名称：</strong></td>
                    <td>
                        <input type="text" name="name" size="45" value="" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>链接地址：</strong></td>
                    <td>
                        <input type="text" name="links_url" placeholder="填写完整url地址，包括http://" size="45" value="" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>网站LOGO：</strong></td>
                    <td>
                        <input type="hidden" name="image" id="image" value="" />&nbsp;<input type="button" class="btn btn-primary" id="updateimgbutton" value="选择图片" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>网站信息：</strong></td>
                    <td>
                        <textarea name="introduce" placeholder="此信息只对管理员可见，可对该友链添加备注信息"></textarea>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-center">
                        <input class="btn btn-primary" type="submit" value="保 存" />
                        <input class="btn btn-warning" type="button" onclick="javascript:history.back(-1);" value="返 回" />
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div id="updateimg" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">上传图片</h3>
        </div>
        <div class="modal-body">
            <p style="text-algin:center">loadding......</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            <button class="btn btn-primary" data-dismiss="modal" id="updateimg_btn" aria-hidden="true">确定</button>
        </div>
    </div>
    <script>
    $(function(){
        $('#updateimgbutton').click(function(){
            $('#updateimg').removeData();
            $('#updateimg').modal({
                remote:'index.php?c=Common&a=upload'
            });
        });
        $('#updateimg').on('hidden', function () {
            $(this).removeData();
        });
        $('#updateimg_btn').click(function(){
            var path = $('.tab-pane:visible').find('input[name="image"]').val();
            $('#image').val(path);
            $('#image').siblings('img').remove();
            $('#image').after('<img width="30" height="30" src="'+path+'"> ');
        });
    });
    </script>
</body>
</html>