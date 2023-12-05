<?php
class BbsController extends ControllerContent {
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
    }

	public function index(){
		$db = Mysql::connect();
		$sql='select count(1) as count_num from '.config('DB_TABLE_PRE').'bbs where parent_id = 0 and is_show = 1';
		$count_num = $db->getOne($sql);
		$count = $count_num['count_num'];
		$Page  = new Page($count,6);
		$show  = $Page->show();
		$list  = $db->getAll('select * from ' . config('DB_TABLE_PRE').'bbs where parent_id = 0 and is_show = 1 order by bbs_id  asc  limit ' . $Page->firstRow . ',' . $Page->listRows);
		$SEO = seo('','论坛');
		$this->assign('SEO',$SEO);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display();
    }

	public function show(){
		$db = Mysql::connect();
		$bbs_id = getGpc('id','integer','G');
		$info  = $db->getOne('select * from ' . config('DB_TABLE_PRE').'bbs where bbs_id = ' . $bbs_id  );
		$sql='select count(1) as count_num from '.config('DB_TABLE_PRE').'bbs where parent_id = ' .  $bbs_id . ' and is_show = 1';
		$count_num = $db->getOne($sql);
		$count = $count_num['count_num'];
		$Page  = new Page($count,6);
		$show  = $Page->show();
		$list  = $db->getAll('select * from ' . config('DB_TABLE_PRE').'bbs where parent_id = ' . $bbs_id  . ' and is_show = 1 order by bbs_id  asc  limit ' . $Page->firstRow . ',' . $Page->listRows);
		$SEO = seo('','论坛');
		$this->assign('SEO',$SEO);
		$this->assign('info',$info);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display();
    }
    
    public function add(){
        if(IS_POST){
            $db = Mysql::connect();
            $data = array();
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            $data['title']  = sqliteEscapeString(getGpc('title','string','P'));
            $data['addtime']   = time();
			$data['ip']   = getIp();
			$data['parent_id']  = sqliteEscapeString(getGpc('parent_id','string','P'));
			$sql = insertTable(config('DB_TABLE_PRE').'bbs',$data);
            if($db->exec($sql)){
                message('我们已收到你的留言,请耐心等待审核',REQUEST_URI,3);
            }else{
                message('操作失败',REQUEST_URI,3);
            }
        }else{
            message('非法操作',REQUEST_URI,3);
        }
    }
}
?>