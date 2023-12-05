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
            <li><a href="javascript:void(0)">站点管理</a> <span class="divider">&gt;&gt;</span></li>
            <li class="active">修改站点信息</li>
        </ul>
        <form action="" method="post" class="form-search">
            <input name="site_id" type="hidden" value="<?php echo $info['site_id'];?>">
            <table class="table table-bordered">
                <tr>
                    <td align="right"><strong>站点名称：</strong></td>
                    <td class="lt">
                        <input type="text" name="name" value="<?php echo @iHtmlSpecialChars($info['name']);?>">
                    </td>
                    <td align="right"><strong>站点域名：</strong></td>
                    <td class="lt">
                        <input type="text" readonly="readonly" value="<?php echo @iHtmlSpecialChars($info['siteurl']);?>">
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>联系人：</strong></td>
                    <td class="lt">
                        <input type="text" name="contacts" value="<?php echo @iHtmlSpecialChars($info['contacts']);?>">
                    </td>
                    <td align="right"><strong>联系电话：</strong></td>
                    <td class="lt">
                        <input type="text" name="phone" value="<?php echo @iHtmlSpecialChars($info['phone']);?>">
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>站点标题：</strong></td>
                    <td class="lt">
                        <input type="text" name="site_title" value="<?php echo @iHtmlSpecialChars($info['site_title']);?>">
                    </td>
                    <td align="right"><strong>站点状态：</strong></td>
                    <td class="lt">
                        <label><input type="radio" name="status" value="1" <?php if ($info['status'] == 1) { ?>checked="checked"<?php } ?>>开启</label>
                        <label><input type="radio" name="status" value="0" <?php if ($info['status'] == 0) { ?>checked="checked"<?php } ?>>关闭</label>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>站点关键字：</strong></td>
                    <td class="lt">
                        <textarea name="keywords" style="margin:5px 0;width:400px;height:200px;"><?php echo @iHtmlSpecialChars($info['keywords']);?></textarea>
                    </td>
                    <td align="right"><strong>站点描述：</strong></td>
                    <td class="lt">
                        <textarea name="description" style="margin:5px 0;width:400px;height:200px;"><?php echo @iHtmlSpecialChars($info['description']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>热搜关键词：</strong></td>
                    <td class="lt">
                        <textarea name="hotwords" style="margin:5px 0;width:400px;height:200px;"  placeholder="关键词中间用半角逗号隔开"><?php echo @iHtmlSpecialChars($info['hotwords']);?></textarea>
                    </td>
                    <td align="right"><strong>统计代码：</strong></td>
                    <td class="lt">
                        <textarea name="site_code" style="margin:5px 0;width:400px;height:200px;"><?php echo @iHtmlSpecialChars($info['site_code']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center">
                        <input class="btn btn-primary" type="submit" value="保 存" />
                        <input class="btn btn-warning" type="button" onclick="javascript:history.back(-1);" value="返 回" >
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>