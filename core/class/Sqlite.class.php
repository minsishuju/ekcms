<?php
/**********************************
*   sqlite数据库访问类
* @file         /class/Sqlite.class.php
* @package
* @author       xhg
* @version      1.0.0 (2010-04-08)
* @link
**********************************/

!defined('IN_FW') && exit('Access Denied');

class Sqlite extends Db {
    static $_instance = null;
    private function __construct(){
        
    }
    static public function connect($databaseFile = '') {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        if(file_exists($databaseFile)) {
            self::$_instance->mConn = new PDO('sqlite:'.$databaseFile);
        } else {
            self::$_instance->errorMsg('Can not Connect to db server','',false);
        }
        return self::$_instance;
    }
}
/**********************************

**********************************/
?>