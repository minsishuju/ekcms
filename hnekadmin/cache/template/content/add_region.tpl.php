<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=add_region" id="modal_form" method="post">
    <table>
        <tr>
            <td width="40%" align="right"><strong>分站名称：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>唯一标示：</strong></td>
            <td class="lt">
                <input type="text" name="mark" placeholder="仅限英文小写字母" value="">
            </td>
        </tr>
    </table>
</form>