<?php
class ShopController extends Controller {
    private $db;
    private $site_info;
    
    public function __construct(){
        parent::__construct();
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] == null ){
            message('请先登录','index.php?c=index&a=login',3);
        }
        $this->db = Mysql::connect();
        $config = array();
        $config = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'shop_config');
        $configs = array();
        foreach($config as $val){
            $configs[$val['config_name']] = unserialize($val['config_value']) ? unserialize($val['config_value']) : $val['config_value'];
        }
        $this->assign('config',$configs);
    }
    
    public function category(){
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'shop_category order by listorder asc,category_id desc');
        $this->assign('list',$list);
        $this->display();
    }
    
    public function add_category(){
        if(IS_POST){
            $data['name']           = escapeString(getGpc('name','string','P'));
            $data['image']          = escapeString(getGpc('image','string','P'));
            $data['description']    = escapeString(getGpc('description','string','P'));
            $data['is_show']        = escapeString(getGpc('is_show','integer','P'));
            $data['listorder']      = 99;
            if(trim($data['name']) == ''){
                message('分类名称不能为空','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'shop_category',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=shop&a=category',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }
    
    public function edit_category(){
        if(IS_POST){
            $category_id            = getGpc('category_id','integer','P');
            $data['name']           = escapeString(getGpc('name','string','P'));
            $data['image']          = escapeString(getGpc('image','string','P'));
            $data['description']    = escapeString(getGpc('description','string','P'));
            $data['is_show']        = escapeString(getGpc('is_show','integer','P'));
            if(trim($data['name']) == ''){
                message('分类名称不能为空','',3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'shop_category where category_id = ' . $category_id . ' order by category_id asc limit 1');
            if(!$info){
                message('操作分类不存在','',3);
            }
            $where = array('category_id'=>$category_id);
            $sql = updateTable(config('DB_TABLE_PRE').'shop_category',$data,$where);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=shop&a=category',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $category_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'shop_category where category_id = ' . $category_id . ' order by category_id asc limit 1');
            if(!$info){
                message('操作分类不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function delete_category(){
        $category_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'shop_category where category_id = ' . $category_id . ' order by category_id asc limit 1');
        if(!$info){
            message('操作栏目不存在','',3);
        }
        $return = $this->db->exec('delete from '.config('DB_TABLE_PRE').'shop_category where category_id = ' . $category_id);
        if($return){
            message('操作成功','index.php?c=shop&a=category',3);
        }else{
            message('操作失败','',3);
        }
    }
    
    public function category_listorder(){
        $category_id = getGpc('category_id','integer','P');
        $listorder   = getGpc('listorder','integer','P');
        $sql = updateTable(config('DB_TABLE_PRE').'shop_category',array('listorder'=>$listorder),array('category_id'=>$category_id));
        if($this->db->exec($sql)){
            $this->cache_categorys();
            $this->ajaxReturn(array('status'=>1,'category_id'=>$category_id));
        }else{
            $this->ajaxReturn(array('status'=>0,'category_id'=>$category_id));
        }
    }
    
    public function goods(){
        $category_id = getGpc('category_id','integer','P');
        $where = ' 1 = 1 ';
        if($category_id != 0){
            $where .= ' and category_id = ' . $category_id;
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'goods where ' . $where);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'goods where ' . $where . ' order by listorder asc,goods_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $category  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'shop_category order by listorder asc,category_id desc');
        $this->assign('category',$category);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function goods_add(){
        if(IS_POST){
            $data['category_id']        = getGpc('category_id','integer','P');
            $data['name']               = getGpc('name','string','P') ? escapeString(getGpc('name','string','P')) : message('请填写商品名称',$_SERVER['HTTP_REFERER'],3);
            $data['price']              = getGpc('price','string','P');
            $data['point']              = getGpc('point','integer','P');
            $data['image']              = escapeString(getGpc('image','string','P'));
            $data['description']        = escapeString(getGpc('description','string','P'));
            $data['shelf']              = getGpc('shelf','integer','P');
            $data['is_pos']             = getGpc('is_pos','integer','P');
            $data['content']            = escapeString(getGpc('content','string','P'));
            $data['sales']              = 0;
            $data['listorder']          = 99;
            $data['add_time']           = time();
            $data['update_time']        = time();
            $goods_attr = getGpc('attr','array','P');
            if(!empty($goods_attr)){
                foreach($goods_attr as $attr){
                    if($attr['name'] != '' && $attr['value'] != ''){
                        $data['goods_attr'][] = $attr;
                    }
                }
            }
            $data['goods_attr']     = serialize($data['goods_attr']);
            if($data['category_id'] == 0 ){
                message('请选择一个分类','index.php?c=shop&a=goods_add',3);
            }
            if(!$this->db->getOne('select * from '.config('DB_TABLE_PRE').'shop_category where category_id = ' . $data['category_id'])){
                message('找不到指定的分类',$_SERVER['HTTP_REFERER'],3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'goods',$data);
            if($this->db->exec($sql)){
                $goods_id = $this->db->insertId();
                $album = getGpc('album','array','P');
                foreach($album as $v){
                    $save = array();
                    $save['goods_id'] = $goods_id;
                    $save['image']      = $v;
                    $sql = insertTable(config('DB_TABLE_PRE').'goods_album',$save);
                    $this->db->exec($sql);
                }
                message('操作成功','index.php?c=shop&a=goods',3);
            }else{
                die($sql);
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $category  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'shop_category order by listorder asc,category_id desc');
            $this->assign('category',$category);
            $this->display();
        }
    }
    
    public function goods_edit(){
        if(IS_POST){
            $goods_id    = getGpc('goods_id','integer','P');
            $data['category_id']        = getGpc('category_id','integer','P');
            $data['name']               = getGpc('name','string','P') ? escapeString(getGpc('name','string','P')) : message('请填写商品名称',$_SERVER['HTTP_REFERER'],3);
            $data['price']              = getGpc('price','string','P');
            $data['point']              = getGpc('point','integer','P');
            $data['image']              = escapeString(getGpc('image','string','P'));
            $data['description']        = escapeString(getGpc('description','string','P'));
            $data['shelf']              = getGpc('shelf','integer','P');
            $data['is_pos']             = getGpc('is_pos','integer','P');
            $data['content']            = escapeString(getGpc('content','string','P'));
            $data['update_time']        = time();
            $goods_attr = getGpc('attr','array','P');
            if(!empty($goods_attr)){
                foreach($goods_attr as $attr){
                    if($attr['name'] != '' && $attr['value'] != ''){
                        $data['goods_attr'][] = $attr;
                    }
                }
            }
            $data['goods_attr']     = serialize($data['goods_attr']);
            if($data['category_id'] == 0 ){
                message('请选择一个分类','index.php?c=shop&a=goods_add',3);
            }
            if(!$this->db->getOne('select * from '.config('DB_TABLE_PRE').'shop_category where category_id = ' . $data['category_id'])){
                message('找不到指定的分类',$_SERVER['HTTP_REFERER'],3);
            }
            $where = array('goods_id'=>$goods_id);
            $sql = updateTable(config('DB_TABLE_PRE').'goods',$data,$where);
            if($this->db->exec($sql)){
                $albums = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'goods_album where goods_id = ' . $goods_id);
                $album = getGpc('album','array','P');
                foreach($albums as $v){
                    if(in_array($v['image'],$album)){
                        $key = array_keys($album,$v['image']);
                        unset($album[$key[0]]);
                    } else {
                        $this->db->exec('delete from '.config('DB_TABLE_PRE').'goods_album where album_id = ' . $v['album_id']);
                    }
                }
                foreach($album as $v){
                    $save = array();
                    $save['goods_id'] = $goods_id;
                    $save['image']      = $v;
                    $sql = insertTable(config('DB_TABLE_PRE').'goods_album',$save);
                    $this->db->exec($sql);
                }
                message('操作成功','index.php?c=shop&a=goods',3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $goods_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods_id);
            if(!$info){
                message('内容不存在','',3);
            }
            $info['goods_attr'] = unserialize($info['goods_attr']);
            $albums = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'goods_album where goods_id = ' . $info['goods_id']);
            $this->assign('albums',$albums);
            $category  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'shop_category order by listorder asc,category_id desc');
            $this->assign('category',$category);
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function goods_delete(){
        $goods_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods_id);
        if(!$info){
            message('商品不存在','',3);
        }
        $sql = 'delete from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $goods_id;
        if($this->db->exec($sql)){
            $sql = 'select * from '.config('DB_TABLE_PRE').'goods_album where goods_id = ' . $goods_id;
            $albums = $this->db->getAll($sql);
            $album_ids = array();
            if($albums){
                foreach($albums as $v){
                    $album_ids[] = $v['album_id'];
                }
                $album_ids = implode(',',$album_ids);
                $sql = 'delete from '.config('DB_TABLE_PRE').'goods_album where album_id in (' . $album_ids . ')';
                $this->db->exec($sql);
            }
            message('操作成功','index.php?c=shop&a=goods',3);
        }else{
            message('操作失败',$_SERVER['HTTP_REFERER'],3);
        }
    }
    
    public function listorder_goods(){
        $goods_id = getGpc('goods_id','integer','P');
        $listorder   = getGpc('listorder','integer','P');
        $sql = updateTable(config('DB_TABLE_PRE').'goods',array('listorder'=>$listorder),array('goods_id'=>$goods_id));
        if($this->db->exec($sql)){
            $this->ajaxReturn(array('status'=>1,'goods_id'=>$goods_id));
        }else{
            $this->ajaxReturn(array('status'=>0,'goods_id'=>$goods_id));
        }
    }
    
    public function package(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'package');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'package order by add_time desc,package_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function package_add(){
        if(IS_POST){
            $data['name']               = getGpc('name','string','P') ? escapeString(getGpc('name','string','P')) : message('请填写礼包名称',$_SERVER['HTTP_REFERER'],3);
            $data['price']              = getGpc('price','string','P');
            $data['point']              = getGpc('point','integer','P');
            $data['description']        = escapeString(getGpc('description','string','P'));
            $data['shelf']              = getGpc('shelf','integer','P');
            $data['sales']              = 0;
            $data['add_time']           = time();
            $data['update_time']        = time();
            $sql = insertTable(config('DB_TABLE_PRE').'package',$data);
            if($this->db->exec($sql)){
                $package_id = $this->db->insertId();
                $goods = getGpc('goods','array','P');
                $goods = array_unique($goods);
                foreach($goods as $v){
                    $v = intval($v);
                    if($v == 0) continue;
                    $save = array();
                    $save['package_id'] = $package_id;
                    $save['goods_id']   = $v;
                    $sql = insertTable(config('DB_TABLE_PRE').'package_goods',$save);
                    $this->db->exec($sql);
                }
                message('操作成功','index.php?c=shop&a=package',3);
            }else{
                die($sql);
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $this->display();
        }
    }
    
    public function package_edit(){
        if(IS_POST){
            $package_id    = getGpc('package_id','integer','P');
            $data['name']               = getGpc('name','string','P') ? escapeString(getGpc('name','string','P')) : message('请填写礼包名称',$_SERVER['HTTP_REFERER'],3);
            $data['price']              = getGpc('price','string','P');
            $data['point']              = getGpc('point','integer','P');
            $data['description']        = escapeString(getGpc('description','string','P'));
            $data['shelf']              = getGpc('shelf','integer','P');
            $data['update_time']        = time();
            $where = array('package_id'=>$package_id);
            $sql = updateTable(config('DB_TABLE_PRE').'package',$data,$where);
            if($this->db->exec($sql)){
                $goods = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'package_goods where package_id = ' . $package_id);
                $goods_ids = getGpc('goods','array','P');
                $goods_ids = array_unique($goods_ids);
                foreach($goods as $v){
                    if(in_array($v['goods_id'],$goods_ids)){
                        $key = array_keys($goods_ids,$v['goods_id']);
                        unset($goods_ids[$key[0]]);
                    } else {
                        $this->db->exec('delete from '.config('DB_TABLE_PRE').'package_goods where relation_id = ' . $v['relation_id']);
                    }
                }
                foreach($goods_ids as $v){
                    $save = array();
                    $save['package_id'] = $package_id;
                    $save['goods_id']   = $v;
                    $sql = insertTable(config('DB_TABLE_PRE').'package_goods',$save);
                    $this->db->exec($sql);
                }
                message('操作成功','index.php?c=shop&a=package',3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $package_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'package where package_id = ' . $package_id);
            if(!$info){
                message('礼包不存在','',3);
            }
            $goods = $this->db->getAll('select g.* from '.config('DB_TABLE_PRE').'package_goods p left join '.config('DB_TABLE_PRE').'goods g on p.goods_id = g.goods_id where p.package_id = ' . $info['package_id']);
            $this->assign('goods',$goods);
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function package_delete(){
        $package_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'package where package_id = ' . $package_id);
        if(!$info){
            message('商品不存在','',3);
        }
        $sql = 'delete from '.config('DB_TABLE_PRE').'package where package_id = ' . $package_id;
        if($this->db->exec($sql)){
            $sql = 'select * from '.config('DB_TABLE_PRE').'package_goods where package_id = ' . $package_id;
            $goods = $this->db->getAll($sql);
            $relation_ids = array();
            if($goods){
                foreach($goods as $v){
                    $relation_ids[] = $v['relation_id'];
                }
                $relation_ids = implode(',',$relation_ids);
                $sql = 'delete from '.config('DB_TABLE_PRE').'package_goods where relation_id in (' . $relation_ids . ')';
                $this->db->exec($sql);
            }
            message('操作成功','index.php?c=shop&a=package',3);
        }else{
            message('操作失败',$_SERVER['HTTP_REFERER'],3);
        }
    }
    
    public function select_goods(){
        $category_id = getGpc('category_id','integer','P');
        $where = ' 1 = 1 ';
        if($category_id != 0){
            $where .= ' and category_id = ' . $category_id;
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'goods where ' . $where);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'goods where ' . $where . ' order by listorder asc,goods_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $category  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'shop_category order by listorder asc,category_id desc');
        $this->assign('category',$category);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function orders(){
        $status = getGpc('status','integer','P');
        switch($status){
            case 0 :
                $where = ' where 1=1 ';
                break;
            case 1 :
                $where = ' where status=1 ';
                break;
            case 2 :
                $where = ' where status=0 ';
                break;
            default :
                $where = ' where 1=1 ';
                break;
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'orders ' . $where);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'orders ' . $where . ' order by orders_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function orders_show(){
        if(IS_POST){
            $orders_id = getGpc('orders_id','integer','P');
            $status = getGpc('status','integer','P');
            $change_price = getGpc('change_price','string','P');
            $change_price = (float)$change_price;
            $sql = 'select * from '.config('DB_TABLE_PRE').'orders where orders_id = ' . $orders_id;
            $orders = $this->db->getOne($sql);
            if(!$orders){
                message('订单不存在','',3);
            }
            $sql = 'update '.config('DB_TABLE_PRE').'orders set status = ' . $status . ' , change_price = ' . $change_price . ' , price = original_price - point_price - ' . $change_price . ' where orders_id = ' . $orders_id;
            if($this->db->exec($sql)){
                if($status == 1){
                    $sql = 'select * from '.config('DB_TABLE_PRE').'orders_goods where is_package = 0 and orders_id = ' . $orders['orders_id'];
                    $orders_goods = $this->db->getAll($sql);
                    $point = 0;
                    foreach($orders_goods as $val){
                        if($val['goods_type'] == 1){
                            $sql = 'select * from '.config('DB_TABLE_PRE').'package where package_id = ' . $val['goods_id'];
                            $goods = $this->db->getOne($sql);
                            $point += $goods['point'];
                        }else{
                            $sql = 'select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $val['goods_id'];
                            $goods = $this->db->getOne($sql);
                            $point += $goods['point'];
                        }
                    }
                    if($point != 0){
                        $sql = 'update '.config('DB_TABLE_PRE').'member set point = point + ' . $point . ' where member_id = ' . $orders['member_id'];
                        if($this->db->exec($sql)){
                            $point_data = array();
                            $point_data['member_id'] = $orders['member_id'];
                            $point_data['point'] = $point;
                            $point_data['description'] = '购买商品增加积分（订单号：'.$orders['trade_no'].'）';
                            $point_data['add_time'] = time();
                            $sql = insertTable(config('DB_TABLE_PRE').'member_point_log',$point_data);
                            $this->db->exec($sql);
                        }
                    }
                }
                message('操作成功','index.php?c=shop&a=orders',3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $orders_id = getGpc('id','integer','G');
            $orders = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'orders where orders_id = ' . $orders_id);
            if(!$orders){
                message('订单不存在','',3);
            }
            $order_goods = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'orders_goods where orders_id = ' . $orders_id);
            $this->assign('orders',$orders);
            $this->assign('order_goods',$order_goods);
            $this->display();
        }
    }
    
    public function orders_delete(){
        $orders_id = getGpc('id','integer','G');
        $content = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'orders where orders_id = ' . $orders_id);
        if(!$content){
            message('订单不存在','',3);
        }
        $sql = 'delete from '.config('DB_TABLE_PRE').'orders where orders_id = ' . $orders_id;
        if($this->db->exec($sql)){
            $this->db->exec('delete from '.config('DB_TABLE_PRE').'orders_goods where orders_id = ' . $orders_id);
            message('操作成功','index.php?c=shop&a=orders',3);
        }else{
            message('操作失败',$_SERVER['HTTP_REFERER'],3);
        }
    }
    
    public function save_config(){
        if(IS_POST){
            $config = getGpc('config','array','P');
            $return = false;
            foreach($config as $key=>$val){
                if(in_array(gettype($val),array('array','object','resource'))){
                    $val = serialize($val);
                }
                if($this->db->getOne('select * from '.config('DB_TABLE_PRE').'shop_config where config_name = "' . $key . '"')){
                    $sql = updateTable(config('DB_TABLE_PRE').'shop_config',array('config_value'=>$val),array('config_name'=>$key));
                }else{
                    $sql = insertTable(config('DB_TABLE_PRE').'shop_config',array('config_value'=>$val,'config_name'=>$key));
                }
                $return = $this->db->exec($sql) || $return;
            }
            if($return){
                message('操作成功',$_SERVER['HTTP_REFERER'],3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            message('','index.php?c=shop&a=setting',0);
        }
    }
    
    public function _empty($m,$a){
        $this->display($m);
    }
}
?>