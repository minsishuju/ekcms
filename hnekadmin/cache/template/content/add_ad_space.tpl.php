<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=add_ad_space" method="post" id="modal_form">
    <table>
        <tr>
            <td width="40%" align="right"><strong>版位名称：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>版位描述：</strong></td>
            <td class="lt">
                <textarea name="description" placeholder="" ></textarea>
            </td>
        </tr>
    </table>
</form>