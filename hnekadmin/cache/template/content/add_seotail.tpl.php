<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=content&a=add_seotail" id="modal_form" method="post" class="form-search">
    <table>
        <tr>
            <td width="40%" align="right"><strong>长尾词：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>位置：</strong></td>
            <td class="lt">
                <label class="radio">
                    <input name="prefix" type="radio" value="0" >前缀
                </label>
                <label class="radio">
                    <input name="prefix" type="radio" value="1" >后缀
                </label>
            </td>
        </tr>
    </table>
</form>