<?php
class ShopController extends ControllerContent {
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
            $CATEGORYS = Content::get_category_cache();
            $this->assign('CATEGORYS',$CATEGORYS);
        }else{
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where status = 1');
            if($info ){
                config('__DB__',SITE_PATH . 'data/' . $info['site_dir'] . 'db');
                config('SITE_INFO',$info);
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
        $category  = $db->getAll('select * from '.config('DB_TABLE_PRE').'shop_category order by listorder asc,category_id desc');
        $this->assign('category',$category);
        $config = $db->getAll('select * from '.config('DB_TABLE_PRE').'shop_config');
        foreach($config as $val){
            $val['config_value'] = unserialize($val['config_value']) ? unserialize($val['config_value']) : $val['config_value'];
            config($val['config_name'],$val['config_value']);
        }
    }
    
    public function index(){
        $this->lists();
    }
    
    public function lists(){
        $db = Mysql::connect();
        $category_id = getGpc('id','integer','G');
        $where = ' shelf = 1 ';
        if($category_id != 0){
            $where .= ' and category_id = ' . $category_id;
        }
        $count_num = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'goods where ' . $where);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'goods where ' . $where . ' order by listorder asc,goods_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $SEO = seo('','积分商城');
		$this->assign('SEO',$SEO);
        $pos_goods = $db->getAll('select * from '.config('DB_TABLE_PRE').'goods where shelf = 1 and is_pos = 1 limit 4');
        $this->assign('pos_goods',$pos_goods);
        $this->display('lists');
    }
    
    public function show(){
        $id = getGpc('id','integer','G');
        $sql = 'select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $id;
        $db = Mysql::connect();
        $info = $db->getOne($sql);
        if(!$info){
            message('商品已下架','index.php?c=shop&a=lists',3);
        }
        $info['goods_attr'] = unserialize($info['goods_attr']);
        if($info['shelf'] == 0){
            message('商品已下架','index.php?c=shop&a=lists',3);
        }
        $sql = 'select * from '.config('DB_TABLE_PRE').'goods_album where goods_id = ' . $id;
        $album = $db->getAll($sql);
        $SEO = seo('',$info['name'] . ' - 积分商城');
        
        $pos_goods = $db->getAll('select * from '.config('DB_TABLE_PRE').'goods where shelf = 1 and is_pos = 1 limit 4');
        $this->assign('pos_goods',$pos_goods);
        
        $package = $db->getAll('select p.* from '.config('DB_TABLE_PRE').'package_goods g left join '.config('DB_TABLE_PRE').'package p on p.package_id  = g.package_id where g.goods_id = ' . $info['goods_id'] . ' and p.shelf = 1');
        
        if($package){
            foreach($package as &$val){
                $val['goods'] = $db->getAll('select g.* from '.config('DB_TABLE_PRE').'package_goods p left join '.config('DB_TABLE_PRE').'goods g on p.goods_id  = g.goods_id where p.package_id = ' . $val['package_id']);
                $total_price = 0;
                foreach($val['goods'] as $k=>$v){
                    if($v['shelf'] == 0){
                        unset($val);
                        break;
                    }
                    $total_price += $v['price'];
                }
                $val['total_price'] = round($total_price,2);
                $val['pre_price'] = $total_price - $val['price'];
                $val['pre_price'] = round($val['pre_price'],2) > 0 ? round($val['pre_price'],2) : 0;
            }
            $this->assign('package',$package);
        }
        
		$this->assign('SEO',$SEO);
        $this->assign('album',$album);
        $this->assign('info',$info);
        $this->display();
    }
    
    public function get_price(){
        if(IS_POST){
            $goods_id = getGpc('goods_id','integer','P');
            $num = getGpc('num','integer','P');
            $sql = 'select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods_id;
            $db = Mysql::connect();
            $info = $db->getOne($sql);
            if(!$info){
                $this->ajaxReturn(array('status'=>0));
            }
            if($info['shelf'] == 0){
                $this->ajaxReturn(array('status'=>0));
            }
            $price = $info['price'];
            $info['goods_attr'] = unserialize($info['goods_attr']);
            foreach($info['goods_attr'] as $key=>$goods_attr){
                $attr_value = getGpc('attr'.$key,'integer','P');
                if(!$goods_attr['value'][$attr_value]){
                    $this->ajaxReturn(array('status'=>0));
                }else{
                    $price += $goods_attr['value'][$attr_value]['price'];
                }
            }
            $price *= $num;
            $this->ajaxReturn(array('status'=>1,'price'=>$price));
        }else{
            $this->ajaxReturn(array('status'=>0));
        }
    }
    
    public function add_cart(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('请先登录','index.php?c=member&a=login',3);
        }
        if(IS_POST){
            $goods_id = getGpc('goods_id','integer','P');
            $num = getGpc('num','integer','P');
            $sql = 'select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods_id;
            $db = Mysql::connect();
            $info = $db->getOne($sql);
            if(!$info){
                message('商品已下架','index.php?c=shop&a=lists',3);
            }
            if($info['shelf'] == 0){
                message('商品已下架','index.php?c=shop&a=lists',3);
            }
            $goods_attr_str = array();
            $info['goods_attr'] = unserialize($info['goods_attr']);
            foreach($info['goods_attr'] as $key=>$goods_attr){
                $attr_value = getGpc('attr'.$key,'integer','P');
                if(!$goods_attr['value'][$attr_value]){
                    message('请选择商品'.$goods_attr['name'],'index.php?c=shop&a=lists',3);
                }else{
                    $goods_attr_str[$key] = $attr_value;
                }
            }
            $data = array(
                'goods_id'=>$goods_id,
                'goods_num'=>$num,
                'goods_attr'=>serialize($goods_attr_str),
                'member_id'=>$_SESSION['member_id']
            );
            $sql = insertTable(config('DB_TABLE_PRE').'cart',$data);
            if($db->exec($sql)){
                message('','index.php?c=shop&a=cart',0);
            }else{
                message('操作失败，请联系网站管理员','index.php',3);
            }
        }else{
            message('','index.php?c=shop&a=cart',0);
        }
    }
    
    public function add_package_cart(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('请先登录','index.php?c=member&a=login',3);
        }
        $package_id = getGpc('id','integer','G');
        $sql = 'select * from '.config('DB_TABLE_PRE').'package where package_id = ' . $package_id;
        $db = Mysql::connect();
        $info = $db->getOne($sql);
        if(!$info){
            message('礼包已下架','index.php?c=shop&a=lists',3);
        }
        if($info['shelf'] == 0){
            message('礼包已下架','index.php?c=shop&a=lists',3);
        }
        
        $data = array(
            'goods_id'=>$package_id,
            'goods_num'=>1,
            'goods_attr'=>'',
            'goods_type'=>1,
            'member_id'=>$_SESSION['member_id']
        );
        $sql = insertTable(config('DB_TABLE_PRE').'cart',$data);
        if($db->exec($sql)){
            message('','index.php?c=shop&a=cart',0);
        }else{
            message('操作失败，请联系网站管理员','index.php',3);
        }
    }
    
    public function cart(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('请先登录','index.php?c=member&a=login',3);
        }
        $db = Mysql::connect();
        $cart_goods = $db->getAll('select * from '.config('DB_TABLE_PRE').'cart where member_id = ' . $_SESSION['member_id']);
        foreach($cart_goods as &$goods){
            if($goods['goods_type'] == 0){
                $goods_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods['goods_id']);
                $goods['goods_attr'] = unserialize($goods['goods_attr']);
                $goods_info['goods_attr'] = unserialize($goods_info['goods_attr']);
                $goods_attr_str = '';
                $goods['price'] = $goods_info['price'];
                foreach($goods['goods_attr'] as $key=>$goods_attr){
                    $goods['price'] += $goods_info['goods_attr'][$key]['value'][$goods_attr]['price'];
                    $goods_attr_str .= $goods_info['goods_attr'][$key]['name'] . '：'.$goods_info['goods_attr'][$key]['value'][$goods_attr]['name'] . '；<br />';
                }
                unset($goods_info['price']);
                $goods = array_merge($goods,$goods_info);
                $goods['goods_attr'] = $goods_attr_str;
            }else{
                $goods_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'package where package_id = ' . $goods['goods_id']);
                $package_goods = $db->getAll('select g.* from '.config('DB_TABLE_PRE').'package_goods p left join '.config('DB_TABLE_PRE').'goods g on p.goods_id  = g.goods_id where p.package_id = ' . $goods['goods_id']);
                $goods_attr_str = '';
                foreach($package_goods as &$val){
                    $goods_attr_str .= $val['name'] . '；<br />';
                    $val['goods_attr'] = unserialize($val['goods_attr']);
                    foreach($val['goods_attr'] as $goods_attr){
                        $val['attr'] .= $goods_attr['name'] . '：'.$goods_attr['value'][0]['name'] . '；<br />';
                    }
                }
                $goods_info['goods'] = $package_goods;
                $goods = array_merge($goods,$goods_info);
                $goods['goods_attr'] = $goods_attr_str;
            }
        }
        $this->assign('cart_goods',$cart_goods);
        $SEO = seo('','购物车 - 积分商城');
        $this->assign('SEO',$SEO);
        $this->display();
    }
    
    public function drop_goods(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        $cart_id = getGpc('id','integer','G');
        $sql = 'delete from '.config('DB_TABLE_PRE').'cart where cart_id = ' . $cart_id;
        $db = Mysql::connect();
        if($db->exec($sql)){
            message('操作成功','/index.php?c=shop&a=cart','3');
        }else{
            message('操作失败','/index.php?c=shop&a=cart','3');
        }
    }
    
    public function order_confirm(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        if(IS_POST){
            $cart_id = getGpc('items','array','P');
            $cart_ids = array_map('intval',$cart_id);
        }else{
            $cart_id = getGpc('id','intval','G');
            $cart_ids = array($cart_id);
        }
        if(empty($cart_ids)){
            message('请选择支付产品','index.php?c=shop&a=cart',3);
        }
        $cart_ids = implode(',',$cart_ids);
        $db = Mysql::connect();
        $cart_goods = $db->getAll('select * from '.config('DB_TABLE_PRE').'cart where cart_id in (' . $cart_ids .')');
        if(!$cart_goods){
            $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id in  (' . $cart_ids .')');
            message('商品已下架','/index.php?c=shop&a=cart',3);
        }
        $price = 0;
        foreach($cart_goods as &$goods){
            if($goods['goods_type'] == 0){
                $goods_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods['goods_id']);
                if($goods_info['shelf'] == 0){
                    $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id = ' . $cart_id);
                    unset($goods);
                    continue;
                }
                $goods['goods_attr'] = unserialize($goods['goods_attr']);
                $goods_info['goods_attr'] = unserialize($goods_info['goods_attr']);
                $goods_attr_str = '';
                $goods['price'] = $goods_info['price'];
                foreach($goods['goods_attr'] as $key=>$goods_attr){
                    $goods['price'] += $goods_info['goods_attr'][$key]['value'][$goods_attr]['price'];
                    $goods_attr_str .= $goods_info['goods_attr'][$key]['name'] . '：'.$goods_info['goods_attr'][$key]['value'][$goods_attr]['name'] . '；<br />';
                }
                unset($goods_info['price']);
                $goods = array_merge($goods,$goods_info);
                $goods['goods_attr'] = $goods_attr_str;
            }else{
                $goods_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'package where package_id = ' . $goods['goods_id']);
                if($goods_info['shelf'] == 0){
                    $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id = ' . $cart_id);
                    unset($goods);
                    continue;
                }
                $package_goods = $db->getAll('select g.* from '.config('DB_TABLE_PRE').'package_goods p left join '.config('DB_TABLE_PRE').'goods g on p.goods_id  = g.goods_id where p.package_id = ' . $goods['goods_id']);
                $goods_attr_str = '';
                foreach($package_goods as &$val){
                    $goods_attr_str .= $val['name'] . '；<br />';
                    $val['goods_attr'] = unserialize($val['goods_attr']);
                    foreach($val['goods_attr'] as $goods_attr){
                        $val['attr'] .= $goods_attr['name'] . '：'.$goods_attr['value'][0]['name'] . '；<br />';
                    }
                }
                $goods_info['goods'] = $package_goods;
                $goods = array_merge($goods,$goods_info);
                $goods['goods_attr'] = $goods_attr_str;
            }
            $goods['price'] *= $goods['goods_num'];
            $price += $goods['price'];
        }
        if(empty($cart_goods)){
            message('商品已下架','/index.php?c=shop&a=cart',3);
        }
        $this->assign('cart_goods',$cart_goods);
        $this->assign('price',$price);
    
        $address = $db->getAll('select a.*,r1.region_name as province_name,r2.region_name as city_name,r3.region_name as district_name from '.config('DB_TABLE_PRE').'member_address a left join '.config('DB_TABLE_PRE').'region r1 on a.province = r1.region_id left join '.config('DB_TABLE_PRE').'region r2 on a.city = r2.region_id left join '.config('DB_TABLE_PRE').'region r3 on a.district = r3.region_id where a.member_id = ' . $_SESSION['member_id']);
        $province_list = $this->get_regions(1);
        $this->assign('address',$address);
        $this->assign('province_list',$province_list);
        $member_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $_SESSION['member_id']);
        $this->assign('member_info',$member_info);
        $SEO = seo('','订单确认 - 积分商城');
        $this->assign('SEO',$SEO);
        $this->display();
    }
    
    public function payment(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            message('','index.php?c=member&a=login',0);
        }
        if(IS_POST){
            $point = getGpc('point','integer','P');
            $cart_id = getGpc('cart_id','array','P');
            $address_id = getGpc('address_id','integer','P');
            $payment_id = getGpc('payment_id','string','P');
            if(!in_array($payment_id,array('alipay'))){
                message('支付方式不存在','/index.php?c=shop&a=cart',3);
            }
            $cart_ids = array_map('intval',$cart_id);
            if(empty($cart_ids)){
                message('请选择支付产品','index.php?c=shop&a=cart',3);
            }
            $cart_ids = implode(',',$cart_ids);
            $db = Mysql::connect();
            $cart_goods = $db->getAll('select * from '.config('DB_TABLE_PRE').'cart where cart_id in (' . $cart_ids .')');
            if(!$cart_goods){
                $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id in  (' . $cart_ids .')');
                message('商品已下架','/index.php?c=shop&a=cart',3);
            }
            $orders = array();
            foreach($cart_goods as &$goods){
                if($goods['goods_type'] == 0){
                    $goods_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods['goods_id']);
                    if($goods_info['shelf'] == 0){
                        $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id = ' . $cart_id);
                        unset($goods);
                        continue;
                    }
                    $goods['goods_attr'] = unserialize($goods['goods_attr']);
                    $goods_info['goods_attr'] = unserialize($goods_info['goods_attr']);
                    $goods_attr_str = '';
                    $goods['price'] = $goods_info['price'];
                    foreach($goods['goods_attr'] as $key=>$goods_attr){
                        $goods['price'] += $goods_info['goods_attr'][$key]['value'][$goods_attr]['price'];
                        $goods_attr_str .= $goods_info['goods_attr'][$key]['name'] . '：'.$goods_info['goods_attr'][$key]['value'][$goods_attr]['name'] . '；<br />';
                    }
                    unset($goods_info['price']);
                    $goods = array_merge($goods,$goods_info);
                    $goods['goods_attr'] = $goods_attr_str;
                }else{
                    $goods_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'package where package_id = ' . $goods['goods_id']);
                    if($goods_info['shelf'] == 0){
                        $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id = ' . $cart_id);
                        unset($goods);
                        continue;
                    }
                    $package_goods = $db->getAll('select g.* from '.config('DB_TABLE_PRE').'package_goods p left join '.config('DB_TABLE_PRE').'goods g on p.goods_id  = g.goods_id where p.package_id = ' . $goods['goods_id']);
                    $goods_attr_str = '';
                    foreach($package_goods as &$val){
                        $goods_attr_str .= $val['name'] . '；<br />';
                        $val['goods_attr'] = unserialize($val['goods_attr']);
                        foreach($val['goods_attr'] as $goods_attr){
                            $val['attr'] .= $goods_attr['name'] . '：'.$goods_attr['value'][0]['name'] . '；<br />';
                        }
                    }
                    $goods_info['goods'] = $package_goods;
                    $goods = array_merge($goods,$goods_info);
                    $goods['goods_attr'] = $goods_attr_str;
                }
                $goods['price'] *= $goods['goods_num'];
                $orders['original_price'] += $goods['price'];
            }
            if(empty($cart_goods)){
                message('商品已下架','/index.php?c=shop&a=cart',3);
            }

            $member_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $_SESSION['member_id']);
            if($point > $member_info['point']){
                $point = $member_info['point'];
            }
            $c_point_price = intval(config('point_price'));
            $point_price = @$point / $c_point_price;
            $price = $orders['original_price'];
            if($point_price > $orders['original_price']){
                $point = $orders['original_price'] * $c_point_price;
                $price = 0;
            }else{
                $price = $orders['original_price'] - $point_price;
            }
            $price = ceil($price * 100)/100;
            $point = abs(round($point_price,2) * $c_point_price);
            
            
            if($address_id == 0){
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
                if(!$db->exec($sql)) {
                    message('收货地址保存失败','/index.php?c=shop&a=cart',3);
                }else{
                    $address_id = $db->insertId();
                }
            }
            $address = $db->getOne('select a.*,r1.region_name as province_name,r2.region_name as city_name,r3.region_name as district_name from '.config('DB_TABLE_PRE').'member_address a left join '.config('DB_TABLE_PRE').'region r1 on a.province = r1.region_id left join '.config('DB_TABLE_PRE').'region r2 on a.city = r2.region_id left join '.config('DB_TABLE_PRE').'region r3 on a.district = r3.region_id where a.member_id = ' . $_SESSION['member_id'] . ' and a.address_id = ' . $address_id);
            if(!$address){
                message('收货地址不存在','/index.php?c=shop&a=cart',3);
            }
            $time = time();
            do{
                $trade_no = 'JFSC' . date('YmdHis') . getRandID(4);
                $sql = 'select * from '.config('DB_TABLE_PRE').'orders where trade_no = "' . $trade_no . '"';
                $trade = $db->getOne($sql);
            }while($trade);
            $orders['trade_no'] = $trade_no;
            $orders['member_id'] = $_SESSION['member_id'];
            $orders['price'] = $price;
            $orders['point'] = $point;
            $orders['payment_id'] = $payment_id;
            $orders['nickname'] = $address['username'];
            $orders['address'] = $address['province_name'] .' '. $address['city_name'] .' '. $address['district_name'] .' '. $address['address'];
            $orders['postcode'] = $address['postcode'];
            $orders['phone'] = $address['phone'];
            $orders['point_price'] = $point_price;
            $orders['change_price'] = 0;
            if($price == 0){
                $orders['status'] = 1;
            }else{
                $orders['status'] = 0;
            }
            $orders['add_time'] = $time;
            $sql = insertTable(config('DB_TABLE_PRE').'orders',$orders);
            if($db->exec($sql)){
                $orders_id = $db->insertId();
                foreach($cart_goods as &$goods){
                    $data = array();
                    $data['orders_id'] = $orders_id;
                    $data['goods_id'] = $goods['goods_id'];
                    $data['goods_name'] = $goods['name'];
                    $data['goods_type'] = $goods['goods_type'];
                    $data['is_package'] = 0;
                    $data['package_id'] = 0;
                    $data['goods_image'] = $goods['image'];
                    $data['goods_attr'] = $goods['goods_attr'];
                    $data['goods_num'] = $goods['goods_num'];
                    $data['price'] = $goods['price'];
                    $sql = insertTable(config('DB_TABLE_PRE').'orders_goods',$data);
                    $db->exec($sql);
                    if($goods['goods_type'] == 1){
                        foreach($goods['goods'] as $val){
                            $data = array();
                            $data['orders_id'] = $orders_id;
                            $data['goods_id'] = $val['goods_id'];
                            $data['goods_name'] = $val['name'];
                            $data['goods_type'] = 0;
                            $data['is_package'] = 1;
                            $data['package_id'] = $goods['goods_id'];
                            $data['goods_image'] = $val['image'];
                            $data['goods_attr'] = $val['attr'];
                            $data['goods_num'] = 1;
                            $data['price'] = $val['price'];
                            $sql = insertTable(config('DB_TABLE_PRE').'orders_goods',$data);
                            $db->exec($sql);
                        }
                    }
                }
                $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id in (' . $cart_ids .')');
                if($point != 0){
                    $sql = 'update '.config('DB_TABLE_PRE').'member set point = point - ' . $point . ' where member_id = ' . $_SESSION['member_id'];
                    if($db->exec($sql)){
                        $point_data = array();
                        $point_data['member_id'] = $_SESSION['member_id'];
                        $point_data['point'] = -$point;
                        $point_data['description'] = '购买商品抵扣积分（订单号：'.$orders['trade_no'].'）';
                        $point_data['add_time'] = time();
                        $sql = insertTable(config('DB_TABLE_PRE').'member_point_log',$point_data);
                        $db->exec($sql);
                    }
                }
                
                if($price != 0){
                    switch($payment_id){
                        case 'alipay' :
                            $alipay = new Alipay;
                            $pay_code = $alipay->get_pay_code($orders);
                            break;
                        case 'weixinpay' :
                            $weixinpay = new weixinpay;
                            $pay_code = $weixinpay->get_pay_code($orders);
                            break;
                    }
                    $this->assign('pay_code',$pay_code);
                    $this->assign('orders',$orders);
                    $SEO = seo('','下单成功 - 积分商城');
                    $this->assign('SEO',$SEO);
                    $this->display();
                }else{
                    if($point != 0){
                        $sql = 'update '.config('DB_TABLE_PRE').'member set point = point + ' . $point . ' where member_id = ' . $_SESSION['member_id'];
                        if($db->exec($sql)){
                            $point_data = array();
                            $point_data['member_id'] = $_SESSION['member_id'];
                            $point_data['point'] = $point;
                            $point_data['description'] = '购买商品增加积分（订单号：'.$orders['trade_no'].'）';
                            $point_data['add_time'] = time();
                            $sql = insertTable(config('DB_TABLE_PRE').'member_point_log',$point_data);
                            $db->exec($sql);
                        }
                    }
                    message('支付成功','index.php?c=member&a=orders',3);
                }
            }else{
                message('系统错误','index.php?c=shop&a=cart',3);
            }
        }else{
            message('','index.php?c=shop&a=cart',0);
        }
    }
    
    public function change_price(){
        if(!isset($_SESSION['member_id']) || $_SESSION['member_id'] == null ){
            $this->ajaxReturn(array('status'=>0));
        }
        if(IS_POST){
            $point = getGpc('point','integer','P');
            $cart_id = getGpc('cart_id','array','P');
            $cart_ids = array_map('intval',$cart_id);
            if(empty($cart_ids)){
                $this->ajaxReturn(array('status'=>0));
            }
            $cart_ids = implode(',',$cart_ids);
            $db = Mysql::connect();
            $cart_goods = $db->getAll('select * from '.config('DB_TABLE_PRE').'cart where cart_id in (' . $cart_ids .')');
            if(!$cart_goods){
                $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id in  (' . $cart_ids .')');
                $this->ajaxReturn(array('status'=>0));
            }
            $original_price = 0;
            foreach($cart_goods as &$goods){
                if($goods['goods_type'] == 0){
                    $goods_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods['goods_id']);
                    if($goods_info['shelf'] == 0){
                        $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id = ' . $cart_id);
                        unset($goods);
                        continue;
                    }
                    $goods['goods_attr'] = unserialize($goods['goods_attr']);
                    $goods_info['goods_attr'] = unserialize($goods_info['goods_attr']);
                    $goods_attr_str = '';
                    $goods['price'] = $goods_info['price'];
                    foreach($goods['goods_attr'] as $key=>$goods_attr){
                        $goods['price'] += $goods_info['goods_attr'][$key]['value'][$goods_attr]['price'];
                        $goods_attr_str .= $goods_info['goods_attr'][$key]['name'] . '：'.$goods_info['goods_attr'][$key]['value'][$goods_attr]['name'] . '；<br />';
                    }
                    unset($goods_info['price']);
                    $goods = array_merge($goods,$goods_info);
                    $goods['goods_attr'] = $goods_attr_str;
                }else{
                    $goods_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'package where package_id = ' . $goods['goods_id']);
                    if($goods_info['shelf'] == 0){
                        $db->exec('delete from '.config('DB_TABLE_PRE').'cart where cart_id = ' . $cart_id);
                        unset($goods);
                        continue;
                    }
                    $package_goods = $db->getAll('select g.* from '.config('DB_TABLE_PRE').'package_goods p left join '.config('DB_TABLE_PRE').'goods g on p.goods_id  = g.goods_id where p.package_id = ' . $goods['goods_id']);
                    $goods_attr_str = '';
                    foreach($package_goods as &$val){
                        $goods_attr_str .= $val['name'] . '；<br />';
                        $val['goods_attr'] = unserialize($val['goods_attr']);
                        foreach($val['goods_attr'] as $goods_attr){
                            $val['attr'] .= $goods_attr['name'] . '：'.$goods_attr['value'][0]['name'] . '；<br />';
                        }
                    }
                    $goods_info['goods'] = $package_goods;
                    $goods = array_merge($goods,$goods_info);
                    $goods['goods_attr'] = $goods_attr_str;
                }
                $goods['price'] *= $goods['goods_num'];
                $original_price += $goods['price'];
            }
            $member_info = $db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $_SESSION['member_id']);
            if($point > $member_info['point']){
                $point = $member_info['point'];
            }
            $c_point_price = intval(config('point_price'));
            $point_price = @$point / $c_point_price;
            $price = $original_price;
            if($point_price > $original_price){
                $point = $price * $c_point_price;
                $price = 0;
            }else{
                $price = $price - $point_price;
            }
            $price = ceil($price * 100)/100;
            $point = abs(round($original_price - $price,2) * $c_point_price);
            $this->ajaxReturn(array('status'=>1,'price'=>$price,'point'=>$point));
        }else{
            $this->ajaxReturn(array('status'=>0));
        }
    }
    
    private function get_regions($type = 0, $parent = 0){
        $db = Mysql::connect();
        $sql = 'select region_id, region_name FROM ' . config('DB_TABLE_PRE') .'region where region_type = ' .$type . ' and parent_id = '.$parent;
        return $db->getAll($sql);
    }
}
?>