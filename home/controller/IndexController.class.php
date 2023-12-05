<?php
class IndexController extends Controller {
    public function __construct(){
        SafeTesting();
        parent::__construct();
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where siteurl = "' . $url . '"');
        if(!$info || $info['status'] != 1){
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where status = 1');
            if(!$info ){
                header("HTTP/1.1 404 Not Found");
                die;
            }
        }
        config('__DB__',SITE_PATH . 'data/' . $info['site_dir'] . 'db');
        $city_id = trim(getGpc('city_id','string','G'));
        if($city_id != ''){
            $Sqlite_db = Sqlite::connect(config('__DB__'));
            $city = $Sqlite_db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $city_id . '"');
            $this->assign('city',$city['name']);
        }
        $info['keywords'] = $city['name'] . str_replace(',',','.$city['name'],$info['keywords']);
        $info['description'] = $city['name'] . $info['description'];
        config('SITE_INFO',$info);
        defined('__PUBLIC__') or define('__PUBLIC__', HTTP_HOST . '/' . 'data/' . config('SITE_INFO.site_dir').'static/');
        $CATEGORYS = Content::get_category_cache();
        $this->assign('CATEGORYS',$CATEGORYS);
    }

    public function index(){
        $SEO = seo();
        $this->assign('SEO',$SEO);
        $this->display();
    }

    public function sitemap(){
        $type = getGpc('type','string','G');
        if($type == 'xml'){
            $db = Sqlite::connect(config('__DB__'));
            $data_array = $db->getAll('select * from '.config('DB_TABLE_PRE').'category');
            $string = '<?xml version="1.0" encoding="utf-8"?><urlset></urlset>';
            $xml = simplexml_load_string($string);
            $item = $xml->addChild('url');
            $item->addChild('loc', config('SITE_INFO.siteurl'));
            $item->addChild('changefreq', 'always');
            $item->addChild('priority', '1.0');
            foreach($data_array as $category){
                $_data[$category['category_id']] = $category;
            }
            foreach($_data as $category){
                switch ($category['type_id']){
                    case 1:
                    case 2:
                        $category['url'] = config('SITE_INFO.siteurl');
                        $parent_ids = explode(',',$category['parent_ids']);
                        foreach($parent_ids as $parent_id){
                            if($parent_id != 0){
                                $category['url'] .= $_data[$parent_id]['url_name'].'/';
                            }
                        }
                        $category['url'] .= $category['url_name'].'/';
                        break;
                    case 3:
                        $category['url'] = config('SITE_INFO.siteurl') .$category['url_name'].'.html';
                        break;
                    case 4:
                        $category['url'] = $category['url'];
                        break;
                }
                $item = $xml->addChild('url');
                if (is_array($category)) {
                    $item->addChild('loc', $category['url']);
                    $item->addChild('changefreq', 'always');
                    $item->addChild('priority', '0.8');
                }
            }
            header("Content-type:text/xml");
            echo $xml->asXML();
        }else{
            $SEO = seo('','网站地图');
            $this->assign('SEO',$SEO);
            $this->display();
        }
    }

    public function search(){
        $keyword = getGpc('keyword','string','G');
        if($keyword == ''){
            message('',config('SITE_INFO.siteurl'),0);
        }
        $SEO = seo('',$keyword . ' - 全站搜索');
        $this->assign('SEO',$SEO);
        $sp = new SplitWord();
        $split_result = $sp->SplitRMM($keyword);
        if(!is_utf8($split_result)) $split_result = iconv("GB2312//IGNORE", "UTF-8", $split_result);
        
        $result_array = explode(' ',trim($split_result));
        foreach($result_array as $result){
            $sql_array[] = ' title like \'%' . $result . '%\' or description like \'%' . $result . '%\' ';
        }
        $where = ' (' . implode('or',$sql_array) . ') ';
        $this->assign('keyword',$keyword);
        $this->assign('where',$where);
        $this->display();
    }

    public function lists(){
        $ajax = getGpc('ajax','integer','G');
        $othername = getGpc('othername','string','G');
        if($othername == ''){
            message('',config('SITE_INFO.siteurl'),0);
        }

        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from '.config('DB_TABLE_PRE').'category where url_name = "' . $othername. '"';
        $category = $db->getOne($sql);
        if(!$category){
            message('',config('SITE_INFO.siteurl'),0);
        }
        $category['list_template'] = $category['list_template']? $category['list_template'] :'lists';
        $page = getGpc('page','integer','G') ? getGpc('page','integer','G') : 1;
        $title = $category['title'] ? $category['title'] : $category['name'];
        $SEO = seo('',$title,$category['description'],$category['keywords']);
        $this->assign('SEO',$SEO);
        $this->assign($category);
        if($ajax){
            $this->display('ajax_'.$category['list_template']);
        }else{
            $this->display($category['list_template']);
        }
    }

    public function show(){
        $id = getGpc('id','integer','G');
        $CATEGORYS = $this->_get('CATEGORYS');
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from '.config('DB_TABLE_PRE').'content where content_id = ' . $id;
        $info = $db->getOne($sql);
        $true_title = $info['title'];
        if(!$info){
            message('',config('SITE_INFO.siteurl'),0);
        }
        $sql = 'select count(1) as count_num from '.config('DB_TABLE_PRE').'like where content_id = ' . $id;
        $count_num = $db->getOne($sql);
        $this->assign('link_num',$count_num['count_num']);
        $data = array();
        $data['hits'] = $info['hits'] + 1 ;
        $where = array('content_id'=>$id);
        $sql = updateTable(config('DB_TABLE_PRE').'content',$data,$where);
        $db->exec($sql);
        $sql = 'select * from '.config('DB_TABLE_PRE').'content where content_id < ' . $id . ' and category_id = ' . $info['category_id'] . ' order by content_id desc limit 1';
        $previous_page = $db->getOne($sql);
        $sql = 'select * from '.config('DB_TABLE_PRE').'content where content_id > ' . $id . ' and category_id = ' . $info['category_id'] . ' order by content_id asc limit 1';
        $next_page = $db->getOne($sql);
        if($previous_page){
            $previous_page['title'] = $previous_page['title'];
            $previous_page['url'] = config('SITE_INFO.siteurl') .$previous_page['content_id'].'.html';
        }else{
            $previous_page['title'] = '没有了';
            $previous_page['url'] = 'javascript:void(0)';
        }
        $this->assign('previous_page',$previous_page);
        if($next_page){
            $next_page['title'] = $next_page['title'];
            $next_page['url'] = config('SITE_INFO.siteurl') .$next_page['content_id'].'.html';
        }else{
            $next_page['title'] = '没有了';
            $next_page['url'] = 'javascript:void(0)';
        }
        $this->assign('next_page',$next_page);
        $category = $CATEGORYS[$info['category_id']];
        if($category['type_id'] == 2){
            $sql = 'select * from '.config('DB_TABLE_PRE').'album where content_id = ' . $id;
            $album = $db->getAll($sql);
            $this->assign('album',$album);
        }
        $city = $this->_get('city');
        if($category['type_id'] == 2 && $city != ''){
            $info['title'] = $city . $info['title'];
        }

        $tail_id = getGpc('tail_id','integer','G');
        if($category['type_id'] == 2 && $tail_id != 0){
            $tail = $db->getOne('select * from '.config('DB_TABLE_PRE').'seo_tail where tail_id = ' . $tail_id);
            if($tail['prefix'] == 1){
                $info['title'] = $info['title'] . $tail['name'];
            }else{
                $info['title'] = $tail['name'] . $info['title'];
            }
        }
        $SEO = seo($category['category_id'],$info['title'],$info['description'],$info['keywords']);
        $this->assign('SEO',$SEO);

        if($db->getOne('select * from '.config('DB_TABLE_PRE').'model where model_id = ' . $category['model_id'])){
            $model_field = $db->getAll('select * from '.config('DB_TABLE_PRE').'model_field where model_id = ' . $category['model_id'] . ' and is_delete = 0');
            $this->assign('model_field',$model_field);
            $r = $db->getOne('select * from '.config('DB_TABLE_PRE').'model_data'.$category['model_id'] . ' where content_id = ' . $id);
            if (!empty($r)) {
                $info = array_merge($r, $info);
            }
        }
        $this->assign($info);
        $keywords = $info['keywords'] ? $info['keywords'] : $category['keywords'];
        $keywords = explode(',',$keywords);
        $this->assign('keywords_array',$keywords);
        $region = $db->getAll('select * from '.config('DB_TABLE_PRE').'region');
        $this->assign('region',$region);
        $tail = $db->getAll('select * from '.config('DB_TABLE_PRE').'seo_tail');
        $this->assign('tail',$tail);
        $this->assign('true_title',$true_title);
        $this->display($category['show_template']);
    }

    public function page(){
        $othername = getGpc('othername','string','G');
        if($othername == ''){
            message('',config('SITE_INFO.siteurl'),0);
        }

        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from '.config('DB_TABLE_PRE').'category where url_name = "' . $othername. '"';
        $category = $db->getOne($sql);
        if(!$category){
            message('',config('SITE_INFO.siteurl'),0);
        }
        $sql = 'select * from '.config('DB_TABLE_PRE').'page where category_id = ' . $category['category_id'];
        $info = $db->getOne($sql);
        if(!$info){
            $info['category_id'] = $category['category_id'];
        }
        $SEO = seo($category['category_id'],$info['title'],$info['description'],$info['keywords']);
        $this->assign('SEO',$SEO);
        $this->assign($info);
        $this->display($category['list_template']);
    }

    public function like(){
        $content_id = getGpc('content_id','integer','P');
        $ipaddress = getIp();
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from '.config('DB_TABLE_PRE').'like where content_id = ' . $content_id. ' and ipaddress = "'.$ipaddress.'"';
        $info = $db->getOne($sql);
        if($info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'已经点过赞了，不能重复点击'));
        }
        $data = array('content_id'=>$content_id,'ipaddress'=>$ipaddress);
        $sql = insertTable(config('DB_TABLE_PRE').'like',$data);
        if($db->exec($sql)){
            $this->ajaxReturn(array('status'=>1,'msg'=>'点赞成功'));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'点赞失败，请稍后重试'));
        }
        
    }

    public function region(){
        $id = getGpc('id','integer','G');
        if($id != 0){
            $sql = 'select * from '.config('DB_TABLE_PRE').'region where parent_id = ' . $id;
            $db = Mysql::connect();
            $info = $db->getAll($sql);
            $this->ajaxReturn($info);
        }else{
            $this->ajaxReturn(array());
        }
    }

    public function notify() {
        if(IS_POST){
            $pay_code = !empty($_REQUEST['code']) ? trim($_REQUEST['code']) : '';
            $payment = new $pay_code;
            $return = $payment->respond();
            if($return[0] != ''){
                $where = array('trade_no'=>$return[0]);
                $sql = updateTable(config('DB_TABLE_PRE').'orders',array('status'=>2),$where);
                $db = Mysql::connect();
                if($db->exec($sql)){
                    $sql = 'select * from '.config('DB_TABLE_PRE').'orders where trade_no = ' . $return[0];
                    $orders = $db->getOne($sql);
                    $sql = 'select * from '.config('DB_TABLE_PRE').'orders_goods where orders_id = ' . $orders['orders_id'];
                    $orders_goods = $db->getAll($sql);
                    $point = 0;
                    foreach($orders_goods as $val){
                        $sql = 'select * from '.config('DB_TABLE_PRE').'goods where goods_id = ' . $val['goods_id'];
                        $goods = $db->getOne($sql);
                        $point += $goods['point'];
                    }
                    if($point != 0){
                        $sql = 'update '.config('DB_TABLE_PRE').'member set point = point + ' . $point . ' where member_id = ' . $orders['member_id'];
                        if($db->exec($sql)){
                            $point_data = array();
                            $point_data['member_id'] = $orders['member_id'];
                            $point_data['point'] = $point;
                            $point_data['description'] = '购买商品增加积分（订单号：'.$orders['trade_no'].'）';
                            $point_data['add_time'] = time();
                            $sql = insertTable(config('DB_TABLE_PRE').'member_point_log',$point_data);
                            $db->exec($sql);
                        }
                    }
                    die($return[1]);
                }else{
                    die();
                }
            }
            die();
        }else{
            $this->display();
        }
	}
    
    protected function template($file) {
        $mtplfile = SITE_PATH . 'data/' . config('SITE_INFO.site_dir') .'template/wap/'. $file.'.html';
        $mobjfile = SITE_PATH . 'data/' . config('SITE_INFO.site_dir') .'cache/template/wap/'. $file.'.tpl.php';
        if(ismobile() && is_file($mtplfile)){
            $this->tplfile = $mtplfile;
            $this->objfile = $mobjfile;
        }else{
            $this->tplfile = SITE_PATH . 'data/' . config('SITE_INFO.site_dir') .'template/'. $file.'.html';
            $this->objfile = SITE_PATH . 'data/' . config('SITE_INFO.site_dir') .'cache/template/'. $file.'.tpl.php';
        }
        if(!is_file($this->tplfile)){
            return false;
        }
        if (IS_DEBUG || (@filemtime($this->tplfile) > @filemtime($this->objfile))) {
            $T = new contentTemplate;
            $T->complie($this->tplfile, $this->objfile);
        }
        return $this->objfile;
    }
}
?>