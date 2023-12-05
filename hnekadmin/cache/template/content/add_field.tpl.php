<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=add_field" method="post" id="modal_form">
    <input name="model_id" type="hidden" value="<?php echo $model['model_id'];?>">
    <table>
        <tr>
            <td width="40%" align="right"><strong>字段别名：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>字段名：</strong></td>
            <td class="lt">
                <input type="text" name="field" value="">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>字段类型：</strong></td>
            <td class="lt">
                <select name="type">
                    <option value="text">单行文本</option>
                    <option value="textarea">多行文本</option>
                    <option value="editor">编辑器</option>
                    <option value="image">图片</option>
                </select>
            </td>
        </tr>
    </table>
</form>