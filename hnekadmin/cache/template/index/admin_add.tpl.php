<?php if (!defined('IN_FW')) exit('Access Denied');?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/bootstrap_min.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/css.css" media="all" />
        <title>E营销管理系统</title>
    </head>
    <body>
        <ul class="breadcrumb">
            <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
            <li><a href="javascript:void(0)">账号设置</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">添加账号</li>
        </ul>
        <form action="" method="post" class="form-inline">
            <table class="table table-bordered">
                <tr>
                    <td width="20%" align="right"><strong>账号：</strong></td>
                    <td class="lt">
                        <input type="text" name="user_name" class="ipt" size="45" value="<?php echo $info['user_name'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%" align="right"><strong>昵称：</strong></td>
                    <td class="lt">
                        <input type="text" name="nickname" class="ipt" size="45" value="<?php echo $info['nickname'];?>">
                    </td>
                </tr>
                <tr>
                    <td width="20%" align="right"><strong>密码：</strong></td>
                    <td class="lt">
                        <input type="password" name="newPw" class="ipt" size="45" value="">
                    </td>
                </tr>
                <tr>
                    <td width="20%" align="right"><strong>重复密码：</strong></td>
                    <td  class="lt">
                        <input type="password" name="regPw" class="ipt" size="45" value="">
                    </td>
                </tr>
                <tr>
                    <td width="20%" align="right"><strong>状态：</strong></td>
                    <td  class="lt">
                        <label class="radio"><input type="radio" name="isvalid" value="1" checked="checked"> 启用</label>
                        <label class="radio"><input type="radio" name="isvalid" value="0"> 禁用</label>
                    </td>
                </tr>
                <tr>
                    <td width="20%" align="right"><strong>管理站点：</strong></td>
                    <td  class="lt">
                        <select name="site_id">
                            <?php if(is_array($sites)){foreach ((array)$sites as $site) {?>
                            <option value="<?php echo $site['site_id'];?>"><?php echo $site['name'];?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-primary" type="submit" value="保 存" />
                        <input class="btn btn-warning" type="button" onclick="javascript:history.back(-1);" value="返 回" >
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>