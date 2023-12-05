<?php
class TalentController extends ControllerContent {
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
        $SEO = seo('','招聘中心');
        $this->assign('SEO',$SEO);
        $db = Mysql::connect();
        $count_num = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'job_position where status = 1');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'job_position  where status = 1 order by position_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function position(){
        $SEO = seo('','招聘中心');
        $this->assign('SEO',$SEO);
        $db = Mysql::connect();
        $position_id = getGpc('id','integer','G');
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'job_position where status = 1 and position_id = ' . $position_id);
        if(!$info){
            message('职位不存在','',3);
        }
        $this->assign('info',$info);
        $this->display();
    }
    
    public function add(){
        if(IS_POST){
            $db = Mysql::connect();
            $data = array();
            $data['name']               = sqliteEscapeString(getGpc('name','string','P'));
            $data['sex']                = getGpc('sex','integer','P');
            $data['qq']                 = sqliteEscapeString(getGpc('qq','string','P'));
            $data['tel']                = sqliteEscapeString(getGpc('tel','string','P'));
            $data['address']            = sqliteEscapeString(getGpc('address','string','P'));
            $data['nation']             = sqliteEscapeString(getGpc('nation','string','P'));
            $data['birthday']           = sqliteEscapeString(getGpc('birthday','string','P'));
            $data['birthplace']         = sqliteEscapeString(getGpc('birthplace','string','P'));
            $data['home_address']       = sqliteEscapeString(getGpc('home_address','string','P'));
            $data['wechar']             = sqliteEscapeString(getGpc('wechar','string','P'));
            $data['marital']            = sqliteEscapeString(getGpc('marital','string','P'));
            $data['degree']             = sqliteEscapeString(getGpc('degree','string','P'));
            $data['school']             = sqliteEscapeString(getGpc('school','string','P'));
            $data['discipline']         = sqliteEscapeString(getGpc('discipline','string','P'));
            $data['graduation_time']    = sqliteEscapeString(getGpc('graduation_time','string','P'));
            $data['experience']         = sqliteEscapeString(getGpc('experience','string','P'));
            $data['readme']             = sqliteEscapeString(getGpc('readme','string','P'));
            $data['position_id']        = getGpc('position_id','integer','P');
            $data['add_time']           = time();
            $sql = insertTable(config('DB_TABLE_PRE').'resume',$data);
            if($db->exec($sql)){
                message('我们已收到你的申请，稍后会有客服与你联系',$_SERVER['HTTP_REFERER'],3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            message('非法操作',config('SITE_INFO.siteurl'),3);
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