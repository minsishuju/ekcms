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
        <li><a href="javascript:void(0)">栏目管理</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active">添加栏目</li>
    </ul>
    <form action="" method="post" class="form-search">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td width="15%" align="right"><strong>上级栏目：</strong></td>
                    <td width="35%">
                        <select name="parent_id" >
                            <option value="0">顶级栏目</option>
                            <?php foreach ($list as $vo) {?>
                            <option value="<?php echo $vo['category_id'];?>">
                                <?php for ($i=1;$i<$vo['stort'];$i++) {?>
                                &nbsp;&nbsp;&nbsp;
                                <?php } ?>
                                <?php if ($vo['parent_id'] != 0) { ?>
                                |--
                                <?php } ?>
                                <?php echo $vo['name'];?>
                            </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td align="right"><strong>导航显示：</strong></td>
                    <td>
                        <label class="radio"><input type="radio" name="is_show" value="1" checked="checked" />是</label>
                        <label class="radio"><input type="radio" name="is_show" value="0" />否</label>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>栏目名称：</strong></td>
                    <td>
                        <input type="text" name="name" size="45" value="" />
                    </td>
                    <td align="right"><strong>栏目别名：</strong></td>
                    <td>
                        <input type="text" name="nickname" size="45" value="" />
                    </td>
                </tr>
                <tr>
                    <td width="15%" align="right"><strong>栏目类型：</strong></td>
                    <td width="35%">
                        <select name="type_id" id="type_id" >
                            <option value="1">文章</option>
                            <option value="2">图集</option>
                            <option value="3">单页</option>
                            <option value="4">链接</option>
                        </select>
                    </td>
                    <td width="15%" align="right"><strong>栏目模型：</strong></td>
                    <td width="35%">
                        <select name="model_id" id="model_id" >
                            <option value="0">默认模型</option>
                            <?php if(is_array($models)){foreach ((array)$models as $vo) {?>
                            <option value="<?php echo $vo['model_id'];?>"><?php echo $vo['name'];?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>SEO标题：</strong></td>
                    <td>
                        <input type="text" name="title" size="45" value="" />
                    </td>
                    <td align="right"><strong>唯一标示：</strong></td>
                    <td>
                        <input type="text" name="url_name" size="45" placeholder="用于单页的url文件名" value="" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>栏目关键词：</strong></td>
                    <td>
                        <textarea name="keywords" placeholder="关键字中间用半角逗号隔开"></textarea>
                    </td>
                    <td align="right"><strong>栏目描述：</strong></td>
                    <td>
                        <textarea name="description" placeholder="针对搜索引擎设置的网页描述"></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>栏目图片：</strong></td>
                    <td colspan="3">
                        <input type="hidden" name="image" id="image" value="" />&nbsp;<input type="button" class="btn btn-primary" id="updateimgbutton" value="选择图片" />
                    </td>
                    
                </tr>
                <tr class="nurl">
                    <td align="right"><strong>列表页模板：</strong></td>
                    <td>
                        <select name="list_template" >
                            <option value="">默认</option>
                            <?php foreach ($list_template as $vo) {?>
                            <option value="<?php echo $vo;?>"><?php echo $vo;?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td align="right" class="nshow"><strong>内容页模板：</strong></td>
                    <td class="nshow">
                        <select name="show_template" >
                            <option value="">默认</option>
                            <?php foreach ($show_template as $vo) {?>
                            <option value="<?php echo $vo;?>"><?php echo $vo;?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr class="url" style="display: none;">
                    <td align="right"><strong>链接地址：</strong></td>
                    <td colspan="3">
                        <input type="text" name="url" size="45" value="<?php echo $info['url'];?>" />
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
        $('#type_id').change(function(){
            var type_id = $(this).val();
            switch (type_id){
                case '1':
                case '2':
                    $('#model_id').prop('disabled',false);
                    $('.nshow').children().show();
                    $('.url').hide();
                    $('.nurl').show();
                break;
                case '3':
                    $('#model_id').prop('disabled',true);
                    $('.nshow').children().hide();
                    $('.url').hide();
                    $('.nurl').show();
                break;
                case '4':
                    $('#model_id').prop('disabled',true);
                    $('.url').show();
                    $('.nurl').hide();
                break;
            }
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