<?php
/**********************************
*   内容类
* @file            /class/Content.class.php
* @package
* @author       xhg
* @version       1.0.2
* @date         2012-03-01 10:28:48
* @link
**********************************/
class Guestbook {
    public static function parse(){
        $args = func_get_args();
        $args = stripslashes($args[0]);
        preg_match_all('/[a-zA-Z_]\w+=".*?"/is',$args,$arr);
        $arr = $arr[0];
        $arr = array_map('trim',$arr);
        foreach($arr as $k=>$v){
            $pos = strpos($v, "=");
            $name = substr($v, 0, $pos);
            $data[$name] = substr($v, $pos+2,-1);
        }
        return self::$data['action']($data);
    }
    public static function index($data){
        $db = Mysql::connect();
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'guestbook where 1=1 and is_show = 1 ';
        if(isset($data['order'])){
            $sql .= ' order by ' . $data['order'];
        }else{
            $sql .= ' order by add_time DESC,guestbook_id DESC ';
        }
        $data['num'] = intval($data['num']) ? intval($data['num']) : 25;
        if(isset($data['page'])){
            $page_sql = 'select count(1) as count_num from ' . config('DB_TABLE_PRE') . 'guestbook where 1=1  and is_show = 1 ';
            $info = $db->getOne($page_sql);
            $Page  = new Page($info['count_num'],$data['num']);
            $sql .= ' limit '. $Page->firstRow .',' . intval($data['num']);
        }else{
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        return $info;
    }
    public static function page(){
        $args = func_get_args();
        $args = stripslashes($args[0]);
        preg_match_all('/[a-zA-Z_]\w+=".*?"/is',$args,$arr);
        $arr = $arr[0];
        $arr = array_map('trim',$arr);
        foreach($arr as $k=>$v){
            $pos = strpos($v, "=");
            $name = substr($v, 0, $pos);
            $data[$name] = substr($v, $pos+2,-1);
        }
        if($data['action'] != 'index') return false;
        $db = Mysql::connect();
        $sql = 'select count(1) as count_num from ' . config('DB_TABLE_PRE') . 'guestbook where 1=1 and is_show = 1 ';
        $data['num'] = intval($data['num']) ? intval($data['num']) : 25;
        $info = $db->getOne($sql);
        $Page  = new Page($info['count_num'],$data['num']);
        $show  = $Page->show();
        $show = preg_replace_callback("/index\.php\?a=page&othername=([\w]+)&page=([0-9]+)(.*?)/is", array(self,'url_rule'), $show);
        return $show;
    }
    public static function url_rule($matches){
        $url .= $matches[1] . '.html';
        if($matches[3]){
            $url .= '?' . sutstr($matches[3],1);
            $url .= '&page=' . $matches[2];
        }else{
            $url .= '?page=' . $matches[2];
        }
        return $url;
    }
}
/**********************************
*
**********************************/