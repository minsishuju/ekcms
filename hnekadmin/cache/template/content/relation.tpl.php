<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="" method="post" id="content_form" class="form-inline">
    <ul class="breadcrumb">
        <li>
            <b class="kserico">栏目：</b>
            <select name="category_id" class="input-small">
                <option value="0">全部</option>
                <?php foreach ($categorys as $vo) {?>
                    <?php if ($vo['type_id'] == 1 || $vo['type_id'] == 2) { ?>
                    <option value="<?php echo $vo['category_id'];?>" <?php if ($_GET['category_id'] == $vo['category_id']) { ?>selected="selected"<?php } ?>>
                        <?php for ($i=1;$i<$vo['stort'];$i++) {?>
                        &nbsp;&nbsp;&nbsp;
                        <?php } ?>
                        <?php if ($vo['parent_id'] != 0) { ?>
                        |--
                        <?php } ?>
                        <?php echo $vo['name'];?>
                    </option>
                    <?php } ?>
                <?php } ?>
            </select>
            <b class="kserico">标题：</b>
            <input name="name" type="text" class="input-mini" value="<?php echo $_GET['name'];?>"> 
            <input type="button" class="btn" id="search_content" value="搜 索">
        </li>
    </ul>
</form>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="15">ID</th>
            <th>标题</th>
            <th width="50">添加时间</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $vo) {?>
        <tr>
            <td><label class="checkbox"><input type="checkbox" name="content_id" value="<?php echo $vo['content_id'];?>"><?php echo $vo['content_id'];?></label></td>
            <td ><a href="javascript:void(0)" title="<?php echo $vo['title'];?>"><?php echo @iCutstr($vo['title'],55);?></a></td>
            <td align='center'><?php echo @date('Y-m-d',$vo['add_time']);?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr> 
            <td colspan="3"><div class="pagination"><?php echo $page;?></div></td>
        </tr>
    </tfoot>
</table>
<script>
$(function(){
    $('.pagination a').click(function(){
        $.get($(this).attr('href'),function(data){
            $('#updateimg .modal-body').html(data);
        },'html')
        return false;
    });
    $('input[name="content_id"]').click(function(){
        var content_id = $(this).val();
        if($(this).is(':checked')){
            if($('#relation_box').children('li[rel="' + content_id + '"]').length <= 0){
                var html = '<li rel="' + content_id + '">' + $(this).parents('td').next().html() + '<input type="hidden" value="' + content_id + '" name="ids[]"></li>';
                $('#relation_box').append(html);
            }
        }else{
            $('#relation_box').children('li[rel="' + content_id + '"]').remove();
        }
        
    });
    $('#search_content').click(function(){
        var name = $('#content_form input[name="name"]').val();
        var category_id = $('#content_form select[name="category_id"]').val();
        $.get('index.php?c=content&a=relation&category_id='+category_id +'&name='+name,function(data){
            $('#updateimg .modal-body').html(data);
        },'html')
        return false;
    });
});
</script>