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
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/jquery.js" ></script>
    <title>E营销管理系统</title>
</head>
<body>
    <ul class="breadcrumb">
        <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">微信管理</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active">微信消息设置</li>
    </ul>
    <form action="index.php?c=wechar&a=api" method="post" class="form-search">
        <input name="config_id" type="hidden" value="<?php echo $info['config_id'];?>">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td align="right" width="20%"><strong>微信URL：</strong></td>
                    <td>
                        <?php echo $site_info['siteurl'];?>index.php?c=wechar
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>微信TOKEN：</strong></td>
                    <td>
                        <input type="text" name="token" value="<?php echo $info['token'];?>" placeholder="一般情况下不要修改.修改后记得要更新微信公众号后台开发者中心"/>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>EncodingAESKey：</strong></td>
                    <td>
                        <input type="text" name="aeskey" value="<?php echo $info['aeskey'];?>" placeholder="在开发模式中点随机生成.然后复制到这边"/>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>APPID：</strong></td>
                    <td>
                        <input type="text" name="appid" id="appid" value="<?php echo $info['appid'];?>" placeholder="必填" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>AppSecret：</strong></td>
                    <td>
                        <input type="text" name="appsecret" id="appsecret" value="<?php echo $info['appsecret'];?>" placeholder="必填" />
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