<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=edit_field" method="post" id="modal_form">
    <input name="field_id" type="hidden" value="<?php echo $field['field_id'];?>">
    <table>
        <tr>
            <td width="40%" align="right"><strong>字段别名：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="<?php echo $field['name'];?>">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>字段名：</strong></td>
            <td class="lt">
                <input type="text" disabled="disabled" value="<?php echo $field['field'];?>">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>字段类型：</strong></td>
            <td class="lt">
                <select disabled="disabled" name="type">
                    <option value="text" <?php if ($field['type'] == 'text') { ?>selected="selected"<?php } ?>>单行文本</option>
                    <option value="textarea" <?php if ($field['type'] == 'textarea') { ?>selected="selected"<?php } ?>>多行文本</option>
                    <option value="editor" <?php if ($field['type'] == 'editor') { ?>selected="selected"<?php } ?>>编辑器</option>
                    <option value="image" <?php if ($field['type'] == 'image') { ?>selected="selected"<?php } ?>>图片</option>
                </select>
            </td>
        </tr>
    </table>
</form>