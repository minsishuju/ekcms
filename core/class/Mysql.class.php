<?php
/**********************************
*   mysql数据库访问类
* @file         /class/Mysql.class.php
* @package
* @author       xhg
* @version      1.0.0 (2010-04-08)
* @link
**********************************/

!defined('IN_FW') && exit('Access Denied');

class Mysql extends Db {
    static $_instance = null;
    private function __construct(){
        
    }
    /**
     * 连接数据库
     *
     * @return void
     */
    static public function connect(){
        
        $dbHost = config('DB_HOST');
        $dbPort = config('DB_PORT');
        $dbUser = config('DB_USER');
        $dbPass = config('DB_PASSWD');
        $dbName = config('DB_NAME');
        $dbOpenType = config('DB_PCONNECT');
        $dbCharset = config('DB_CHARSET');
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        if ($dbOpenType){
            self::$_instance->mConn = new PDO(
                "mysql:host=".$dbHost.";port=". $dbPort .";dbname=". $dbName . ';charset='.$dbCharset, 
                $dbUser, 
                $dbPass,
                array(
                    PDO::ATTR_PERSISTENT => true,
                )
            );
            if (!self::$_instance->mConn) { 
                self::$_instance->errorMsg('Can not Connect to MySQL server');
            }
        } else {
            self::$_instance->mConn = new PDO(
                "mysql:host=".$dbHost.";port=". $dbPort .";dbname=". $dbName . ';charset='.$dbCharset, 
                $dbUser, 
                $dbPass
            );
            if (!self::$_instance->mConn) {
                $this->errorMsg('Can not Connect to MySQL server');
            }
        }
        self::$_instance->exec('set names '.$dbCharset.';');
        return self::$_instance;
    }
}
/**********************************

**********************************/
?>