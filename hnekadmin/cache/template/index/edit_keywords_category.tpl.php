<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=index&a=edit_keywords_category" method="post" class="form-inline" id="modal_form">
    <input name="category_id" value="<?php echo $info['category_id'];?>" type="hidden">
    <table>
        <tr>
            <td width="40%" align="right"><strong>关键词分类：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="<?php echo $info['name'];?>">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>必须：</strong></td>
            <td class="lt">
                <label class="radio"><input type="radio" name="need" value="1" <?php if ($info['need'] == 1) { ?>checked="checked"<?php } ?> />是</label>
                <label class="radio"><input type="radio" name="need" value="0" <?php if ($info['need'] == 0) { ?>checked="checked"<?php } ?> />否</label>
            </td>
        </tr>
    </table>
</form>