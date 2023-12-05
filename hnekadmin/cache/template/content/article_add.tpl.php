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
    <link rel="stylesheet" href="<?php echo __PUBLIC__;?>" />
    <link rel="stylesheet" href="<?php echo __PUBLIC__;?>kindeditor/themes/default/default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/bootstrap_min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/css.css" media="all" />
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/jquery.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>kindeditor/kindeditor-all-min.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>DatePicker/DatePicker.js"></script>
    <script type="text/javascript">
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea.editor', {
                uploadJson:'index.php?c=Common&a=editor',
                allowFileManager : true,
                fileManagerJson: "index.php?c=Common&a=manager",
                urlType : '',
                formatUploadUrl:false,
                loadStyleMode : false
            });
        });
    </script>
    <title>E营销管理系统</title>
</head>
<body>
    <ul class="breadcrumb">
        <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">内容管理</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active"><?php echo $category['name'];?></li>
    </ul>
    <form action="" method="post" class="form-search">
        <input name="category_id" type="hidden" value="<?php echo $category['category_id'];?>">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td align="right"><strong>标题：</strong></td>
                    <td>
                        <input type="text" name="title" value="<?php echo @iHtmlSpecialChars($info['title']);?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>SEO长尾词：</strong></td>
                    <td>
                        <select name="tail_id">
                            <option value="0">--选择长尾词--</option>
                            <?php foreach ($seo_tail as $tail) {?>
                            <option value="<?php echo $tail['tail_id'];?>"><?php echo $tail['name'];?>（<?php if ($tail['prefix'] == 1) { ?>后缀<?php } else { ?>前缀<?php } ?>）</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>作者：</strong></td>
                    <td>
                        <input type="text" name="author" value="<?php echo @iHtmlSpecialChars($info['author']);?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>来源：</strong></td>
                    <td>
                        <input type="text" name="copyfrom" value="<?php echo @iHtmlSpecialChars($info['copyfrom']);?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>发布时间：</strong></td>
                    <td>
                        <input type="text" name="add_time" class="Wdate" value="<?php echo @date('Y-m-d');?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>关键字：</strong></td>
                    <td>
                        <textarea name="keywords" placeholder="关键字中间用半角逗号隔开"><?php echo @iHtmlSpecialChars($info['keywords']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>描述：</strong></td>
                    <td>
                        <textarea name="description" placeholder="针对搜索引擎设置的网页描述"><?php echo @iHtmlSpecialChars($info['description']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>封面图片：</strong></td>
                    <td>
                        <input type="hidden" name="image" id="image" value="" />&nbsp;<input type="button" class="btn btn-primary updateimgbutton" data-input_id="image" value="选择图片" />
                    </td>
                </tr>
                <?php foreach ($tags as $vo) {?>
                <tr>
                    <td align="right"><strong><?php echo $vo['name'];?>：</strong></td>
                    <td>
                        <ul class="tags_box">
                            
                            <li>
                                <?php foreach ($vo['tags'] as $val) {?>
                                    <span class="tags" data-tags="<?php echo $val['tags_id'];?>"><?php echo $val['name'];?></span>
                                <?php } ?>
                            </li>
                            
                        </ul>
                    </td>
                </tr>
                <?php } ?>
                <?php if(is_array($fields)){foreach ((array)$fields as $vo) {?>
                <?php if ($vo['type'] == 'text') { ?>
                <tr>
                    <td align="right"><strong><?php echo $vo['name'];?>：</strong></td>
                    <td>
                        <input type="text" name="data[<?php echo $vo['field'];?>]" value="" />
                    </td>
                </tr>
                <?php } ?>
                <?php if ($vo['type'] == 'textarea') { ?>
                <tr>
                    <td align="right"><strong><?php echo $vo['name'];?>：</strong></td>
                    <td>
                        <textarea name="data[<?php echo $vo['field'];?>]"></textarea>
                    </td>
                </tr>
                <?php } ?>
                <?php if ($vo['type'] == 'image') { ?>
                <tr>
                    <td align="right"><strong><?php echo $vo['name'];?>：</strong></td>
                    <td>
                        <input type="hidden" name="data[<?php echo $vo['field'];?>]" id="image_<?php echo $vo['field'];?>" value="" /><input type="button" data-input_id="image_<?php echo $vo['field'];?>" class="btn btn-primary updateimgbutton" value="选择图片" />
                    </td>
                </tr>
                <?php } ?>
                <?php }} ?>
                <tr>
                    <td align="right"><strong>内容：</strong></td>
                    <td>
                        <textarea name="content" style="width:800px;height:500px;" class="editor"><?php echo @iStripslashes($info['content']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>相关信息：</strong></td>
                    <td>
                        <input type="button" class="btn btn-primary" id="relation" value="相关信息" />
                        <ul id="relation_box"></ul>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>转向链接：</strong></td>
                    <td>
                        <input type="text" name="url" value="<?php echo @iHtmlSpecialChars($content['url']);?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>推荐：</strong></td>
                    <td>
                        <?php foreach ($posids as $vo) {?>
                        <label class="checkbox"><input name="posids[]" type="checkbox" value="<?php echo $vo['posids_id'];?>" ><?php echo $vo['name'];?></label>
                        <?php } ?>
                    </td>
                </tr>
                <?php if(is_array($fields)){foreach ((array)$fields as $vo) {?>
                <?php if ($vo['type'] == 'editor') { ?>
                <tr>
                    <td align="right"><strong><?php echo $vo['name'];?>：</strong></td>
                    <td>
                        <textarea name="data[<?php echo $vo['field'];?>]" style="width:800px;height:500px;" class="editor"></textarea>
                    </td>
                </tr>
                <?php } ?>
                <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center">
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
    var updateimg_type = '';
    var image_input_id = '';
    $(function(){
        $('.updateimgbutton').click(function(){
            $('#updateimg').removeData();
            updateimg_type = 'image';
            $('#myModalLabel').html('上传图片');
            image_input_id = $(this).data('input_id');
            $('#updateimg').modal({
                remote:'index.php?c=Common&a=upload'
            });
        });
        $('input[name=add_time]').click(function(){
			WdatePicker({
				dateFmt:'yyyy-MM-dd'
			});
		});
        $('#updateimg').on('hidden', function () {
            $(this).removeData();
        });
        $('.tags').click(function(){
            var tags_id = $(this).data('tags');
            if($(this).data('active') == 1){
                $(this).removeClass('active');
                $(this).data('active',0);
                $(this).nextAll('input[value="'+tags_id+'"]').remove();
            }else{
                $(this).addClass('active');
                $(this).data('active',1);
                $(this).after('<input value="'+tags_id+'" name="tags[]" type="hidden">');
            }
        });
        $('#relation').click(function(){
            $('#updateimg').removeData();
            updateimg_type = 'relation';
            $('#myModalLabel').html('相关信息');
            $('#updateimg').modal({
                remote:'index.php?c=content&a=relation'
            });
        });
        $('#updateimg_btn').click(function(){
            if(updateimg_type == 'image'){
                var path = $('.tab-pane:visible').find('input[name="image"]').val();
                $('#'+image_input_id).val(path);
                $('#'+image_input_id).siblings('img').remove();
                $('#'+image_input_id).after('<img width="30" height="30" src="'+path+'"> ');
            }else if(updateimg_type == 'album'){
                var html = '<li>';
                $.each($('.tab-pane:visible').find('input[name="album[]"]'),function(index,data){
                    var html = '<li>';
                    html += '<input type="hidden" name="album[]" value="'+$(data).val()+'">';
                    html += '<img title="点击删除" src="'+$(data).val()+'">';
                    html += '<a class="album" href="javascript:void(0)">删除</a>';
                    html += '</li>';
                    $('#album_box').prepend(html);
                });
            }
        });
    });
    </script>
</body>
</html>