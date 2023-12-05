<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=edit_ad_space" method="post" id="modal_form">
<input type="hidden" name="space_id" value="<?php echo $info['space_id'];?>">
    <table>
        <tr>
            <td width="40%" align="right"><strong>版位名称：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="<?php echo $info['name'];?>">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>版位描述：</strong></td>
            <td class="lt">
                <textarea name="description" ><?php echo $info['description'];?></textarea>
            </td>
        </tr>
    </table>
</form>