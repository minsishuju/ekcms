<?php if (!defined('IN_FW')) exit('Access Denied');?>
<!doctype html>
<html style="height:90%;">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<link rel="shortcut icon" href="favicon.ico" />
<title>页面预览--E营销管理系统</title>
</head>
<body style="height:100%;margin:0px;">
    <div style="width:640px;margin:20px auto;height:100%">
    <iframe frameborder="0" src="index.php?c=index&a=phone_preview&url=<?php echo @urlencode($url);?>" width="100%" height="100%"></iframe>
    </div>
</body>
</html>