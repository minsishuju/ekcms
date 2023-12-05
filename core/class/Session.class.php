<?php
/**********************************
*      会话管理库
* @file          /class/session.class.php
* @package       
* @author        xhg
* @version       1.0.0
* @date          2016-02-22
* @link
**********************************/
/**
 * 会话管理
 */
class session
{ 
    //类的实例
    static $m_Instacne;
    
    //生存时间 
    private $lifeTime; 
    
    // mysql-handle 
    private $dbHandle; 
    
    private $dbUser = '';
    private $dbHost = '';
    private $dbPort = '';
    private $dbPass = '';
    private $dbData = '';
    private $dbCharset = '';
    private $dbType = '';
    /**
     * 构造
     */
    private function __construct() {
        return ;
    }

    /**
     * 不能复制对象
     */
    private function __clone() {
        return ;
    }
    
    /**
     * 开始建立一个新的会话
     */
    static public function start() {
        if (!(self::$m_Instacne instanceof self)) {
            self::$m_Instacne = new self();
        }
        /*
        session_set_save_handler(
            array(&self::$m_Instacne, "open"), 
            array(&self::$m_Instacne, "close"), 
            array(&self::$m_Instacne, "read"), 
            array(&self::$m_Instacne, "write"), 
            array(&self::$m_Instacne, "destroy"), 
            array(&self::$m_Instacne, "gc")
        ); 
        */
        session_start();
        return self::$m_Instacne;
    }
    
    /**
     * 打开一个会话
     * @param string $savePath
     * @param string $sessName
     */
    public function open($savePath, $sessName) { 
        //取得会话的生存时间
        $this -> lifeTime = get_cfg_var("session.gc_maxlifetime"); 
        //连接数据库
        $this -> dbHandle = Mysql::connect();
        if(!$this -> dbHandle) { 
            return false; 
        }
        return true; 
    }
    
    /**
     * 关闭已存在的会话
     */
    public function close() {
        $this -> gc(ini_get('session.gc_maxlifetime')); 
        return $this-> dbHandle -> close(); 
    } 
    
    /**
     * 读会话的信息
     * @param string $sessID
     */
    public function read($sessID) { 
        //从数据库中取得数据
        $row = $this -> dbHandle -> getOne("SELECT session_data AS d FROM ".config('DB_TABLE_PRE')."sessions WHERE session_id = '$sessID' AND session_expires > ".time()); 
        if($row) { 
            return $row['d'];
        }
        //如果出错了需要返回"" 
        return ""; 
    } 
    
    /**
     * 写会话数据
     * @param $sessID
     * @param $sessData
     */
    public function write($sessID, $sessData) { 
        //累加新的会话超时时间 
        $newExp = time() + $this -> lifeTime; 
        //会话是否存在 
        $this -> dbHandle -> query("SELECT * FROM ".config('DB_TABLE_PRE')."sessions WHERE session_id = '$sessID'");
        $res = $this -> dbHandle ->numRows(); 
        //已存在会话数据 
        if($res) { 
            if($this -> dbHandle ->exec("UPDATE ".config('DB_TABLE_PRE')."sessions SET session_expires = '$newExp', session_data = '$sessData' WHERE session_id = '$sessID'")) { 
                return true;
            } 
        } else { 
            if($this -> dbHandle ->exec("INSERT INTO ".config('DB_TABLE_PRE')."sessions ( session_id, session_expires, session_data) VALUES( '$sessID', '$newExp', '$sessData')")) { 
                return true;
            } 
        }
        return false; 
    }
    
    /**
     * 注册会话
     * @param string $sessID
     */
    public function destroy($sessID) { 
        if($this -> dbHandle ->exec("DELETE FROM ".config('DB_TABLE_PRE')."sessions WHERE session_id = '$sessID'")) { 
            return true;
        } 
        return false; 
    } 
    
    /**
     * 垃圾回收
     * @param int $sessMaxLifeTime
     */
    public function gc($sessMaxLifeTime) { 
        return $this -> dbHandle ->exec("DELETE FROM ".config('DB_TABLE_PRE')."sessions WHERE session_expires < ".time());
    } 
} 
?>