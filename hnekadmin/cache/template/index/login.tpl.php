<?php if (!defined('IN_FW')) exit('Access Denied');?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>E营销管理系统</title>
<link href="<?php echo __PUBLIC__;?>style/index.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="bjj">
    <div class="top"></div>
    <div class="t_2"></div>
    <div class="t_3">
        <div class="t_4 left"></div>
        <div class="t_5 left"></div>
        <div class="t_6 left login">
           <form action="" method="post" name="myform">
            <ul>
                <li>用户名：<input name="username" type="text"/></li>
                <li>密　码：<input name="password" type="password"></li>
                <li>
                    验证码：<input name="checkcode" type="text"  style=" width:89px;"/>
                    <em>
                        <a href="javascript:document.getElementById('code_img').src='./index.php?c=common&a=checkcode&time='+Math.random();void(0);">
                            <img id="code_img" src="./index.php?c=common&a=checkcode" style="height: 27px; border:0px none; vertical-align: top; width: 70px;" />
                        </a>
                    </em>
                </li>
                <li><input name="dosubmit" type="submit" value="" /></li>
            </ul>
            </form>
            <span>请输入您的用户名和密码</span>
        </div>
        <div class="t_7 left"></div>
    </div>
    <div class="clearit"></div>
</div>
</body>
</html>