<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=edit_posids" method="post" id="modal_form">
    <input name="posids_id" type="hidden" value="<?php echo $info['posids_id'];?>">
    <table>
        <tr>
            <td width="40%" align="right"><strong>推荐位名称：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="<?php echo $info['name'];?>">
            </td>
        </tr>
    </table>
</form>