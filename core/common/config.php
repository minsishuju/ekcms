<?php
/**********************************
*      配置文件
* @file          config.php
* @package       config
* @author        xhg
* @version       1.0.0
* @date          2016-02-22
* @link
**********************************/
$config = array(
    'UPLOAD_ALLOW_SIZE'  => 300000,             //允许上传的最大文件，单位字节
    'UPLOAD_ALLOW_EXT'   => array(
                        'image/gif',
                        'image/pjpeg',
                        'image/jpg',
                        'image/jpeg',
                        'image/png',
                        'image/swf',
                        'application/x-shockwave-flash'
                    ),                          //允许上传的文件类型
    'CHARSET'            => 'UTF-8',                //页面编码
    'DB_TYPE'            => 'mysql',                //数据库类型
    'DB_HOST'            => '127.0.0.1',            //数据库的主机地址，通常为localhost
    'DB_PORT'            => '3306',             //数据库的主机地址端口，通常为3306
    'DB_NAME'            => 'old_taoguapi_com',             //系统使用的数据库的数据库名
    'DB_USER'            => 'old_taoguapi_com',             //数据库的用户名
    'DB_PASSWD'          => 'zYxD6eidCNAEfkX6',          //数据库的用户名对应的密码
    'DB_TABLE_PRE'       => 'cmsx_',                //数据库表前缀
    'DB_CHARSET'         => 'utf8',             //数据库数据库字符集，推荐为 utf8
    'DB_PCONNECT'        => false,              //是否为持续链接
    'DEFAULT_ACTION'     => 'index',                //默认访问模块
    'DEFAULT_CONTROLLER' => 'Index',                //默认控制器
    'DEFAULT_TEMPLATE'   => 'default',              //默认模板
    'VAR_PAGE'           => 'page',             //默认分页变量
	'KEY'           	 => 'vhWs2RneKMCuPchh', //网站秘钥
);

/**********************************

**********************************/