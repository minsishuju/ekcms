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
<title>内容管理--E营销管理系统</title>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/bootstrap_min.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/bootstrap-responsive.min.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/style.css" media="all" />
<script src="<?php echo __PUBLIC__;?>js/jquery.js" type="text/javascript"></script>
<script src="<?php echo __PUBLIC__;?>js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php include $this->template("public/header"); ?>
    <div class="row-fluid">
        <?php include $this->template("content/left"); ?>
        <div class="right">
            <div class="main">
                <iframe frameborder="0" id="mainFrame" name="mainFrame" src="index.php?c=content&a=counts" style="background: url('<?php echo __PUBLIC__;?>images/loading.gif') center no-repeat"></iframe>
            </div>
        </div>
    </div>
</body>
</html>