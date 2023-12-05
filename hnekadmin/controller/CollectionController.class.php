<?php
class CollectionController extends Controller {
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
    
    public function index(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'collection_node ');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'collection_node limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    public function add(){
        if(IS_POST) {
            $data = array();
			$data['name'] = sqliteEscapeString(getGpc('name','string','P'));
			$data['sourcecharset'] = sqliteEscapeString(getGpc('sourcecharset','string','P'));
			$data['sourcetype'] = sqliteEscapeString(getGpc('sourcetype','string','P'));
			$urlpage1 = sqliteEscapeString(getGpc('urlpage1','string','P'));
			$data['pagesize_start'] = sqliteEscapeString(getGpc('pagesize_start','string','P'));
			$data['pagesize_end'] = sqliteEscapeString(getGpc('pagesize_end','string','P'));
			$data['par_num'] = sqliteEscapeString(getGpc('par_num','string','P'));
			$urlpage2 = sqliteEscapeString(getGpc('urlpage2','string','P'));
			$data['url_contain'] = sqliteEscapeString(getGpc('url_contain','string','P'));
			$data['url_except'] = sqliteEscapeString(getGpc('url_except','string','P'));
			$data['page_base'] = sqliteEscapeString(getGpc('page_base','string','P'));
			$data['url_start'] = sqliteEscapeString(getGpc('url_start','string','P'));
			$data['url_end'] = sqliteEscapeString(getGpc('url_end','string','P'));
			$data['title_rule'] = sqliteEscapeString(getGpc('title_rule','string','P'));
			$data['title_html_rule'] = sqliteEscapeString(getGpc('title_html_rule','string','P'));
			$data['author_rule'] = sqliteEscapeString(getGpc('author_rule','string','P'));
			$data['author_html_rule'] = sqliteEscapeString(getGpc('author_html_rule','string','P'));
			$data['comeform_rule'] = sqliteEscapeString(getGpc('comeform_rule','string','P'));
			$data['comeform_html_rule'] = sqliteEscapeString(getGpc('comeform_html_rule','string','P'));
			$data['time_rule'] = sqliteEscapeString(getGpc('time_rule','string','P'));
			$data['time_html_rule'] = sqliteEscapeString(getGpc('time_html_rule','string','P'));
			$data['content_rule'] = sqliteEscapeString(getGpc('content_rule','string','P'));
			$data['content_html_rule'] = sqliteEscapeString(getGpc('content_html_rule','string','P'));
			$data['content_page_rule'] = sqliteEscapeString(getGpc('content_page_rule','string','P'));
			$data['content_nextpage'] = sqliteEscapeString(getGpc('content_nextpage','string','P'));
			$data['content_page_start'] = sqliteEscapeString(getGpc('content_page_start','string','P'));
			$data['content_html_add_start'] = sqliteEscapeString(getGpc('content_html_add_start','string','P'));
			$data['content_html_add_end'] = sqliteEscapeString(getGpc('content_html_add_end','string','P'));
			$data['content_page_end'] = sqliteEscapeString(getGpc('content_page_end','string','P'));
			if (!$data['name'] = trim($data['name'])) {
				message('请填写采集项目名', '',3);
			}
			if ($this->db->getOne('select * from '.config('DB_TABLE_PRE').'collection_node where name="' . $data['name'] . '"')) {
				message('采集项目名不能重复', '',3);
			}
			$data['urlpage'] = $data['sourcetype'] == 1 ? $urlpage1 : $urlpage2;
            $sql = insertTable(config('DB_TABLE_PRE').'collection_node',$data);
			if ($this->db->exec($sql)) {
				message('操作成功', 'index.php?c=collection',3);
			} else {
				message('操作失败', '',3);
			}
		} else {
			$this->display();
		}
    }
    
    public function edit() {
		
		if(IS_POST) {
			
            $node_id = getGpc('node_id','integer','P');
            $data = array();
			$data['name'] =  sqliteEscapeString(getGpc('name','string','P'));
			$data['sourcecharset'] =  sqliteEscapeString(getGpc('sourcecharset','string','P'));
			$data['sourcetype'] =  sqliteEscapeString(getGpc('sourcetype','string','P'));
			$urlpage1 =  sqliteEscapeString(getGpc('urlpage1','string','P'));
			$data['pagesize_start'] =  sqliteEscapeString(getGpc('pagesize_start','string','P'));
			$data['pagesize_end'] =  sqliteEscapeString(getGpc('pagesize_end','string','P'));
			$data['par_num'] =  sqliteEscapeString(getGpc('par_num','string','P'));
			$urlpage2 =  sqliteEscapeString(getGpc('urlpage2','string','P'));
			$data['url_contain'] =  sqliteEscapeString(getGpc('url_contain','string','P'));
			$data['url_except'] =  sqliteEscapeString(getGpc('url_except','string','P'));
			$data['page_base'] =  sqliteEscapeString(getGpc('page_base','string','P'));
			$data['url_start'] =  sqliteEscapeString(getGpc('url_start','string','P'));
			$data['url_end'] =  sqliteEscapeString(getGpc('url_end','string','P'));
			$data['title_rule'] =  sqliteEscapeString(getGpc('title_rule','string','P'));
			$data['title_html_rule'] =  sqliteEscapeString(getGpc('title_html_rule','string','P'));
			$data['author_rule'] =  sqliteEscapeString(getGpc('author_rule','string','P'));
			$data['author_html_rule'] =  sqliteEscapeString(getGpc('author_html_rule','string','P'));
			$data['comeform_rule'] =  sqliteEscapeString(getGpc('comeform_rule','string','P'));
			$data['comeform_html_rule'] =  sqliteEscapeString(getGpc('comeform_html_rule','string','P'));
			$data['time_rule'] =  sqliteEscapeString(getGpc('time_rule','string','P'));
			$data['time_html_rule'] =  sqliteEscapeString(getGpc('time_html_rule','string','P'));
			$data['content_rule'] =  sqliteEscapeString(getGpc('content_rule','string','P'));
			$data['content_html_rule'] =  sqliteEscapeString(getGpc('content_html_rule','string','P'));
			$data['content_page_rule'] =  sqliteEscapeString(getGpc('content_page_rule','string','P'));
			$data['content_nextpage'] =  sqliteEscapeString(getGpc('content_nextpage','string','P'));
			$data['content_page_start'] =  sqliteEscapeString(getGpc('content_page_start','string','P'));
			$data['content_html_add_start'] = sqliteEscapeString(getGpc('content_html_add_start','string','P'));
			$data['content_html_add_end'] = sqliteEscapeString(getGpc('content_html_add_end','string','P'));
			$data['content_page_end'] =  sqliteEscapeString(getGpc('content_page_end','string','P'));
			if (!$data['name'] = trim($data['name'])) {
				message('请填写采集项目名', '',3);
			}
			if ($this->db->getOne('select * from '.config('DB_TABLE_PRE').'collection_node where node_id != '.$node_id.' and name="' . $data['name'] . '"')) {
				message('采集项目名不能重复', '',3);
			}
			$data['urlpage'] = $data['sourcetype'] == 1 ? $urlpage1 : $urlpage2;
            $sql = updateTable(config('DB_TABLE_PRE').'collection_node',$data,array('node_id'=>$node_id));
			
			if ($this->db->exec($sql)) {
				message('操作成功', 'index.php?c=collection',3);
			} else {
				message('操作失败', '',3);
			}
		} else {
			$node_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'collection_node where node_id="' . $node_id . '"');
            $this->assign('info',$info);
			$this->display();
		}
	}
    
    public function delete(){
        $node_id = getGpc('id','integer','G');
        $sql = 'delete from '.config('DB_TABLE_PRE').'collection_node where node_id="' . $node_id . '"';
        if ($this->db->exec($sql)) {
            $sql = 'delete from '.config('DB_TABLE_PRE').'collection_history where node_id="' . $node_id . '"';
            $this->db->exec($sql);
            $sql = 'delete from '.config('DB_TABLE_PRE').'collection_content where node_id="' . $node_id . '"';
            $this->db->exec($sql);
            message('操作成功', 'index.php?c=collection',3);
        } else {
            message('操作失败', '',3);
        }
    }
    
    public function col_url_list() {
		$node_id = getGpc('id','integer','G');
		if ($data = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'collection_node where node_id="' . $node_id . '"')) {
			$urls = Collection::url_list($data);
			$total_page = count($urls);
			if ($total_page > 0) {
				$page = getGpc('page','integer','G');
				$url_list = $urls[$page];
				$url = Collection::get_url_lists($url_list, $data);
				$total = count($url);
				$re = 0;
				if (is_array($url) && !empty($url)) foreach ($url as $v) {
					if (empty($v['url']) || empty($v['title'])) continue;
					$v = iAddslashes($v);
					$v['title'] = strip_tags($v['title']);
					$md5 = md5($v['url']);
					if (!$this->db->getOne('select * from '.config('DB_TABLE_PRE').'collection_history where md5 = "'.$md5.'" and node_id="' . $node_id . '"')) {
						$sql = insertTable(config('DB_TABLE_PRE').'collection_history',array('node_id'=>$node_id,'md5'=>$md5));
                        $this->db->exec($sql);
                        $sql = insertTable(config('DB_TABLE_PRE').'collection_content',array('node_id'=>$node_id, 'status'=>0, 'url'=>$v['url'], 'title'=>$v['title']));
                        $this->db->exec($sql);
					} else {
						$re++;
					}
				}
				if ($total_page <= $page) {
                    $sql = updateTable(config('DB_TABLE_PRE').'collection_node',array('lastdate'=>time()), array('node_id'=>$node_id));
                    $this->db->exec($sql);
				}
                $this->assign('node_id',$node_id);
                $this->assign('url_list',$url_list);
                $this->assign('total',$total);
                $this->assign('total_page',$total_page);
                $this->assign('page',$page);
                $this->assign('next',$page+1);
                $this->assign('re',$re);
                $this->assign('unre',$total - $re);
                $this->assign('url',$url);
				$this->display();
			} else {
				message('未找到网址', '',3);
			}
		} else {
			message('未找到网址', '',3);
		}
	}
    public function col_content() {
		$node_id = getGpc('id','integer','G');
		if ($data = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'collection_node where node_id="' . $node_id . '"')) {
			$page = getGpc('page','integer','G');
            $total = getGpc('total','integer','G');
			if (!$total) {
                $total = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'collection_content where status = 0 and node_id="' . $node_id . '"');
                $total = $total['count_num'];
            }
			$total_page = ceil($total/2);
			$list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'collection_content where status = 0 and node_id="' . $node_id . '" limit 2 ');
			$i = 0;
            
			if (!empty($list) && is_array($list)) {
				foreach ($list as $v) {
					$html = Collection::get_content($v['url'], $data);
                    $sql = updateTable(config('DB_TABLE_PRE').'collection_content',array('status'=>1, 'data'=>sqliteEscapeString(serialize($html))),array('content_id'=>$v['content_id']));
                    $this->db->exec($sql);
					$i++;
				}
			} else {
				message('采集完成', 'index.php?c=collection',3);
			}
            
			if ($total_page > $page) {
                $next = $page+1;
                message('采集正在进行中，采集进度:'.($i+($page-1)*2).'/'.$total, 'index.php?c=collection&a=col_content&id='.$node_id . '&page=' . $next .'&total='.$total,0);
			} else {
                $sql = updateTable(config('DB_TABLE_PRE').'collection_node',array('lastdate'=>time()), array('node_id'=>$node_id));
                $this->db->exec($sql);
				message('采集完成', 'index.php?c=collection',3);
			}
		}
	}
    
    public function publist() {
		$node_id = getGpc('id','integer','G');
		$node = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'collection_node where node_id="' . $node_id . '"');
		$count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'collection_content where node_id="' . $node_id . '"');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'collection_content where node_id="' . $node_id . '" limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
	}
    
    public function content_del(){
        $content_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'collection_content where content_id="' . $content_id . '"');
        $sql = 'delete from '.config('DB_TABLE_PRE').'collection_content where content_id="' . $content_id . '"';
        if ($this->db->exec($sql)) {
            $md5 = md5($info['url']);
            $sql = 'delete from '.config('DB_TABLE_PRE').'collection_history where md5="' . $md5 . '"';
            $this->db->exec($sql);
            message('操作成功', '',3);
        } else {
            message('操作失败', '',3);
        }
    }
    
    public function move_content(){
        if(IS_POST){
            $ids = getGpc('ids','array','P');
            $is_delete = getGpc('is_delete','integer','P');
            $to_category_id   = getGpc('to_category_id','integer','P');
            $content_ids = array_map('intval',$ids);
            $content_ids = implode(',',$content_ids);
            if(empty($content_ids)){
                message('请选择操作内容', $_SERVER['HTTP_REFERER'] ,3);
            }
            if(!$list = $this->db->getAll('select * from ' . config('DB_TABLE_PRE').'collection_content where content_id in (' . $content_ids . ')')){
                message('请选择操作内容', $_SERVER['HTTP_REFERER'] ,3);
            }
            $i = 0;
            foreach ($list as $val){
                $val['data'] = unserialize($val['data']);
                $data = array();
                $data['category_id']    = $to_category_id;
                $data['title']          = sqliteEscapeString($val['data']['title']);
                $data['author']         = sqliteEscapeString($val['data']['author']);
                $data['copyfrom']       = sqliteEscapeString($val['data']['copyfrom']);
                $data['keywords']       = '';
                $data['description']    = '';
                $data['image']          = '';
                $data['content']        = sqliteEscapeString($val['data']['content']);
                $data['tags']           = ',,';
                $data['posids']         = ',,';
                $data['relation']       = '';
                $data['url']            = '';
                $data['tail_id']        = 0;
                $data['listorder']      = 99;
                $data['add_time']       = strtotime($val['title']['time']);
                $data['update_time']    = time();
                $data['hits']           = 45;
                $sql = insertTable(config('DB_TABLE_PRE').'content',$data);
                if($this->db->exec($sql)){
                    if($is_delete){
                        $sql = 'delete from '.config('DB_TABLE_PRE').'collection_content where content_id="' . $val['content_id'] . '"';
                        $this->db->exec($sql);
                        $md5 = md5($val['url']);
                        $sql = 'delete from '.config('DB_TABLE_PRE').'collection_history where md5="' . $md5 . '"';
                        $this->db->exec($sql);
                    }else{
                        $sql = updateTable(config('DB_TABLE_PRE').'collection_content',array('status'=>2),array('content_id'=>$val['content_id']));
                        $this->db->exec($sql);
                    }
                    $i++;
                }
            }
            if($i >0){
                $categoryobj = new ContentController;
                $categoryobj->cache_categorys();
                message('操作成功,本次成功导入'.$i.'条数据', $_SERVER['HTTP_REFERER'] ,3);
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
            $categoryobj = new ContentController;
            $list = $categoryobj->category_lists();
            $this->assign('list',$list);
            $this->assign('ids',$ids);
            $this->display();
        }
    }
}
?>