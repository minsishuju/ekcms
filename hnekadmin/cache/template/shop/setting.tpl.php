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
        <script src="<?php echo __PUBLIC__;?>js/jquery.js"></script>
        <script src="<?php echo __PUBLIC__;?>js/bootstrap.min.js"></script>
        <title>E营销管理系统</title>
    </head>
    <body>
    <ul class="breadcrumb">
        <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">商城管理</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">商城设置</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active">基本设置</li>
    </ul>
    <form action="index.php?c=shop&a=save_config" method="post" class="form-search">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td align="right" width="20%"><strong>商城名称：</strong></td>
                    <td>
                        <input type="text" name="config[site_name]" value="<?php echo @iHtmlSpecialChars($config['site_name']);?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>关键词：</strong></td>
                    <td>
                        <textarea name="config[keywords]" ><?php echo @iHtmlSpecialChars($config['keywords']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>描述：</strong></td>
                    <td>
                        <textarea name="config[description]" ><?php echo @iHtmlSpecialChars($config['description']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>客服QQ：</strong></td>
                    <td>
                        <input type="text" name="config[support_qq]" value="<?php echo @iHtmlSpecialChars($config['support_qq']);?>" placeholder="" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>积分抵扣：</strong></td>
                    <td>
                        <input type="text" name="config[point_price]" value="<?php echo @iHtmlSpecialChars($config['point_price']);?>" placeholder="" />分/1元
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-primary" type="submit" value="保 存" />
                        <input class="btn btn-warning" type="button" onclick="javascript:history.back(-1);" value="返 回" />
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    </body>
</html>