<?php
/**********************************
*   数据库访问类
* @file         /class/iPdo.class.php
* @package
* @author       xhg
* @version      1.0.0 (2010-04-08)
* @link
**********************************/

!defined('IN_FW') && exit('Access Denied');

abstract class Db{
    public $mQueryCount = 0;
    public $mConn;
    public $mResult;
    public $mRsType = PDO::FETCH_ASSOC;
    
    
    /**
     * 连接数据库
     *
     * @param string $dbHost
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPass
     * @param blooean $dbOpenType
     * @param string $dbCharset
     * @return void
     */
    abstract static public function connect();

    /**
     * 关闭数据库连接
     *
     * @return blooean
     */
    public function close(){
        $this->mConn = null;
        return ;
    }

    /**
     * 发送查询语句
     *
     * @param string $sql
     * @param string $type ['ASSOC' | 'NUM' | 'BOTH']
     * @return blooean
     */
    public function query($sql, $type = "ASSOC") {
        $this->mRsType = $type != "ASSOC" ? ($type == "NUM" ? PDO::FETCH_NUM : PDO::FETCH_BOTH) : PDO::FETCH_ASSOC;
        $this->mResult = $this->mConn->query($sql);
        $this->mQueryCount++;

        if (!$this->mResult)
        {
            return $this->errorMsg('Db Query Error', $sql);
        }
        else
        {
            return $this->mResult;
        }
    }

    /**
     * 数据量比较大的情况下查询
     *
     * @param string $sql
     * @param string $type ['ASSOC' | 'NUM' | 'BOTH']
     * @return blooean
     */
    public function bigQuery($sql, $type = "ASSOC") {
        $this->mConn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $this->mRsType = $type != "ASSOC" ? ($type == "NUM" ? PDO::FETCH_NUM : PDO::FETCH_BOTH) : PDO::FETCH_ASSOC;
        $this->mResult = $this->mConn->query($sql);
        $this->mQueryCount++;
        if (!$this->mResult)
        {
            return $this->errorMsg('Db Query Error', $sql);
        }
        else
        {
            return $this->mResult;
        }
    }
    /**
     * 执行数据库查询
     *
     * @param string $sql
     * @return int
     */
    public function exec($sql){
        $this->affectedRows = $this->mConn->exec($sql);
        return $this->affectedRows;
    }
    /**
     * 获取全部数据
     *
     * @param string $sql
     * @param blooean $nocache
     * @return array
     */
    public function getAll($sql, $noCache = false) {
        $noCache ? $this->bigQuery($sql) : $this->query($sql);
        $rows = array();
        while ($row = $this->mResult->fetch($this->mRsType)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * 获取单行数据
     *
     * @param string $sql
     * @return array
     */
    public function getOne($sql) {
        $this->query($sql);
        $rows = array();
        $rows = $this->mResult->fetch($this->mRsType);
        return $rows;
    }

    /**
     * 从结果集中取得一行作为关联数组，或数字数组
     *
     * @param resource $query
     * @return array
     */
    public function fetchArray() {
        return $this->mResult->fetch($this->mRsType);
    }

    public function result($row) {
        $query = $this->mResult->fetchColumn($row);
        return $query;
    }
    /**
     * 取得上一步 INSERT 操作产生的 ID
     *
     * @return integer
     */

    public function insertId() {
        return ($id = $this->mConn->lastInsertId ()) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
    }

    /**
     * 取得行的数目
     *
     * @param resource $query
     * @return integer
     */
    public function numRows() {
        return $this->mResult->rowCount();
    }

    /**
     * 取得结果集中字段的数目
     *
     * @param resource $query
     * @return integer
     */
    public function numFields() {
        return $this->mResult->columnCount();
    }

    /**
     * 取得前一次 MySQL 操作所影响的记录行数
     *
     *
     * @return integer
     */
    public function affectedRows() {
        return $this->affectedRows;
    }

    /**
     * 取得结果中指定字段的字段名
     *
     * @param string $data
     * @param string $table
     * @return array
     */
    public function listFields($table){
        $select = $this->query('SELECT * FROM '.$table . ' limit 1');
        var_dump($select);
        $total_column = $this->numFields($select);
        for ($counter = 0; $counter <= $total_column; $counter ++) {
            $meta = $select->getColumnMeta($counter);
            var_dump($meta);
            $column[] = $meta['name'];
        }
        return $column;
    }

    /**
     * 列出数据库中的表
     *
     * @param string $data
     * @return array
     */
    public function listTables() {
        $sql    = 'SHOW TABLES ';
        $result = $this->getAll($sql);
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }

    /**
     * 输出错误信息
     *
     * @param string $msg
     * @param string $sql
     * @return void
     */
    public function errorMsg($msg = '', $sql = '', $trace = true) {
        if (IS_DEBUG) {
            if ($msg) {
                echo "<b>ErrorMsg</b>:".$msg."<br />";
            }
            if ($sql) {
                echo "<b>SQL</b>:".htmlspecialchars($sql)."<br />";
            }
            if($trace){
                $error = $this->mConn->errorInfo();
                echo "<b>Error</b>:  " .htmlspecialchars($error[2])."<br />";
                echo "<b>Errno</b>: ".$error[1];
            }
        } else {
            header('HTTP/1.1 404 Not Found');
            header('Status:404 Not Found');
            exit;
        }
        exit();
    }
}
/**********************************

**********************************/
?>