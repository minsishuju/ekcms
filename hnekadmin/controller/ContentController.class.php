<?php
class ContentController extends Controller {
    private $db;
    private $site_info;

    public function __construct(){
        parent::__construct();
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] == null ){
            message('请先登录','index.php?c=index&a=login',3);
        }
        $site_id = $_SESSION['site']['site_id'];
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');

        $this->db = Sqlite::connect(SITE_PATH . 'data/' . $info['site_dir'] . 'db');
        $this->site_info = $info;
    }

    public function category(){
        $data = iReadFile(SITE_PATH .'data/'. $this->site_info['site_dir'] . 'cache/cache_categorys.txt');
        $list = json_decode($data,true);
        $contents = $this->db->getAll('select content_id,add_time,category_id from '.config('DB_TABLE_PRE').'content');
        $total = count($contents);
        foreach($contents as $content){
            $list[$content['category_id']]['num'] ++;
        }
        $this->assign('list',$list);
        $this->display();
    }

    public function add_category(){
        if(IS_POST){
            $data['parent_id']      = getGpc('parent_id','integer','P');
            $data['type_id']        = getGpc('type_id','integer','P');
            $data['model_id']       = $data['type_id'] == 1 || $data['type_id'] == 2 ? getGpc('model_id','integer','P') : 0;
            $data['name']           = sqliteEscapeString(getGpc('name','string','P'));
            $data['nickname']       = sqliteEscapeString(getGpc('nickname','string','P'));
            $data['url_name']       = sqliteEscapeString(getGpc('url_name','string','P'));
            $data['title']          = sqliteEscapeString(getGpc('title','string','P'));
            $data['image']          = sqliteEscapeString(getGpc('image','string','P'));
            $data['is_show']        = getGpc('is_show','integer','P');
            $data['keywords']       = sqliteEscapeString(getGpc('keywords','string','P'));
            $data['description']    = sqliteEscapeString(getGpc('description','string','P'));
            $data['list_template']  = sqliteEscapeString(getGpc('list_template','string','P'));
            $data['show_template']  = sqliteEscapeString(getGpc('show_template','string','P'));
            $data['url']            = $data['type_id'] == 4 ? sqliteEscapeString(getGpc('url','string','P')) : '';
            $data['listorder']      = 99;
            if(trim($data['name']) == ''){
                message('栏目名称不能为空','',3);
            }
            if(in_array($data['url_name'],array('core','data','hnekadmin','home','static')) || !preg_match('/^[a-zA-Z]+$/',$data['url_name'])){
                message('唯一标示格式不正确','',3);
            }
            if($this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where url_name = "'.$data['url_name'].'"')){
                message('唯一标示已存在','',3);
            }
            if($data['parent_id'] != 0){
                $parent_ids = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $data['parent_id']);
                $parent_ids = explode(',',$parent_ids['parent_ids']);
                $parent_ids[] = $data['parent_id'];
                $data['parent_ids'] = implode(',',$parent_ids);
            }else{
                $data['parent_ids'] = 0;
            }
            $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'content where category_id = ' . $data['parent_id']);
            if($count_num['count_num'] > 0){
                message('上级栏目为非空栏目，请先删除目标栏目下的内容','',3);
            }
            //数据校验
            $sql = insertTable(config('DB_TABLE_PRE').'category',$data);
            if($this->db->exec($sql)){
                $this->cache_categorys();
				$rows['id'] = $this->db->insertId();
				$data['cate_id']=$rows['id'];
				$result=$this->send_cont('category',$data,'insert');
                message('操作成功','index.php?c=content&a=category',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'category order by listorder asc,category_id asc');
            $list = $this->returntree($list);
            $list = $this->viewtree($list);
            $this->assign('list',$list);
            $list_temps = glob(SITE_PATH . 'data/' . $this->site_info['site_dir'] ."template/index/list*.html");
            $list_temps = $list_temps ? $list_temps : array();
            $list_wap_temps = glob(SITE_PATH . 'data/' . $this->site_info['site_dir'] ."template/wap/index/list*.html");
            $list_wap_temps = $list_wap_temps ? $list_wap_temps : array();
            $list_temps = array_unique(array_merge($list_temps,$list_wap_temps));
            foreach($list_temps as $val){
                $list_template[] = substr($val,strrpos($val,'/') + 1,-5);
            }
            $this->assign('list_template',$list_template);
            $show_temps = glob(SITE_PATH . 'data/' . $this->site_info['site_dir'] ."template/index/show*.html");
            $show_temps = $show_temps ? $show_temps : array();
            $show_wap_temps = glob(SITE_PATH . 'data/' . $this->site_info['site_dir'] ."template/wap/index/show*.html");
            $show_wap_temps = $show_wap_temps ? $show_wap_temps : array();
            $show_temps = array_unique(array_merge($show_temps,$show_wap_temps));
            foreach($show_temps as $val){
                $show_template[] = substr($val,strrpos($val,'/') + 1,-5);
            }
            $this->assign('show_template',$show_template);
            $models  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model ');
            $this->assign('models',$models);
            $this->display();
        }
    }

    public function edit_category(){
        if(IS_POST){
            $category_id            = getGpc('category_id','integer','P');
            $data['parent_id']      = getGpc('parent_id','integer','P');
            $data['type_id']        = getGpc('type_id','integer','P');
            $data['model_id']       = $data['type_id'] == 1 || $data['type_id'] == 2 ? getGpc('model_id','integer','P') : 0;
            $data['name']           = sqliteEscapeString(getGpc('name','string','P'));
            $data['nickname']       = sqliteEscapeString(getGpc('nickname','string','P'));
            $data['url_name']       = sqliteEscapeString(getGpc('url_name','string','P'));
            $data['title']          = sqliteEscapeString(getGpc('title','string','P'));
            $data['image']          = sqliteEscapeString(getGpc('image','string','P'));
            $data['is_show']        = getGpc('is_show','integer','P');
            $data['keywords']       = sqliteEscapeString(getGpc('keywords','string','P'));
            $data['description']    = sqliteEscapeString(getGpc('description','string','P'));
            $data['list_template']  = sqliteEscapeString(getGpc('list_template','string','P'));
            $data['show_template']  = sqliteEscapeString(getGpc('show_template','string','P'));
            $data['url']            = $data['type_id'] == 4 ? sqliteEscapeString(getGpc('url','string','P')) : '';

            if(trim($data['name']) == ''){
                message('栏目名称不能为空','',3);
            }
            if(trim($data['name']) == ''){
                message('栏目名称不能为空','',3);
            }
            if(in_array($data['url_name'],array('core','data','hnekadmin','home','static')) || !preg_match('/^[a-zA-Z]+$/',$data['url_name'])){
                message('唯一标示格式不正确','',3);
            }
            if($this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id <> ' . $category_id . ' and url_name = "'.$data['url_name'].'"')){
                message('唯一标示已存在','',3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $category_id . ' order by category_id asc limit 1');
            if($info['type_id'] != $data['type_id']){
                $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'content where category_id = ' . $category_id);
                if($count_num['count_num'] > 0){
                    message('当前栏目为非空栏目，请先删除当前栏目下的内容','',3);
                }
            }
            $parent_ids = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $data['parent_id']);
            $parent_ids = explode(',',$parent_ids['parent_ids']);
            if($data['parent_id'] == $category_id || in_array($category_id,$parent_ids)){
                message('不能移动到自己或自己下级栏目','',3);
            }
            $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'content where category_id = ' . $data['parent_id']);
            if($count_num['count_num'] > 0){
                message('目标栏目为非空栏目，请先删除目标栏目下的内容','',3);
            }
            //数据校验
            $where = array('category_id'=>$category_id);
            $sql = updateTable(config('DB_TABLE_PRE').'category',$data,$where);

            if($this->db->exec($sql)){
                if($data['parent_id'] != $info['parent_id'])
				{
                $this->update_parent_ids($category_id,$data['parent_id']);
				}
                $this->cache_categorys();
				$data['cate_id']=$category_id;
				$result=$this->send_cont('category',$data,'update');
                message('操作成功','index.php?c=content&a=category',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $category_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $category_id . ' order by category_id asc limit 1');
            if(!$info){
                message('操作栏目不存在','',3);
            }
            if($info['type_id'] == 1 || $info['type_id'] == 2){
                $content_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'content where category_id = ' . $category_id);
                $this->assign('content_num',$content_num['count_num']);
            }
            $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'category order by listorder asc,category_id asc');
            $list = $this->returntree($list);
            $list = $this->viewtree($list);
            $this->assign('list',$list);
            $this->assign('info',$info);
            $list_temps = glob(SITE_PATH . 'data/' . $this->site_info['site_dir'] ."template/index/list*.html");
            $list_temps = $list_temps ? $list_temps : array();
            $list_wap_temps = glob(SITE_PATH . 'data/' . $this->site_info['site_dir'] ."template/wap/index/list*.html");
            $list_wap_temps = $list_wap_temps ? $list_wap_temps : array();
            $list_temps = array_unique(array_merge($list_temps,$list_wap_temps));
            foreach($list_temps as $val){
                $list_template[] = substr($val,strrpos($val,'/') + 1,-5);
            }
            $this->assign('list_template',$list_template);
            $show_temps = glob(SITE_PATH . 'data/' . $this->site_info['site_dir'] ."template/index/show*.html");
            $show_temps = $show_temps ? $show_temps : array();
            $show_wap_temps = glob(SITE_PATH . 'data/' . $this->site_info['site_dir'] ."template/wap/index/show*.html");
            $show_wap_temps = $show_wap_temps ? $show_wap_temps : array();
            $show_temps = array_unique(array_merge($show_temps,$show_wap_temps));
            foreach($show_temps as $val){
                $show_template[] = substr($val,strrpos($val,'/') + 1,-5);
            }
            $this->assign('show_template',$show_template);
            $models  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model ');
            $this->assign('models',$models);
            $this->display();
        }
    }
	
	public function select_ad(){
		
		$info = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'ad ');
		return $info;
	}
		public function select_page(){
		
		$info = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'page ');
		return $info;
	}
	public function select_category(){
		$info = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'category ');
		return $info;
	}
	public function select_content(){
        $info = $this->db->getAll('select c.*,t.model_id,t.type_id from '.config('DB_TABLE_PRE').'content AS c LEFT JOIN '.config('DB_TABLE_PRE').'category AS t  ON c.category_id = t.category_id');
		foreach($info AS $key => $val)
		{
			if($val['model_id'] > '0')
			{
				$field = $this->db->getAll('select field from '.config('DB_TABLE_PRE').'model_field where model_id = '.$val['model_id']);
				foreach ($field as $key1 => $v) 
					{
						$field[$key1]=$v['field'];
					}
				$who = implode(",", $field);
				$model_data = $this->db->getAll('select '.$who.' from '.config('DB_TABLE_PRE').'model_data'.$val['model_id'] . ' where content_id = '.$val['content_id']);
				$model_rows = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model_field where model_id = ' . $val['model_id']);
				foreach ($model_data as $key2 => $vs) 
					{
						$model_data=$vs;
					}
				foreach ($model_rows as $vals) 
					{
						$rows[$vals['field']]=$vals['name'];
					}
				foreach ($model_data as $keys => $vala)
					{
						$row[$rows[$keys]]=$vala;
					}
				
				$info[$key]['model_files']=json_encode($row);
			}
			if($val['type_id'] == '2')
			{
				$field = $this->db->getAll('select image from '.config('DB_TABLE_PRE').'album where content_id = '.$val['content_id']);
				foreach ($field as $key1 => $v) 
					{
						$field[$key1]=$v['image'];
					}
				$info[$key]['image_files']=json_encode($field);
				
			}
		}
		return $info;
    }
    public function delete_category(){
        $category_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $category_id . ' order by category_id asc limit 1');
        if(!$info){
            message('操作栏目不存在','',3);
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'category where parent_id = ' . $category_id);
        if($count_num['count_num'] > 0){
            message('该栏目下还有子栏目，请先清空子栏目','',3);
        }
        if($info['type_id'] == 1 || $info['type_id'] == 2){
            $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'content where category_id = ' . $category_id);
            if($count_num['count_num'] > 0){
                message('当前栏目为非空栏目，请先删除当前栏目下的内容','',3);
            }
        }
        $return = $this->db->exec('delete from '.config('DB_TABLE_PRE').'category where category_id = ' . $category_id);
        if($return){
            if($info['type_id'] == 3){
                $this->db->exec('delete from '.config('DB_TABLE_PRE').'page where category_id = ' . $category_id);
            }
            $this->cache_categorys();
			$data['cate_id']=$category_id;
			$result=$this->send_cont('category',$data,'delete');
            message('操作成功','index.php?c=content&a=category',3);
        }else{
            message('操作失败','',3);
        }
    }

    public function category_listorder(){
        $category_id = getGpc('category_id','integer','P');
        $listorder   = getGpc('listorder','integer','P');
        $sql = updateTable(config('DB_TABLE_PRE').'category',array('listorder'=>$listorder),array('category_id'=>$category_id));
        if($this->db->exec($sql)){
            $this->cache_categorys();
			$data['cate_id']	=$category_id;
			$data['listorder']	=$listorder;
			$result=$this->send_cont('category',$data,'listorder');
            $this->ajaxReturn(array('status'=>1,'category_id'=>$category_id));
        }else{
            $this->ajaxReturn(array('status'=>0,'category_id'=>$category_id));
        }
    }

    public function update_categorys_cache(){
        $this->cache_categorys();
        message('操作成功','index.php?c=content&a=category',3);
    }

    public function move(){
        if(IS_POST){
            $category_id = getGpc('category_id','integer','P');
            $to_category_id   = getGpc('to_category_id','integer','P');
            $sql = updateTable(config('DB_TABLE_PRE').'content',array('category_id'=>$to_category_id),array('category_id'=>$category_id));
            if($this->db->exec($sql)){
                $this->cache_categorys();
				$data['category_id']=$category_id;
				$data['to_category_id']=$to_category_id;
				$result=$this->send_cont('content',$data,'move');
                message('操作成功','index.php?c=content&a=category',3);
            }else{
                message('操作失败','index.php?c=content&a=category',3);
            }
        }else{
            $category_id = getGpc('category_id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $category_id . ' order by category_id asc limit 1');
            if(!$info){
                message('操作栏目不存在','index.php?c=content&a=category',3);
            }
            $list = $this->category_lists();
            $this->assign('list',$list);
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function move_content(){
        if(IS_POST){
            $ids = getGpc('ids','array','P');
            $to_category_id   = getGpc('to_category_id','integer','P');
            $content_ids = array_map('intval',$ids);
            $content_ids = implode(',',$content_ids);
            if(empty($content_ids)){
                message('请选择操作内容', $_SERVER['HTTP_REFERER'] ,3);
            }
            if(!$this->db->getAll('select * from ' . config('DB_TABLE_PRE').'content where content_id in (' . $content_ids . ')')){
                message('请选择操作内容', $_SERVER['HTTP_REFERER'] ,3);
            }
            $where = ' content_id in (' . $content_ids . ')';
            $sql = updateTable(config('DB_TABLE_PRE').'content',array('category_id'=>$to_category_id),$where);
            if($this->db->exec($sql)){
                $this->cache_categorys();
				$data['content_ids']=$content_ids;
				$data['to_category_id']=$to_category_id;
				$result=$this->send_cont('content',$data,'move_content');
                message('操作成功', $_SERVER['HTTP_REFERER'] ,3);
            }else{
                message('操作失败', $_SERVER['HTTP_REFERER'] ,3);
            }
        }else{
            $ids = getGpc('ids','string','G');
            $ids = explode(',',$ids);
            $ids = array_map('intval',$ids);
            $content_ids = implode(',',$ids);
            if(empty($content_ids)){
                message('请选择操作内容', $_SERVER['HTTP_REFERER'] ,3);
            }
            if(!$content = $this->db->getOne('select * from ' . config('DB_TABLE_PRE') .'content where content_id in (' . $content_ids . ')')){
                message('请选择操作内容', $_SERVER['HTTP_REFERER'] ,3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $content['category_id'] . ' order by category_id asc limit 1');
            $list = $this->category_lists();
            $this->assign('list',$list);
            $this->assign('info',$info);
            $this->assign('ids',$ids);
            $this->display();
        }
    }

    public function counts(){
        $data = iReadFile(SITE_PATH .'data/'. $this->site_info['site_dir'] . 'cache/cache_categorys.txt');
        $list = json_decode($data,true);
        $contents = $this->db->getAll('select content_id,add_time,category_id from '.config('DB_TABLE_PRE').'content');
        $total = count($contents);
        $today = 0;
        $before_that = 0;
        $day_before = 0;
        $yesterday = 0;
        foreach($contents as $content){
            $list[$content['category_id']]['num'] ++;
            $time = strtotime(date('Y-m-d')) - $content['add_time'];
            if($time < 0){
                $list[$content['category_id']]['num_y'] ++;
                $today ++;
            }
            if($time >= 0 && $time < 24*60*60){
                $yesterday++;
            }
            if($time >= 24*60*60 && $time < 2*24*60*60){
                $day_before++;
            }
            if($time >= 2*24*60*60 && $time < 3*24*60*60){
                $before_that++;
            }
        }
        $this->assign('total',$total);
        $this->assign('before_that',$before_that);
        $this->assign('day_before',$day_before);
        $this->assign('yesterday',$yesterday);
        $this->assign('today',$today);
        $this->assign('list',$list);
        $this->display();
    }

    public function model(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'model ');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add_model(){
        if(IS_POST){
            $data['name']           = sqliteEscapeString(getGpc('name','string','P'));
            $data['description']    = sqliteEscapeString(getGpc('description','string','P'));
            $sql = insertTable(config('DB_TABLE_PRE').'model',$data);
            if($this->db->exec($sql)){
                $model_id = $this->db->insertId();
                $sql = 'DROP TABLE IF EXISTS '.config('DB_TABLE_PRE').'model_data' . $model_id;
                $this->db->exec($sql);
                $sql = 'CREATE TABLE IF NOT EXISTS "'.config('DB_TABLE_PRE').'model_data' . $model_id . '" ("data_id" INTEGER PRIMARY KEY  NOT NULL  UNIQUE , "content_id" INTEGER NOT NULL)';
                if($this->db->exec($sql)){
                    message('操作成功','index.php?c=Content&a=model',3);
                }else{
                    $sql = 'delete from '.config('DB_TABLE_PRE').'model where model_id = ' . $model_id;
                    $this->db->exec($sql);
                    message('操作失败',$_SERVER['HTTP_REFERER'],3);
                }
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $this->display();
        }
    }

    public function edit_model(){
        if(IS_POST){
            $model_id               = getGpc('model_id','integer','P');
            $data['name']           = sqliteEscapeString(getGpc('name','string','P'));
            $data['description']    = sqliteEscapeString(getGpc('description','string','P'));
            $sql = updateTable(config('DB_TABLE_PRE').'model',$data,array('model_id'=>$model_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=Content&a=model',3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $model_id = getGpc('id','integer','G');
            $model = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model where model_id = ' . $model_id);
            if(!$model){
                message('模型不存在','',3);
            }
            $this->assign('model',$model);
            $this->display();
        }
    }

    public function delete_model(){
        $model_id = getGpc('id','integer','G');
        $model = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model where model_id = ' . $model_id);
        if(!$model){
            message('模型不存在','',3);
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'category where model_id = ' . $model_id);
        if($count_num['count_num']){
            message('模型正在被使用中','',3);
        }
        $sql = 'delete from '.config('DB_TABLE_PRE').'model where model_id = ' . $model_id;
        if($this->db->exec($sql)){
            $sql = 'delete from '.config('DB_TABLE_PRE').'model_field where model_id = ' . $model_id;
            $this->db->exec($sql);
            $sql = 'DROP TABLE IF EXISTS '.config('DB_TABLE_PRE').'model_data' . $model_id;
            $this->db->exec($sql);
            message('操作成功','index.php?c=Content&a=model',3);
        }else{
            message('操作失败',$_SERVER['HTTP_REFERER'],3);
        }
    }

    public function model_field(){
        $model_id = getGpc('model_id','integer','G');
        $model = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model where model_id = ' . $model_id);
        if(!$model){
            message('模型不存在','',3);
        }
        $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model_field where is_delete = 0 and model_id = ' . $model_id);
        $this->assign('model',$model);
        $this->assign('list',$list);
        $this->display();
    }

    public function add_field(){
        if(IS_POST){
            $data['model_id']       = getGpc('model_id','integer','P');
            $data['name']           = sqliteEscapeString(getGpc('name','string','P'));
            $data['field']          = sqliteEscapeString(getGpc('field','string','P'));
            $data['type']           = sqliteEscapeString(getGpc('type','string','P'));
            $data['is_delete']      = 0;
            $model = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model where model_id = ' . $data['model_id']);
            if(!$model){
                message('模型不存在','',3);
            }
            if(!preg_match('/^[a-zA-Z]+$/',$data['field'])){
                message('字段名称格式不正确','',3);
            }
            if(in_array($data['field'],array('data_id','content_id', 'category_id','title','keywords','description', 'image', 'add_time', 'update_time', 'hits', 'content', 'listorder', 'tags', 'posids', 'url', 'author', 'copyfrom', 'relation', 'tail_id', 'wap_content'))){
                message('字段名称已存在','',3);
            }
            $field_info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model_field where model_id = ' . $data['model_id'] .' and field = "' . $data['field'] . '"');
            if($field_info){
                if($field_info['is_delete'] == 0){
                    message('字段名称已存在','',3);
                }else{
                    $sql = updateTable(config('DB_TABLE_PRE').'model_field',$data,array('field_id'=>$field_info['field_id']));
                    if($this->db->exec($sql)){
                        message('操作成功','index.php?c=Content&a=model_field&model_id='.$model['model_id'],3);
                    }else{
                        message('操作失败1',$_SERVER['HTTP_REFERER'],3);
                    }
                }
            }else{
                $sql = insertTable(config('DB_TABLE_PRE').'model_field',$data);
                if($this->db->exec($sql)){
                    $field_id = $this->db->insertId();
                    if($data['type'] == 'editor'){
                        $sql = 'ALTER TABLE '.config('DB_TABLE_PRE').'model_data'.$model['model_id'].' ADD COLUMN '.$data['field'].' TEXT DEFAULT (null)';
                    }else{
                        $sql = 'ALTER TABLE '.config('DB_TABLE_PRE').'model_data'.$model['model_id'].' ADD COLUMN '.$data['field'].' CHAR DEFAULT (null)';
                    }
                    if($this->db->exec($sql)){
                        message('操作成功','index.php?c=Content&a=model_field&model_id='.$model['model_id'],3);
                    }else{
                        $sql = 'delete from '.config('DB_TABLE_PRE').'model_field where field_id = ' . $field_id;
                        $this->db->exec($sql);
                        message('操作失败',$_SERVER['HTTP_REFERER'],3);
                    }
                }else{
                    message('操作失败',$_SERVER['HTTP_REFERER'],3);
                }
            }
        }else{
            $model_id = getGpc('model_id','integer','G');
            $model = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model where model_id = ' . $model_id);
            if(!$model){
                message('模型不存在','',3);
            }
            $this->assign('model',$model);
            $this->display();
        }
    }

    public function edit_field(){
        if(IS_POST){
            $field_id       = getGpc('field_id','integer','P');
            $data['name']           = sqliteEscapeString(getGpc('name','string','P'));
            $field = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model_field where is_delete = 0 and field_id = ' . $field_id);
            if(!$field){
                message('字段不存在','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'model_field',$data,array('field_id'=>$field_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=Content&a=model_field&model_id='.$field['model_id'],3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $field_id       = getGpc('id','integer','G');
            $field = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model_field where is_delete = 0 and field_id = ' . $field_id);
            if(!$field){
                message('字段不存在','',3);
            }
            $this->assign('field',$field);
            $this->display();
        }
    }

    public function delete_field(){
        $field_id       = getGpc('id','integer','G');
        $field = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model_field where is_delete = 0 and field_id = ' . $field_id);
        if(!$field){
            message('字段不存在','',3);
        }
        $sql = updateTable(config('DB_TABLE_PRE').'model_field',array('is_delete'=>1),array('field_id'=>$field_id));
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=Content&a=model_field&model_id='.$field['model_id'],3);
        }else{
            message('操作失败',$_SERVER['HTTP_REFERER'],3);
        }
    }

    public function lists(){
        $category_id = getGpc('id','integer','G');
        $category = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $category_id . ' order by category_id asc limit 1');
        if(!$category){
            message('操作栏目不存在','',3);
        }
        if($category['type_id'] == 4){
            message('外部链接栏目，禁止添加内容','',3);
        }
        $this->assign('category',$category);
        if($category['type_id'] == 3){
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'page where category_id = ' . $category_id);
            $this->assign('info',$info);
            $this->display('page_edit');
        }else{
            $child_category = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'category where parent_id = ' . $category_id);
            if($child_category['count_num'] > 0){
                message('非终极栏目，禁止添加内容','',3);
            }
            $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'content where category_id = ' . $category_id);
            $count = $count_num['count_num'];
            $Page  = new Page($count,15);
            $show  = $Page->show();
            $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'content where category_id = ' . $category_id . ' order by listorder asc,content_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
            foreach($list as &$val){
                $val['url'] = $val['url']? $val['url'] : $this->site_info['siteurl'] .$val['content_id'].'.html';
            }
            $this->assign('list',$list);
            $this->assign('page',$show);
            if($category['type_id'] == 2){
                $this->display('albums_list');
            }else{
                $this->display('article_list');
            }
        }
    }

    public function add(){
        if(IS_POST){
            $data['category_id']    = getGpc('category_id','integer','P');
            $data['title']          = sqliteEscapeString(getGpc('title','string','P'));
            $data['author']         = sqliteEscapeString(getGpc('author','string','P'));
            $data['copyfrom']       = sqliteEscapeString(getGpc('copyfrom','string','P'));
            $data['keywords']       = sqliteEscapeString(getGpc('keywords','string','P'));
            $data['description']    = sqliteEscapeString(getGpc('description','string','P'));
            $data['image']          = sqliteEscapeString(getGpc('image','string','P'));
            $data['content']        = sqliteEscapeString(getGpc('content','string','P'));
            $data['tags']           = ','.implode(',',getGpc('tags','array','P')).',';
            $data['posids']         = ','.implode(',',getGpc('posids','array','P')).',';
            $data['relation']       = implode(',',getGpc('ids','array','P'));
            $data['url']            = sqliteEscapeString(getGpc('url','string','P'));
            $data['tail_id']        = getGpc('tail_id','integer','P');
            $data['listorder']      = 99;
            $data['add_time']       = strtotime(getGpc('add_time','string','P'));
            $data['update_time']    = time();
            $data['hits']           = 45;
            $category = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $data['category_id']);
			$model_rows = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model_field where model_id = ' . $category['model_id']);
            if(!$category){
                message('找不到指定栏目',$_SERVER['HTTP_REFERER'],3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'content',$data);
            if($this->db->exec($sql)){
                $content_id = $this->db->insertId();
                if(($category['type_id'] == 1 || $category['type_id'] == 2) && $category['model_id'] != 0){
                    $model_data = getGpc('data','array','P');
                    $model_data = array_map('sqliteEscapeString',$model_data);
                    $model_data['content_id'] = $content_id;
                    $sql = insertTable(config('DB_TABLE_PRE').'model_data'.$category['model_id'],$model_data);
                    $this->db->exec($sql);
					foreach ($model_rows as $val) 
					{
						$rows[$val['field']]=$val['name'];
					}
					foreach ($model_data as $key => $val)
					{
						if($rows[$key]!='')
						{
							$row[$rows[$key]]=$val;
						}
					}
					
					$data['model_files']=json_encode($row);
					
                }
                if($category['type_id'] == 2){
                    $album = getGpc('album','array','P');
                    foreach($album as $v){
                        $save = array();
                        $save['content_id'] = $content_id;
                        $save['image']      = $v;
                        $sql = insertTable(config('DB_TABLE_PRE').'album',$save);
                        $this->db->exec($sql);
                    }
					$data['image_files']=json_encode($album);
                }
				$data['cont_id']=$content_id;
				$result=$this->send_cont('content',$data,'insert');
                message('操作成功','index.php?c=Content&a=lists&id='.$data['category_id'],3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $category_id = getGpc('id','integer','G');
            $category = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $category_id . ' order by category_id asc limit 1');
            if(!$category){
                message('操作栏目不存在','',3);
            }
            $this->assign('category',$category);
            $tags_categorys = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'tags_category order by category_id asc ');
            $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'tags order by tags_id asc ');
            $posids  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'posids order by posids_id asc ');
            foreach($tags_categorys as $tags_category){
                $tags[$tags_category['category_id']] = $tags_category;
            }
            foreach($list as $val){
                $tags[$val['category_id']]['tags'][] = $val;
            }
            $seo_tail = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'seo_tail order by tail_id asc ');
            $this->assign('posids',$posids);
            $this->assign('tags',$tags);
            $this->assign('seo_tail',$seo_tail);
            if(($category['type_id'] == 1 || $category['type_id'] == 2) && $category['model_id'] != 0){
                $fields = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model_field where is_delete = 0 and model_id = ' . $category['model_id']);
                $this->assign('fields',$fields);
            }
            if($category['type_id'] == 2){
                $this->display('albums_add');
            }else{
                $this->display('article_add');
            }
        }
    }

    public function edit(){
        if(IS_POST){
            $content_id    = getGpc('content_id','integer','P');
            $data['title']          = sqliteEscapeString(getGpc('title','string','P'));
            $data['author']         = sqliteEscapeString(getGpc('author','string','P'));
            $data['copyfrom']       = sqliteEscapeString(getGpc('copyfrom','string','P'));
            $data['keywords']       = sqliteEscapeString(getGpc('keywords','string','P'));
            $data['description']    = sqliteEscapeString(getGpc('description','string','P'));
            $data['image']          = sqliteEscapeString(getGpc('image','string','P'));
            $data['content']        = sqliteEscapeString(getGpc('content','string','P'));
            $data['tags']           = ','.implode(',',getGpc('tags','array','P')).',';
            $data['posids']         = ','.implode(',',getGpc('posids','array','P')).',';
            $data['relation']       = implode(',',getGpc('ids','array','P'));
            $data['url']            = sqliteEscapeString(getGpc('url','string','P'));
            $data['tail_id']        = getGpc('tail_id','integer','P');
            $data['add_time']       = strtotime(getGpc('add_time','string','P'));
            $data['update_time']    = time();
            $where = array('content_id'=>$content_id);
            $content = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'content where content_id = ' . $content_id);
            if(!$content){
                message('内容不存在','',3);
            }
            $category = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $content['category_id']);
			$model_rows = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model_field where model_id = ' . $category['model_id']);
            $sql = updateTable(config('DB_TABLE_PRE').'content',$data,$where);
            if($this->db->exec($sql)){
                if(($category['type_id'] == 1 || $category['type_id'] == 2) && $category['model_id'] != 0){
                    $model_data = getGpc('data','array','P');
                    $model_data = array_map('sqliteEscapeString',$model_data);
                    if($this->db->getOne('select * from '.config('DB_TABLE_PRE').'model_data'.$category['model_id'].' where content_id = ' . $content_id)){
                        $sql = updateTable(config('DB_TABLE_PRE').'model_data'.$category['model_id'],$model_data,$where);
                    }else{
                        $model_data['content_id'] = $content_id;
                        $sql = insertTable(config('DB_TABLE_PRE').'model_data'.$category['model_id'],$model_data);
                        $this->db->exec($sql);
                    }
                    $this->db->exec($sql);
					foreach ($model_rows as $val) 
					{
						$rows[$val['field']]=$val['name'];
					}
					foreach ($model_data as $key => $val)
					{
						$row[$rows[$key]]=$val;
					}
					$data['model_files']=json_encode($row);
                }
                if($category['type_id'] == 2){
                    $albums = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'album where content_id = ' . $content_id);
                    $album = getGpc('album','array','P');
					$data['image_files']=json_encode($album);
                    foreach($albums as $v){
                        if(in_array($v['image'],$album)){
                            $key = array_keys($album,$v['image']);
                            unset($album[$key[0]]);
                        } else {
                            $this->db->exec('delete from '.config('DB_TABLE_PRE').'album where album_id = ' . $v['album_id']);
                        }
                    }
                    foreach($album as $v){
                        $save = array();
                        $save['content_id'] = $content_id;
                        $save['image']      = $v;
                        $sql = insertTable(config('DB_TABLE_PRE').'album',$save);
                        $this->db->exec($sql);
                    }
                }
				$data['cont_id']=$content_id;
				$result=$this->send_cont('content',$data,'update');
                message('操作成功','index.php?c=Content&a=lists&id='.$category['category_id'],3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $content_id = getGpc('id','integer','G');
            $content = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'content where content_id = ' . $content_id);
            if(!$content){
                message('内容不存在','',3);
            }
            $category = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $content['category_id']);
            $this->assign('category',$category);
            $content['tags'] = explode(',',substr($content['tags'],1,-1));
            $content['posids'] = explode(',',substr($content['posids'],1,-1));
            $this->assign('content',$content);
            if($content['relation']){
                $relation = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'content where content_id in ( ' . $content['relation'] . ' ) order by content_id asc ');
            }
            $this->assign('relation',$relation);
            $tags_categorys = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'tags_category order by category_id asc ');
            $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'tags order by tags_id asc ');
            $posids  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'posids order by posids_id asc ');
            foreach($tags_categorys as $tags_category){
                $tags[$tags_category['category_id']] = $tags_category;
            }
            foreach($list as $val){
                $tags[$val['category_id']]['tags'][] = $val;
            }
            $seo_tail = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'seo_tail order by tail_id asc ');
            $this->assign('posids',$posids);
            $this->assign('tags',$tags);
            $this->assign('seo_tail',$seo_tail);
            if(($category['type_id'] == 1 || $category['type_id'] == 2) && $category['model_id'] != 0){
                $fields = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'model_field where is_delete = 0 and model_id = ' . $category['model_id']);
                $this->assign('fields',$fields);
                $data = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'model_data'.$category['model_id'].' where content_id = ' . $content_id);
                $this->assign('data',$data);
            }
            if($category['type_id'] == 2){
                $albums = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'album where content_id = ' . $content['content_id']);
                $this->assign('albums',$albums);
                $this->display('albums_edit');
            }else{
                $this->display('article_edit');
            }
        }
    }

    public function delete(){
        $content_id = getGpc('id','integer','G');
        $content = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'content where content_id = ' . $content_id);
        if(!$content){
            message('内容不存在','',3);
        }
        $category = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $content['category_id']);
        $sql = 'delete from '.config('DB_TABLE_PRE').'content where content_id = ' . $content_id;
        if($this->db->exec($sql)){
            $sql = 'delete from '.config('DB_TABLE_PRE').'model_data'.$category['model_id'].' where content_id = ' . $content_id;
            $this->db->exec($sql);
            $sql = 'select * from '.config('DB_TABLE_PRE').'album where content_id = ' . $content_id;
            $albums = $this->db->getAll($sql);
            $album_ids = array();
            if($albums){
                foreach($albums as $v){
                    $album_ids[] = $v['album_id'];
                }
                $album_ids = implode(',',$album_ids);
                $sql = 'delete from '.config('DB_TABLE_PRE').'album where album_id in (' . $album_ids . ')';
                $this->db->exec($sql);
            }
			$data['cont_id']=$content_id;
			$result=$this->send_cont('content',$data,'delete');
            message('操作成功','index.php?c=Content&a=lists&id='.$content['category_id'],3);
        }else{
            message('操作失败',$_SERVER['HTTP_REFERER'],3);
        }
    }

    public function page_edit(){
        $category_id            = getGpc('category_id','integer','P');
        $data['title']          = sqliteEscapeString(getGpc('title','string','P'));
        $data['keywords']       = sqliteEscapeString(getGpc('keywords','string','P'));
        $data['description']    = sqliteEscapeString(getGpc('description','string','P'));
        $data['content']        = sqliteEscapeString(getGpc('content','string','P'));
        $data['wap_content']    = sqliteEscapeString(getGpc('wap_content','string','P'));
        $category = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where type_id = 3 and category_id = ' . $category_id);
        if(!$category){
            message('找不到指定栏目',$_SERVER['HTTP_REFERER'],3);
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'page where category_id = ' . $category_id);
        if($count_num['count_num'] == 0){
            $data['category_id'] = $category_id;
            $sql = insertTable(config('DB_TABLE_PRE').'page',$data);
			$operation='insert';
        }else{
            $where = array('category_id'=>$category_id);
			$data['category_id'] = $category_id;
            $sql = updateTable(config('DB_TABLE_PRE').'page',$data,$where);
			$operation='update';
        }
        if($this->db->exec($sql)){
			$data['p_id'] = $this->db->insertId();
			$result=$this->send_cont('page',$data,$operation);
            message('操作成功',$_SERVER['HTTP_REFERER'],3);
        }else{
            message('操作失败',$_SERVER['HTTP_REFERER'],3);
        }
    }

    public function listorder(){
        $content_id = getGpc('content_id','integer','P');
        $listorder   = getGpc('listorder','integer','P');
        $sql = updateTable(config('DB_TABLE_PRE').'content',array('listorder'=>$listorder),array('content_id'=>$content_id));
        if($this->db->exec($sql)){
			$data['cont_id']=$content_id;
			$data['listorder']=$listorder;
			$result=$this->send_cont('content',$data,'listorder');
            $this->ajaxReturn(array('status'=>1,'content_id'=>$content_id));
        }else{
            $this->ajaxReturn(array('status'=>0,'content_id'=>$content_id));
        }
    }

    public function relation(){
        $category_id = getGpc('category_id','integer','G');
        $name = sqliteEscapeString(getGpc('name','string','G'));
        $where = 'where 1=1 ';
        $category_ids = $this->get_children_category($category_id);
        $where .= ' and category_id in (' . implode(',',$category_ids) . ')';
        if($name != ''){
            $where .= ' and title like "%' . $name . '%" ';
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'content ' . $where);
        $count = $count_num['count_num'];
        $Page  = new Page($count,5);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'content ' . $where . ' order by listorder asc, content_id DESC limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $categorys = $this->category_lists();
        $this->assign('categorys',$categorys);
        $this->display();
    }

    public function region(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'region');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'region order by region_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add_region(){
        if(IS_POST){
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            $data['mark']       = sqliteEscapeString(getGpc('mark','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            if(!preg_match('/^[a-z]+$/',$data['mark'])){
                message('地区标示格式不正确','',3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $data['mark'] . '"');
            if($info){
                message('地区标示已存在','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'region',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=region',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }

    public function edit_region(){
        if(IS_POST){
            $region_id = getGpc('region_id','integer','P');
            $where = array('region_id'=>$region_id);
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            $data['mark']       = sqliteEscapeString(getGpc('mark','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            if(!preg_match('/^[a-z]+$/',$data['mark'])){
                message('地区标示格式不正确','',3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $data['mark'] . '" and region_id != ' . $region_id);
            if($info){
                message('地区标示已存在','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'region',$data,$where);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=region',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $region_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'region where region_id = ' . $region_id);
            if(!$info){
                message('操作分站不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function delete_region(){
        $region_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'region where region_id = ' . $region_id);
        if(!$info){
            message('操作分站不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'region where region_id = ' . $region_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=content&a=region',3);
        }else{
            message('操作失败','',3);
        }
    }

    public function images(){
        $db = Mysql::connect();
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'attachment order by add_time desc,attachment_id desc ');
        $count_num = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'attachment ');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'attachment order by add_time desc,attachment_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function images_delete(){
        $attachment_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'attachment where attachment_id = ' . $attachment_id);
        if(!$info){
            message('图片已删除','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'attachment where attachment_id = ' . $attachment_id;
        if($db->exec($sql)){
            @unlink(SITE_PATH . $info['path']);
            message('操作成功','index.php?c=content&a=images',3);
        }else{
            message('操作失败','',3);
        }
    }

    public function tags(){
        $categorys = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'tags_category order by category_id asc ');
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'tags order by tags_id asc ');
        foreach($categorys as $category){
            $tags[$category['category_id']] = $category;
        }
        foreach($list as $val){
            $tags[$val['category_id']]['tags'][] = $val;
        }
        $this->assign('tags',$tags);
        $this->display();
    }

    public function add_tags_category(){
        if(IS_POST){
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'tags_category where name = "' . $data['name'] . '"');
            if($info){
                message('标签分类已存在','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'tags_category',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=tags',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }

    public function edit_tags_category(){
        if(IS_POST){
            $category_id  = getGpc('category_id','integer','P');
            $data['name'] = sqliteEscapeString(getGpc('name','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'tags_category where category_id != ' . $category_id . ' and name = "' . $data['name'] . '"');
            if($info){
                message('标签分类已存在','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'tags_category',$data,array('category_id'=>$category_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=tags',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $category_id  = getGpc('category_id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'tags_category where category_id = ' . $category_id );
            if(!$info){
                message('分类标签不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function delete_tags_category(){
        $category_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'tags_category where category_id = "' . $category_id . '"');
        if(!$info){
            message('标签不存在','index.php?c=content&a=tags',3);
        }
        $sql = 'delete from '.config('DB_TABLE_PRE').'tags_category where category_id = '.$category_id;
        if($this->db->exec($sql)){
            $this->db->exec('delete from '.config('DB_TABLE_PRE').'tags where category_id = '.$category_id);
            message('操作成功','index.php?c=content&a=tags',3);
        }else{
            message('操作失败，请稍后再试','index.php?c=content&a=tags',3);
        }
    }

    public function add_tags(){
        $data['name']        = sqliteEscapeString(getGpc('name','string','P'));
        $data['category_id'] = getGpc('category_id','integer','P');
        $return = array('status'=>0,'tags_name'=>iStripslashes($data['name']));
        if(trim($data['name']) == ''){
            $return['msg'] = '名称不能为空';
            $this->ajaxReturn($return);
        }
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'tags_category where category_id = "' . $data['category_id'] . '"');
        if(!$info){
            $return['msg'] = '标签分类不存在';
            $this->ajaxReturn($return);
        }
        $sql = insertTable(config('DB_TABLE_PRE').'tags',$data);
        if($this->db->exec($sql)){
            $return['tags_id'] = $this->db->insertId();
            $return['status'] = 1;
            $return['msg']    = '操作成功';
            $this->ajaxReturn($return);
        }else{
            $return['msg']    = '操作失败，请稍后再试';
            $this->ajaxReturn($return);
        }
    }

    public function edit_tags(){
        if(IS_POST){
            $tags_id  = getGpc('tags_id','integer','P');
            $data['name'] = sqliteEscapeString(getGpc('name','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'tags where tags_id != ' . $tags_id . ' and name = "' . $data['name'] . '"');
            if($info){
                message('标签已存在','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'tags',$data,array('tags_id'=>$tags_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=tags',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $tags_id  = getGpc('tags_id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'tags where tags_id = ' . $tags_id );
            if(!$info){
                message('标签不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function delete_tags(){
        $tags_id = getGpc('tags_id','integer','G');
        $return = array('status'=>0);
        $sql = 'delete from '.config('DB_TABLE_PRE').'tags where tags_id = '.$tags_id;
        if($this->db->exec($sql)){
            $return['status'] = 1;
            $return['msg']    = '操作成功';
            $this->ajaxReturn($return);
        }else{
            $return['msg'] = '操作失败，请稍后再试';
            $this->ajaxReturn($return);
        }
    }

    public function posids(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'posids');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'posids order by posids_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add_posids(){
        if(IS_POST){
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'posids',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=posids',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }

    public function edit_posids(){
        if(IS_POST){
            $posids_id = getGpc('posids_id','integer','P');
            $where = array('posids_id'=>$posids_id);
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }

            $sql = updateTable(config('DB_TABLE_PRE').'posids',$data,$where);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=posids',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $posids_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'posids where posids_id = ' . $posids_id);
            if(!$info){
                message('操作推荐位不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function delete_posids(){
        $posids_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'posids where posids_id = ' . $posids_id);
        if(!$info){
            message('操作推荐位不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'posids where posids_id = ' . $posids_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=content&a=posids',3);
        }else{
            message('操作失败','',3);
        }
    }

    public function seotail(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'seo_tail');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'seo_tail order by tail_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add_seotail(){
        if(IS_POST){
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            $data['prefix']     = getGpc('prefix','integer','P');
            if(trim($data['name']) == ''){
                message('长尾词不能为空','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'seo_tail',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=seotail',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }

    public function edit_seotail(){
        if(IS_POST){
            $tail_id = getGpc('tail_id','integer','P');
            $where = array('tail_id'=>$tail_id);
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            $data['prefix']     = getGpc('prefix','integer','P');
            if(trim($data['name']) == ''){
                message('长尾词不能为空','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'seo_tail',$data,$where);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=seotail',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $tail_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'seo_tail where tail_id = ' . $tail_id);
            if(!$info){
                message('长尾词不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function delete_seotail(){
        $tail_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'seo_tail where tail_id = ' . $tail_id);
        if(!$info){
            message('长尾词不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'seo_tail where tail_id = ' . $tail_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=content&a=seotail',3);
        }else{
            message('操作失败','',3);
        }
    }

    public function links(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'links');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'links order by links_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add_links(){
        if(IS_POST){
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            $data['links_url']  = sqliteEscapeString(getGpc('links_url','string','P'));
            $data['image']      = sqliteEscapeString(getGpc('image','string','P'));
            $data['introduce']  = sqliteEscapeString(getGpc('introduce','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            if(trim($data['links_url']) == ''){
                message('链接地址不能为空','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'links',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=links',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }

    public function edit_links(){
        if(IS_POST){
            $links_id = getGpc('links_id','integer','P');
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            $data['links_url']  = sqliteEscapeString(getGpc('links_url','string','P'));
            $data['image']      = sqliteEscapeString(getGpc('image','string','P'));
            $data['introduce']  = sqliteEscapeString(getGpc('introduce','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            if(trim($data['links_url']) == ''){
                message('链接地址不能为空','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'links',$data,array('links_id'=>$links_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=links',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $links_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'links where links_id = ' . $links_id);
            if(!$info){
                message('友链不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function delete_links(){
        $links_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'links where links_id = ' . $links_id);
        if(!$info){
            message('友链不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'links where links_id = ' . $links_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=content&a=links',3);
        }else{
            message('操作失败','',3);
        }
    }

    public function ad(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'ad_space');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select '.config('DB_TABLE_PRE').'ad_space.*,count('.config('DB_TABLE_PRE').'ad.ad_id) as num from '.config('DB_TABLE_PRE').'ad_space left join '.config('DB_TABLE_PRE').'ad on '.config('DB_TABLE_PRE').'ad.space_id = '.config('DB_TABLE_PRE').'ad_space.space_id group by '.config('DB_TABLE_PRE').'ad_space.space_id order by '.config('DB_TABLE_PRE').'ad_space.space_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add_ad_space(){
        if(IS_POST){
            $data['name']        = sqliteEscapeString(getGpc('name','string','P'));
            $data['description'] = sqliteEscapeString(getGpc('description','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'ad_space',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=ad',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }

    public function edit_ad_space(){
        if(IS_POST){
            $space_id = getGpc('space_id','integer','P');
            $data['name']        = sqliteEscapeString(getGpc('name','string','P'));
            $data['description'] = sqliteEscapeString(getGpc('description','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'ad_space',$data,array('space_id'=>$space_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=content&a=ad',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $space_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'ad_space where space_id = ' . $space_id);
            if(!$info){
                message('版位不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function delete_ad_space(){
        $space_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'ad_space where space_id = ' . $space_id);
        if(!$info){
            message('版位不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'ad_space where space_id = ' . $space_id;
        if($this->db->exec($sql)){
            $sql = 'delete from ' . config('DB_TABLE_PRE').'ad where space_id = ' . $space_id;
            $this->db->exec($sql);
            message('操作成功','index.php?c=content&a=ad',3);
        }else{
            message('操作失败','',3);
        }
    }

    public function list_ad(){
        $space_id = getGpc('space_id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'ad_space where space_id = ' . $space_id);
        if(!$info){
            message('版位不存在','',3);
        }
        $this->assign('info',$info);
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'ad where space_id = ' . $space_id);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'ad where space_id = ' . $space_id . ' order by ad_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    public function add_ad(){
        if(IS_POST){
            $data['name'] = sqliteEscapeString(getGpc('name','string','P'));
            $data['link_url'] = sqliteEscapeString(getGpc('link_url','string','P'));
            $data['image'] = sqliteEscapeString(getGpc('image','string','P'));
            $data['space_id'] = sqliteEscapeString(getGpc('space_id','integer','P'));
            $data['alt'] = sqliteEscapeString(getGpc('alt','string','P'));
            $data['listorder'] = 99;
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'ad_space where space_id = ' . $data['space_id']);
            if(!$info){
                message('版位不存在','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'ad',$data);
			
            if($this->db->exec($sql)){
				$rows['id'] = $this->db->insertId();
				$data['a_id']=$rows['id'];
				$result=$this->send_cont('ad',$data,'insert');
                message('操作成功','index.php?c=content&a=list_ad&space_id=' . $data['space_id'],3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $space_id = getGpc('space_id','integer','G');
            $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'ad_space where space_id = ' . $space_id);
            if(!$info){
                message('版位不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function edit_ad(){
        if(IS_POST){
            $ad_id = getGpc('ad_id','integer','P');
            $data['name'] = sqliteEscapeString(getGpc('name','string','P'));
            $data['link_url'] = sqliteEscapeString(getGpc('link_url','string','P'));
            $data['image'] = sqliteEscapeString(getGpc('image','string','P'));
            $data['alt'] = sqliteEscapeString(getGpc('alt','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'ad where ad_id = ' . $ad_id);
            if(!$info){
                message('广告不存在','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'ad',$data,array('ad_id'=>$ad_id));
            if($this->db->exec($sql)){
				$data['a_id']=$ad_id;
				$result=$this->send_cont('ad',$data,'update');
                message('操作成功','index.php?c=content&a=list_ad&space_id=' . $info['space_id'],3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $ad_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select ' . config('DB_TABLE_PRE').'ad.*, ' . config('DB_TABLE_PRE').'ad_space.name as space_name from ' . config('DB_TABLE_PRE').'ad left join ' . config('DB_TABLE_PRE').'ad_space on '.config('DB_TABLE_PRE').'ad.space_id = '.config('DB_TABLE_PRE').'ad_space.space_id where ' . config('DB_TABLE_PRE').'ad.ad_id = ' . $ad_id);
            if(!$info){
                message('广告不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }
    public function ad_listorder(){
        $ad_id = getGpc('ad_id','integer','P');
        $listorder   = getGpc('listorder','integer','P');
		if($listorder > 0 AND $listorder <= 100)
		{
			$sql = updateTable(config('DB_TABLE_PRE').'ad',array('listorder'=>$listorder),array('ad_id'=>$ad_id));
			if($this->db->exec($sql)){
				$data['a_id']	=$ad_id;
				$data['listorder']	=$listorder;
				$result=$this->send_cont('ad',$data,'listorder');
				$this->ajaxReturn(array('status'=>1,'category_id'=>$ad_id));
			}else{
				$this->ajaxReturn(array('status'=>0,'category_id'=>$ad_id));
			}
		}
		else
		{
			$this->ajaxReturn(array('status'=>0,'category_id'=>$ad_id));
		}
    }
    public function delete_ad(){
        $ad_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'ad where ad_id = ' . $ad_id);
        if(!$info){
            message('广告不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'ad where ad_id = ' . $ad_id;
        if($this->db->exec($sql)){
			$data['a_id']	=$ad_id;
			$result=$this->send_cont('ad',$data,'delete');
            message('操作成功','index.php?c=content&a=list_ad&space_id=' . $info['space_id'],3);
        }else{
            message('操作失败','',3);
        }
    }

    public function category_lists(){
        $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'category order by listorder asc,category_id asc');
        $list = $this->returntree($list);
        $list = $this->viewtree($list);
        return $list;
    }

    public function cache_categorys(){
        $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'category order by listorder asc,category_id asc');
        $list = $this->returntree($list);
        $list = $this->viewtree($list);
        foreach($list as $category){
            $data[$category['category_id']] = $category;
        }
        foreach($list as $category){
            switch ($category['type_id']){
                case 1:
                case 2:
                    $category['url'] = $this->site_info['siteurl'];
                    $parent_ids = explode(',',$category['parent_ids']);
                    foreach($parent_ids as $parent_id){
                        if($parent_id != 0){
                            $category['url'] .= $data[$parent_id]['url_name'].'/';
                        }
                    }
                    $category['url'] .= $category['url_name'].'/';
                    break;
                case 3:
                    $category['url'] = $this->site_info['siteurl'] .$category['url_name'].'.html';
                    break;
                case 4:
                    $category['url'] = $category['url'];
                    break;
            }
            $data[$category['category_id']] = $category;
        }
        return writeFile(SITE_PATH .'data/'. $this->site_info['site_dir'] . 'cache/cache_categorys.txt',json_encode($data));
    }

    private function returntree($list){
        $tree = array();
        foreach($list as $val){
            if($val['parent_id'] == 0){
                $tree['child'][$val['category_id']]['info'] = $val;
            }else{
                $parent_ids = explode(',',$val['parent_ids']);
                unset($temp1);
                $temp = array();
                $temp1 = &$tree;
                foreach($parent_ids as $parent_id){
                    if($parent_id != 0){
                        $temp = &$temp1;
                        unset($temp1);
                        $temp1 = &$temp['child'][$parent_id];
                        unset($temp);
                    }
                }
                $temp1['child'][$val['category_id']]['info'] = $val;
            }
        }
        return $tree['child'];
    }

    private function viewtree($list,$i = 0){
        $tree = array();
        $i++;
        foreach($list as $val){
            $temp = $val['info'];
            $temp['stort'] = $i;
            $temp['child'] = isset($val['child']);
            $tree[] = $temp;
            if(isset($val['child'])){
                $tree = array_merge($tree,$this->viewtree($val['child'],$i));
            }
        }
        $i = 0;
        return $tree;
    }

    private function update_parent_ids($category_id,$parent_id){
        if($category_id == 0){
            return true;
        }
        $data = array();
        if($parent_id == 0){
            $data['parent_ids'] = 0;
        }else{
            $parent_ids = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'category where category_id = ' . $parent_id);
            $parent_ids = explode(',',$parent_ids['parent_ids']);
            $parent_ids[] = $parent_id;
            $data['parent_ids'] = implode(',',$parent_ids);
        }
        $where = array('category_id'=>$category_id);
        $sql = updateTable(config('DB_TABLE_PRE').'category',$data,$where);
        $this->db->exec($sql);
        $childs = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'category where parent_id = ' . $category_id);
        foreach($childs as $child){
            $this->update_parent_ids($child['category_id'],$category_id);
        }
        return true;
    }

    private function get_children_category($category_id){
        $info = $this->db->getAll('select category_id from ' . config('DB_TABLE_PRE') . 'category where parent_id = '.$category_id);
        foreach($info as $val){
            $category_ids[] = $val['category_id'];
        }
        unset($info);
        $category_ids = $category_ids ? $category_ids : array();
        $temp = array();
        $temps = array();
        foreach($category_ids as $child_category_id){
            $temp = $this->get_children_category($child_category_id);
            $temps = array_merge($temps,$temp);
        }
        $category_ids[] = $category_id;
        $category_ids = array_merge($category_ids,$temps);
        unset($temp);
        unset($temps);
        $category_ids = array_filter($category_ids);
        $category_ids = array_unique($category_ids);
        return $category_ids;
    }
	public function send_cont($t,$d,$w)
	{
		$db = Mysql::connect();
        $info = $db->getOne('select keyword from '.config('DB_TABLE_PRE').'site where site_id = "' . $_SESSION['site']['site_id'] . '"');
		if($info['keyword']!='')
		{
			$ur = 'https://www.huiying360.com.cn/hnekadmin/index.php?c=insevalue';
			$url=$ur .'&a=add_zz&t='.$t.'&k='.$info['keyword'].'&w='.$w;
			$Http  = new Http();
			$result = $Http->post($url,$d);
		}
		else
		{
			$result='';
		}
		return $result;
	}
	public function send_cont_index($t,$d,$w,$site_id)
	{
		$db = Mysql::connect();
        $info = $db->getOne('select keyword from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
		if($info['keyword']!='')
		{
		$ur = 'https://www.huiying360.com.cn/hnekadmin/index.php?c=insevalue';
		$url=$ur .'&a=add_zz&t='.$t.'&k='.$info['keyword'].'&w='.$w;
		$Http  = new Http();
		$result = $Http->post($url,$d);
		}
		else
		{
			$result='';
		}
		return $result;
	}
}
?>