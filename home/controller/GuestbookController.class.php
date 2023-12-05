<?php
class GuestbookController extends ControllerContent {
    private $db;
    public function __construct(){
        parent::__construct();
        $this->db = Mysql::connect();
    }
    
    public function add(){
        if(IS_POST){
            $data = array();
            $data['name']       = escapeString(getGpc('name','string','P'));
            $data['sex']        = getGpc('sex','integer','P');
            $data['qq']         = escapeString(getGpc('qq','string','P'));
            $data['tel']        = escapeString(getGpc('tel','string','P'));
            $data['email']      = escapeString(getGpc('email','string','P'));
            $data['address']    = escapeString(getGpc('address','string','P'));
            $data['introduce']  = escapeString(getGpc('introduce','string','P'));
            $data['title']      = escapeString(getGpc('title','string','P'));
            $data['url']        = REQUEST_URI;
            $data['add_time']   = time();
            $sql = insertTable(config('DB_TABLE_PRE').'guestbook',$data);
            if($this->db->exec($sql)){
                message('我们已收到你的留言，稍后会有客服与你联系',$_SERVER['HTTP_REFERER'],3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            message('非法操作',config('SITE_INFO.siteurl'),3);
        }
    }
}
?>