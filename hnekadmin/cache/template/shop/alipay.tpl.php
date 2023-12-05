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
        <li class="active">支付宝支付设置</li>
    </ul>
    <form action="index.php?c=shop&a=save_config" method="post" class="form-search">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td align="right" width="20%"><strong>支付方式描述：</strong></td>
                    <td>
                        <textarea name="config[alipay_description]" placeholder="" ><?php echo @iHtmlSpecialChars($config['alipay_description']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>支付宝帐户：</strong></td>
                    <td>
                        <input type="text" name="config[alipay_account]" value="<?php echo @iHtmlSpecialChars($config['alipay_account']);?>" placeholder="" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>交易安全校验码：</strong></td>
                    <td>
                        <input type="text" name="config[alipay_key]" value="<?php echo @iHtmlSpecialChars($config['alipay_key']);?>" placeholder="" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>合作者身份ID 	：</strong></td>
                    <td>
                        <input type="text" name="config[alipay_partner]" value="<?php echo @iHtmlSpecialChars($config['alipay_partner']);?>" placeholder="" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>合作者身份ID 	：</strong></td>
                    <td>
                        <select name="config[alipay_pay_method]">
                            <option <?php if ($config['alipay_pay_method'] == 1) { ?>selected="selected"<?php } ?> value="2">使用即时到帐交易接口</option>
                            <option <?php if ($config['alipay_pay_method'] == 2) { ?>selected="selected"<?php } ?> value="1">使用担保交易接口</option>
                            <option <?php if ($config['alipay_pay_method'] == 3) { ?>selected="selected"<?php } ?> value="0">使用标准双接口</option>
                        </select>
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