<?php if (!defined('IN_FW')) exit('Access Denied');?>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>js/uploadify/uploadify.css" media="all" />
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/jquery.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/bootstrap.min.js" ></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>js/uploadify/jquery.uploadify.min.js" ></script>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#_uploadfile">上传附件</a></li>
    <li><a href="#_onlinefile">网络图片</a></li>
    <li><a href="#_album">图库</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="_uploadfile">
        <div class="uploadify_box">
            <ul id="_uploadify_one_box" class="clearfix">
            </ul>
            <input id="uploadify" type="file">
            <input name="image" value="" type="hidden">
        </div>
    </div>
    <div class="tab-pane" id="_onlinefile">
        <div class="uploadify_box">
            请输入网络地址：<input name="image" value="" type="text">
        </div>
    </div>
    <div class="tab-pane" id="_album">
        <ul id="_album_box" class="clearfix"></ul>
    </div>
</div>
<script>
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })
    $('#myTab a:last').on('show', function (e) {
        $.get('index.php?c=Common&a=album',function(data){
            var album = data.list;
            if(album.length > 0){
                var html = '';
                $.each(data.list,function(index,obj){
                    html += '<li><a class="off" href="javascript:void(0);"><div class="icon"></div><img src="/' + obj.path + '"></a></li>';
                });
                $('#_album_box').html(html);
                $('#_album_box').siblings('div').remove();
                $('#_album_box').after('<div id="album_page" class="pagination">'+data.page+'</div>');
            }else{
                $('#_album_box').html('');
            }
        });
    })
$(function(){
    $('#uploadify').uploadify({
        'buttonClass'       : 'btn btn-primary',
        'fileObjName'       : 'image',
        'fileSizeLimit'     : '2MB',
        'multi'             : false,
        'buttonText'        : '选择图片',
        'width'             : '60',
        'height'            : '30',
        'fileTypeExts'      : '*.jpg;*.jpeg;*.png;*.gif',
        'formData'          : {
            'file'      :'image',
            'site_id'   :'<?php echo $site_id;?>',
            'input_id'  :'<?php echo $input_id;?>'
        },
        'swf'               : '<?php echo __PUBLIC__;?>js/uploadify/uploadify.swf',
        'uploader'          : 'index.php?c=Common&a=upload',
        'onUploadSuccess'   : function(file, data, response){
            data = $.parseJSON(data);
            if(data.status == 0){
                alert(data.message);
            }else{
                var html = '<li>';
                html += '<input type="hidden" name="image" value="'+data.path+'">';
                html += '<img src="'+data.path+'">';
                html += '</li>';
                $('#_uploadify_one_box').html(html);
            }
        }
    });
    $('#_album').on('click','#album_page a',function(){
        $.get($(this).attr('href'),function(data){
            var album = data.list;
            if(album.length > 0){
                var html = '';
                $.each(data.list,function(index,obj){
                    html += '<li><a class="off" data-attachment_id="' + obj.attachment_id + '" href="javascript:void(0);"><div class="icon"></div><img src="/' + obj.path + '"></a></li>';
                });
                $('#_album_box').html(html);
                $('#_album_box').siblings('div').remove();
                $('#_album_box').after('<div id="album_page" class="pagination">'+data.page+'</div>');
            }else{
                $('#_album_box').html('');
            }
        });
        return false;
    });
    $('#_album').on('click','#_album_box a',function(){
        var path = $(this).children('img').attr('src');
        $('#_album_box').find('a').removeClass('on').addClass('off');
        $(this).removeClass('off').addClass('on');
        $('#_album').children('input').remove();
        $('#_album').append('<input name="image" value="'+path+'" type="hidden">');
        return false;
    });
});
</script>