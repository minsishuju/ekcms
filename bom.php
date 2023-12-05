<?php
$basedir = '.';
$file_list = array(
	'./bom.php',
	'./core/class/Controller.class.php',
	'./core/class/Db.class.php',
	'./core/class/Framework.class.php',
	'./core/class/Http.class.php',
	'./core/class/Image.class.php',
	'./core/class/Model.class.php',
	'./core/class/Mysql.class.php',
	'./core/class/Page.class.php',
	'./core/class/PHPMailer.class.php',
	'./core/class/Session.class.php',
	'./core/class/SMTP.class.php',
	'./core/class/SplitWord.class.php',
	'./core/class/Sqlite.class.php',
	'./core/class/Template.class.php',
	'./core/class/Upload.class.php',
	'./core/common/config.php',
	'./core/framework.php',
	'./core/functions/function.php',
    './core/common/safeguard.php',
	'./hnekadmin/class/Collection.class.php',
	'./hnekadmin/common/config.php',
	'./hnekadmin/common/function.php',
	'./hnekadmin/controller/CollectionController.class.php',
	'./hnekadmin/controller/CommonController.class.php',
	'./hnekadmin/controller/ContentController.class.php',
	'./hnekadmin/controller/IndexController.class.php',
	'./hnekadmin/controller/MemberController.class.php',
	'./hnekadmin/controller/OtherController.class.php',
	'./hnekadmin/controller/ShopController.class.php',
	'./hnekadmin/controller/WecharController.class.php',
	'./hnekadmin/controller/RecommendedController.class.php',
	'./hnekadmin/controller/SmsController.class.php',
	'./hnekadmin/index.php',
    './hnekadmin/common/ueditor.config.php',
    './hnekadmin/common/Uploader.class.php',
    './hnekadmin/controller/EditorController.class.php',
	'./home/class/Alipay.class.php',
	'./home/class/Bbs.class.php',
	'./home/class/Content.class.php',
	'./home/class/ContentTemplate.class.php',
	'./home/class/ControllerContent.class.php',
	'./home/class/Guestbook.class.php',
	'./home/class/Wx_js_api_pay.class.php',
	'./home/common/config.php',
	'./home/common/function.php',
	'./home/controller/AjaxmapController.class.php',
	'./home/controller/BbsController.class.php',
	'./home/controller/GuestbookController.class.php',
	'./home/controller/IndexController.class.php',
	'./home/controller/MemberController.class.php',
	'./home/controller/ShopController.class.php',
	'./home/controller/TalentController.class.php',
	'./home/controller/WecharController.class.php',
    './home/controller/SqlController.class.php',
	'./index.php',
	'./language/zh-cn/list_template.php',
);
function checkdir($basedir,$file_list){
	if ($dh = opendir($basedir)) {
		while (($file = readdir($dh)) !== false) {
			if ($file != '.' && $file != '..'){
				if (!is_dir($basedir."/".$file)){
					if(substr($file,-4) == '.php' && !in_array($basedir."/".$file,$file_list)){
					    if(!strstr($file,'.tpl.php')){
					        echo "'$basedir/$file', <br>";
					    }

						//unlink($basedir."/".$file);
					}
				}else{
					$dirname = $basedir."/".$file;
					checkdir($dirname,$file_list);
				}
			}
		}
		closedir($dh);
	}
}
checkdir($basedir,$file_list);
