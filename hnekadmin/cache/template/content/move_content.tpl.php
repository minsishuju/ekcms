<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=move_content" method="post" id="content_form" class="form-inline">
<?php if(is_array($ids)){foreach ((array)$ids as $id) {?>
<input name="ids[]" type="hidden" value="<?php echo $id;?>">
<?php }} ?>
<table class="table table-bordered">
    <tbody>
        <tr>
            <td>目标栏目</td>
            <td >
                <select name="to_category_id" class="input-small">
                <?php foreach ($list as $vo) {?>
                    <option value="<?php echo $vo['category_id'];?>" <?php if ($vo['type_id'] != $info['type_id'] || $vo['model_id'] != $info['model_id'] || $vo['type_id'] == 4 || $vo['type_id'] == 3 || $vo['child']) { ?>disabled="disabled"<?php } ?>>
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
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center" colspan="2">
                <input type="submit" value="确 定" class="btn btn-primary">
            </td>
        </tr>
    </tfoot>
</table>
</form>