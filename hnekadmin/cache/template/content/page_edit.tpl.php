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
    <link rel="stylesheet" href="<?php echo __PUBLIC__;?>kindeditor/themes/default/default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/bootstrap_min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/css.css" media="all" />
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/jquery.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>kindeditor/kindeditor-all-min.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript">
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name="content"]', {
                uploadJson:'index.php?c=Common&a=editor',
                allowFileManager : true,
                fileManagerJson: "index.php?c=Common&a=manager",
                urlType : '',
                formatUploadUrl:false,
                loadStyleMode : false,
                afterCreate : function(){
                    this.html('<?php echo @str_replace(array(chr(13),chr(10)),'',addcslashes($info['content'],'\''));?>');
                }
            });
        });
    </script>
    <script type="text/javascript">
        var editor_wap;
        KindEditor.ready(function(K) {
            editor_wap = K.create('textarea[name="wap_content"]', {
                uploadJson:'index.php?c=Common&a=editor',
                allowFileManager : true,
                fileManagerJson: "index.php?c=Common&a=manager",
                urlType : '',
                formatUploadUrl:false,
                loadStyleMode : false,
                afterCreate : function(){
                    this.html('<?php echo @str_replace(array(chr(13),chr(10)),'',addcslashes($info['wap_content'],'\''));?>');
                }
            });
        });
    </script>
    <title>E营销管理系统</title>
</head>
<body>
    <ul class="breadcrumb">
        <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">内容管理</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active"><?php echo $category['name'];?></li>
    </ul>
    <form action="index.php?c=Content&a=page_edit" method="post" class="form-search">
        <input name="category_id" type="hidden" value="<?php echo $category['category_id'];?>">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td align="right"><strong>标题：</strong></td>
                    <td>
                        <input type="text" name="title" class="ipt" size="45" value="<?php echo @iHtmlSpecialChars($info['title']);?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>关键字：</strong></td>
                    <td>
                        <textarea name="keywords" placeholder="关键字中间用半角逗号隔开"><?php echo @iHtmlSpecialChars($info['keywords']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>描述：</strong></td>
                    <td>
                        <textarea name="description" placeholder="针对搜索引擎设置的网页描述"><?php echo @iHtmlSpecialChars($info['description']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>内容：</strong></td>
                    <td>
                        <textarea name="content" style="width:800px;height:500px;" class="editor"><?php echo @iStripslashes($info['content']);?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>移动端内容：</strong></td>
                    <td>
                        <textarea name="wap_content" style="width:360px;height:500px;" class="editor"><?php echo @iStripslashes($info['wap_content']);?></textarea>
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