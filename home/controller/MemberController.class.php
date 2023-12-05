<?php
class MemberController extends ControllerContent {
    public function __construct(){
        parent::__construct();
        if(!preg_match('/^\/\w+$/',$_SERVER['REQUEST_URI'])){
            $url_str = substr($_SERVER['REQUEST_URI'],1,strpos(substr($_SERVER['REQUEST_URI'],1),'/'));
            $url_str = $url_str == 'news' || $url_str == 'product' ? '' : $url_str;
        }else{
            $url_str = substr($_SERVER['REQUEST_URI'],1);
        }
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        if(!empty($url_str) &&!is_dir($url_str)){
            $url .= $url_str . '/';
        }
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where siteurl = "' . $url . '"');
        if($info && $info['status'] == 1){
            config('__DB__',SITE_PATH . 'data/' . $info['site_dir'] . 'db');
            config('SITE_INFO',$info);
            defined('__PUBLIC__') or define('__PUBLIC__', HTTP_HOST . '/' . 'data/' . config('SITE_INFO.site_dir').'static/');
            $CATEGORYS = Content::get_category_cache();
            $this->assign('CATEGORYS',$CATEGORYS);
        }else{
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where status = 1');
            if($info ){
                config('__DB__',SITE_PATH . 'data/' . $info['site_dir'] . 'db');
                config('SITE_INFO',$info);
                defined('__PUBLIC__') or define('__PUBLIC__', HTTP_HOST . '/' . 'data/' . config('SITE_INFO.site_dir').'static/');
                $CATEGORYS = Content::get_category_cache();
                $this->assign('CATEGORYS',$CATEGORYS);
            }else{
                header("HTTP/1.1 404 Not Found");
                die;
            }
        }
        $city_id = trim(getGpc('city_id','string','G'));
        if($city_id != ''){
            $Sqlite_db = Sqlite::connect(config('__DB__'));
            $city = $Sqlite_db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $city_id . '"');
            $this->assign('city',$city['name']);
        }
    }
    
    public function index(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $SEO = seo('','个人中心');
        $this->assign('SEO',$SEO);
        $db = Mysql::connect();
        $member_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $_SESSION['member_id']);
        $this->assign('member_info',$member_info);
        $this->display();
    }
    
    public function info(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        if(IS_POST){
            $name = getGpc('name','string','P');
            $email = getGpc('email','string','P');
            $phone = getGpc('phone','string','P');
            $db = Mysql::connect();
            $data = array();
            $data['name'] = $name;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $sql = updateTable(config('DB_TABLE_PRE').'member',$data,array('member_id'=>$_SESSION['member_id']));
            if($db->exec($sql)) {
                message('修改成功','index.php?c=member&a=index',3);
            } else {
                message('修改失败','index.php?c=member&a=info',3);
            }
        }else{
            $SEO = seo('','修改个人信息');
            $this->assign('SEO',$SEO);
            $db = Mysql::connect();
            $member_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $_SESSION['member_id']);
            $this->assign('member_info',$member_info);
            $this->display();
        }
    }
    
    public function password(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        if(IS_POST){
            $password = getGpc('password','string','P');
            $new_password = getGpc('new_password','string','P');
            $rep_password = getGpc('rep_password','string','P');
            if($password == ''){
                message('请输入旧密码','index.php?c=member&a=password',3);
            }
            if($new_password == ''){
                message('请输入新密码','index.php?c=member&a=password',3);
            }
            if($rep_password != $new_password){
                message('两次输入密码不一致','index.php?c=member&a=password',3);
            }
            $db = Mysql::connect();
            $info = $db->getOne('select member_id,safe_code,password from '.config('DB_TABLE_PRE').'member where member_id = ' . $_SESSION['member_id']);
            if(md5(md5($password) . $info['safe_code']) == $info['password']){
                $data = array();
                $data['safe_code'] = substr(md5(time()),12,8);
                $data['password'] = md5(md5($new_password) . $data['safe_code']);
                $sql = updateTable(config('DB_TABLE_PRE').'member',$data,array('member_id'=>$info['member_id']));
                if($db->exec($sql)) {
                    $_SESSION['member_id'] = '';
                    message('修改成功','index.php?c=member&a=login',3);
                } else {
                    message('修改失败','index.php?c=member&a=password',3);
                }
            } else {
                message('旧密码错误','index.php?c=member&a=password',3);
            }
        }else{
            $SEO = seo('','修改密码');
            $this->assign('SEO',$SEO);
            $db = Mysql::connect();
            $member_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $_SESSION['member_id']);
            $this->assign('member_info',$member_info);
            $this->display();
        }
    }
    
    public function login(){
        if(isset($_SESSION['member_id']) && $_SESSION['member_id'] != null ){
            message('','index.php?c=member&a=index',0);
        }
        if(IS_POST){
            $username = getGpc('username','string','P');
            $password = getGpc('password','string','P');
            if($username == ''){
                message('请输入用户名','index.php?c=member&a=login',3);
            }
            if($password == ''){
                message('请输入密码','index.php?c=member&a=login',3);
            }
            $db = Mysql::connect();
            $info = $db->getOne('select member_id,safe_code,password,status from '.config('DB_TABLE_PRE').'member where username = "' . $username . '"');
            if($info){
                if($info['status'] == 0){
                    message('该账号已被禁用','index.php?c=member&a=login',3);
                }
                if(md5(md5($password) . $info['safe_code']) == $info['password']){
                    $_SESSION['member_id'] = $info['member_id'];
                    message('登陆成功','index.php?c=member&a=index',3);
                } else {
                    message('密码错误','index.php?c=member&a=login',3);
                }
            } else {
                message('用户不存在','index.php?c=member&a=login',3);
            }
        }else{
            $SEO = seo('','登录');
            $this->assign('SEO',$SEO);
            $this->display();
        }
    }
    
    public function register(){
        if(isset($_SESSION['member_id']) && $_SESSION['member_id'] != null ){
            message('','index.php?c=member&a=index',0);
        }
        if(IS_POST){
            $username = getGpc('username','string','P');
            $password = getGpc('password','string','P');
            $rep_password = getGpc('rep_password','string','P');
            if($username == ''){
                message('请输入用户名','index.php?c=member&a=register',3);
            }
            if($password == ''){
                message('请输入密码','index.php?c=member&a=register',3);
            }
            if($rep_password != $password){
                message('两次输入密码不一致','index.php?c=member&a=register',3);
            }
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'member where username = "' . $username . '"');
            if($info){
                message('用户名已存在','index.php?c=member&a=register',3);
            }
            $data = array();
            $data['username'] = $username;
            $data['status'] = 1;
            $data['add_time'] = time();
            $data['safe_code'] = substr(md5(time()),12,8);
            $data['password'] = md5(md5($password) . $data['safe_code']);
            $sql = insertTable(config('DB_TABLE_PRE').'member',$data);
            if($db->exec($sql)) {
                $member_id = $db->insertId();
                $_SESSION['member_id'] = $member_id;
                message('','index.php?c=member&a=index',0);
            } else {
                message('注册失败','index.php?c=member&a=register',3);
            }
        }else{
            $SEO = seo('','注册');
            $this->assign('SEO',$SEO);
            $this->display();
        }
    }
    
    public function logout(){
        $_SESSION['member_id'] = '';
        message('','index.php?c=member&a=login',0);
    }
    
    public function point(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $db = Mysql::connect();
        $count_num = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'member_point_log where member_id = ' . $_SESSION['member_id']);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'member_point_log where member_id = ' . $_SESSION['member_id'] . ' order by add_time desc,log_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $SEO = seo('','积分查询');
        $this->assign('SEO',$SEO);
        $this->display();
    }
    
    public function orders(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $db = Mysql::connect();
        $count_num = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'orders where member_id = ' . $_SESSION['member_id']);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'orders where member_id = ' . $_SESSION['member_id'] . ' order by add_time desc,orders_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $SEO = seo('','订单管理');
        $this->assign('SEO',$SEO);
        $this->display();
    }
    
    public function order_detail(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $orders_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $orders = $db->getOne('select * from '.config('DB_TABLE_PRE').'orders where orders_id = ' . $orders_id . ' and member_id = ' . $_SESSION['member_id']);
        $order_goods = $db->getAll('select * from '.config('DB_TABLE_PRE').'orders_goods where orders_id = ' . $orders_id);
        switch($orders['payment_id']){
            case 'alipay' :
                $alipay = new Alipay;
                $pay_code = $alipay->get_pay_code($orders);
                break;
            case 'weixinpay' :
                $weixinpay = new weixinpay;
                $pay_code = $weixinpay->get_pay_code($orders);
                break;
        }
        $this->assign('order_goods',$order_goods);
        $this->assign('orders',$orders);
        $this->assign('pay_code',$pay_code);
        $SEO = seo('','订单详情');
        $this->assign('SEO',$SEO);
        $this->display();
    }
    
    public function cancel_order(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $orders_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $orders = $db->getOne('select * from '.config('DB_TABLE_PRE').'orders where orders_id = ' . $orders_id . ' and member_id = ' . $_SESSION['member_id']);
        if(!$orders){
            message('订单不存在','index.php?c=member&a=orders',3);
        }
        if($orders['status'] != 0){
            message('订单已付款','index.php?c=member&a=orders',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'orders where orders_id = ' . $orders_id . ' and member_id = ' . $_SESSION['member_id'];
        if($db->exec($sql)) {
            $db->exec('delete from ' . config('DB_TABLE_PRE').'orders_goods where orders_id = ' . $orders_id);
            message('操作成功','index.php?c=member&a=orders',3);
        } else {
            message('操作失败','index.php?c=member&a=orders',3);
        }
    }
    
    public function affirm_received(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $orders_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $orders = $db->getOne('select * from '.config('DB_TABLE_PRE').'orders where orders_id = ' . $orders_id . ' and member_id = ' . $_SESSION['member_id']);
        if(!$orders){
            message('订单不存在','index.php?c=member&a=orders',3);
        }
        if($orders['status'] == 0 ){
            message('订单尚未付款','index.php?c=member&a=orders',3);
        }
        if($orders['status'] == 3 ){
            message('订单已收货','index.php?c=member&a=orders',3);
        }
        $where = array('orders_id'=>$orders_id,'member_id'=>$_SESSION['member_id']);
        $sql = updateTable(config('DB_TABLE_PRE').'orders',array('status'=>3),$where);
        if($db->exec($sql)) {
            message('操作成功','index.php?c=member&a=orders',3);
        } else {
            message('操作失败','index.php?c=member&a=orders',3);
        }
    }
    
    public function address(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $db = Mysql::connect();
        $address = $db->getAll('select * from '.config('DB_TABLE_PRE').'member_address where member_id = ' . $_SESSION['member_id']);
        foreach($address as &$val){
            $val['city_list']     = $this->get_regions(2, $val['province']);
            $val['district_list'] = $this->get_regions(3, $val['city']);
        }
        $province_list = $this->get_regions(1);
        $this->assign('address',$address);
        $this->assign('province_list',$province_list);
        $SEO = seo('','收货地址');
        $this->assign('SEO',$SEO);
        $this->display();
    }
    
    public function add_address(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        if(IS_POST){
            $data = array();
            $data['username'] = getGpc('username','string','P');
            $data['province'] = getGpc('province','integer','P');
            $data['city'] = getGpc('city','integer','P');
            $data['district'] = getGpc('district','integer','P');
            $data['address'] = getGpc('address','string','P');
            $data['postcode'] = getGpc('postcode','string','P');
            $data['phone'] = getGpc('phone','string','P');
            $data['member_id'] = $_SESSION['member_id'];
            $sql = insertTable(config('DB_TABLE_PRE').'member_address',$data);
            $db = Mysql::connect();
            if($db->exec($sql)) {
                message('保存成功','index.php?c=member&a=address',3);
            } else {
                message('保存失败','index.php?c=member&a=address',3);
            }
        }else{
            message('','index.php?c=member&a=address',0);
        }
    }
    
    public function edit_address(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        if(IS_POST){
            $data = array();
            $address_id = getGpc('address_id','integer','P');
            $data['username'] = getGpc('username','string','P');
            $data['province'] = getGpc('province','integer','P');
            $data['city'] = getGpc('city','integer','P');
            $data['district'] = getGpc('district','integer','P');
            $data['address'] = getGpc('address','string','P');
            $data['postcode'] = getGpc('postcode','string','P');
            $data['phone'] = getGpc('phone','string','P');
            $data['member_id'] = $_SESSION['member_id'];
            $where = array('address_id'=>$address_id,'member_id'=>$_SESSION['member_id']);
            $sql = updateTable(config('DB_TABLE_PRE').'member_address',$data,$where);
            $db = Mysql::connect();
            if($db->exec($sql)) {
                message('保存成功','index.php?c=member&a=address',3);
            } else {
                message('保存失败','index.php?c=member&a=address',3);
            }
        }else{
            message('','index.php?c=member&a=address',0);
        }
    }
    
    public function delete_address(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $address_id = getGpc('id','integer','G');
        $sql = 'delete from '.config('DB_TABLE_PRE').'member_address where address_id = '. $address_id .' and member_id = ' . $_SESSION['member_id'];
        $db = Mysql::connect();
        if($db->exec($sql)) {
            message('操作成功','index.php?c=member&a=address',3);
        } else {
            message('操作失败','index.php?c=member&a=address',3);
        }
    }
    
    private function get_regions($type = 0, $parent = 0){
        $sql = 'select region_id, region_name FROM ' . config('DB_TABLE_PRE') .'region where region_type = ' .$type . ' and parent_id = '.$parent;
        $db = Mysql::connect();
        return $db->getAll($sql);
    }
}
?>