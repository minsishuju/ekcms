<?php if (!defined('IN_FW')) exit('Access Denied');?>
<form action="index.php?c=index&a=add_keywords_category" method="post" class="form-inline" id="modal_form">
    <table>
        <tr>
            <td width="40%" align="right"><strong>关键词分类：</strong></td>
            <td class="lt">
                <input type="text" name="name" value="">
            </td>
        </tr>
        <tr>
            <td width="40%" align="right"><strong>必须：</strong></td>
            <td class="lt">
                <label class="radio"><input type="radio" name="need" value="1">是</label>
                <label class="radio"><input type="radio" name="need" value="0">否</label>
            </td>
        </tr>
    </table>
</form>