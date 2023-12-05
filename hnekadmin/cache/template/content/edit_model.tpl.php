<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=edit_model" method="post" id="modal_form">
    <input name="model_id" type="hidden" value="<?php echo $model['model_id'];?>">
    <table>
        <tr>
            <td width="40%" align="right"><strong>模型名称：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="<?php echo $model['name'];?>">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>模型描述：</strong></td>
            <td class="lt">
                <textarea name="description" placeholder="" ><?php echo $model['description'];?></textarea>
            </td>
        </tr>
    </table>
</form>