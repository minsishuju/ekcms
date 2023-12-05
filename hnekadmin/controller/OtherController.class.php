<?php
class OtherController extends Controller {
    public function __construct(){
        parent::__construct();
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] == null ){
            message('请先登录','index.php?c=index&a=login',3);
        }
        $site_id = $_SESSION['site']['site_id'];
        $this->db = Mysql::connect();
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
    }
    
    public function guestbook(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'guestbook');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'guestbook order by guestbook_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function reply_guestbook(){
        if(IS_POST){
            $guestbook_id = getGpc('guestbook_id','integer','P');
            $data['is_show'] = getGpc('is_show','integer','P');
            $data['reply']   = sqliteEscapeString(getGpc('reply','string','P'));
            $sql = updateTable(config('DB_TABLE_PRE').'guestbook',$data,array('guestbook_id'=>$guestbook_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=other&a=guestbook',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $guestbook_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'guestbook where guestbook_id = ' . $guestbook_id);
            if(!$info){
                message('信息不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function delete_guestbook(){
        $guestbook_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'guestbook where guestbook_id = ' . $guestbook_id);
        if(!$info){
            message('信息不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'guestbook where guestbook_id = ' . $guestbook_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=other&a=guestbook',3);
        }else{
            message('操作失败','',3);
        }
    }
    
    public function bbs(){        
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'bbs where parent_id = 0 ');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from ' . config('DB_TABLE_PRE').'bbs where parent_id = 0 order by bbs_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();        
    }
      
    public function bbs_show(){
        $bbs_id = $_GET['id'];
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'bbs where parent_id = ' .  $bbs_id);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $info  = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'bbs where bbs_id = ' . $bbs_id );
        $list  = $this->db->getAll('select * from ' . config('DB_TABLE_PRE').'bbs where parent_id = ' . $bbs_id . ' order by bbs_id  asc  limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('info',$info);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function change(){
        $bbs_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'bbs where bbs_id = ' . $bbs_id);
        if(!$info){
            message('信息不存在','',3);
        }
        $sql = 'update ' . config('DB_TABLE_PRE').'bbs set is_show = 1 where bbs_id = ' . $bbs_id;
        if($this->db->exec($sql)){          
			message('操作成功','index.php?c=other&a=bbs',3);
        }else{
            message('操作失败','',3);
        }
    }
    
    public function delete_bbs(){
        $bbs_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'bbs where bbs_id = ' . $bbs_id);
        if(!$info){
            message('信息不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'bbs where bbs_id = ' . $bbs_id . ' or parent_id = ' . $bbs_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=other&a=bbs',3);
        }else{
            message('操作失败','',3);
        }
    }
    
    public function talent(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'job_position ');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'job_position order by position_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        foreach($list as &$vo){
            $resume_list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'resume where position_id = ' . $vo['position_id']);
            $vo['resume_num'] = count($resume_list);
            $vo['resume_today_num'] = 0;
            foreach($resume_list as $v){
                if(date('Y-m-d',$v['add_time']) == date('Y-m-d')){
                    $vo['resume_today_num']++;
                }
            }
        }
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function add_job_position(){
        if(IS_POST){
            $data['name']           = sqliteEscapeString(getGpc('name','string','P'));
            $data['type']           = sqliteEscapeString(getGpc('type','string','P'));
            $data['address']        = sqliteEscapeString(getGpc('address','string','P'));
            $data['number']         = sqliteEscapeString(getGpc('number','string','P'));
            $data['status']         = getGpc('status','integer','P');
            $data['duties']         = sqliteEscapeString(getGpc('duties','string','P'));
            $data['claim']          = sqliteEscapeString(getGpc('claim','string','P'));
            $data['update_time']    = time();
            $data['add_time']       = time();
            
            if(trim($data['name']) == ''){
                message('职位名称不能为空','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'job_position',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=other&a=talent',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }
    
    public function edit_job_position(){
        if(IS_POST){
            $position_id = getGpc('position_id','integer','P');
            $data['name']           = sqliteEscapeString(getGpc('name','string','P'));
            $data['type']           = sqliteEscapeString(getGpc('type','string','P'));
            $data['address']        = sqliteEscapeString(getGpc('address','string','P'));
            $data['number']         = sqliteEscapeString(getGpc('number','string','P'));
            $data['status']         = getGpc('status','integer','P');
            $data['duties']         = sqliteEscapeString(getGpc('duties','string','P'));
            $data['claim']          = sqliteEscapeString(getGpc('claim','string','P'));
            $data['update_time']    = time();
            
            if(trim($data['name']) == ''){
                message('职位名称不能为空','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'job_position',$data,array('position_id'=>$position_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=other&a=talent',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $position_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'job_position where position_id = ' . $position_id);
            if(!$info){
                message('招聘职位不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function update_job(){
        $position_id = getGpc('position_id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'job_position where position_id = ' . $position_id);
        if(!$info){
            message('信息不存在','',3);
        }
        $data['update_time'] = time();
        $sql = updateTable(config('DB_TABLE_PRE').'job_position',$data,array('position_id'=>$position_id));
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=other&a=talent',3);
        }else{
            message('操作失败','',3);
        }
    }
    
    public function delete_job_position(){
        $position_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'job_position where position_id = ' . $position_id);
        if(!$info){
            message('信息不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'job_position where position_id = ' . $position_id;
        if($this->db->exec($sql)){
            $this->db->exec('delete from ' . config('DB_TABLE_PRE').'resume where position_id = ' . $position_id);
            message('操作成功','index.php?c=other&a=talent',3);
        }else{
            message('操作失败','',3);
        }
    }
    
    public function list_resume(){
        $position_id = getGpc('position_id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'job_position where position_id = ' . $position_id);
        if(!$info){
            message('信息不存在','',3);
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'resume where position_id = ' . $position_id);
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'resume where position_id = ' . $position_id . ' order by resume_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->assign('info',$info);
        $this->display();
    }
    
    public function view_resume(){
        if(IS_POST){
            $resume_id = getGpc('resume_id','integer','P');
            $data['mark'] = sqliteEscapeString(getGpc('mark','string','P'));
            $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'resume where resume_id = ' . $resume_id);
            if(!$info){
                message('信息不存在','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'resume',$data,array('resume_id'=>$resume_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=other&a=list_resume&position_id=' . $info['position_id'],3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $resume_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select r.*,p.name as job_name from ' . config('DB_TABLE_PRE').'resume r left join ' . config('DB_TABLE_PRE').'job_position p on p.position_id = r.position_id where r.resume_id = ' . $resume_id);
            if(!$info){
                message('信息不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function delete_resume(){
        $resume_id = getGpc('id','integer','G');
        $info = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'resume where resume_id = ' . $resume_id);
        if(!$info){
            message('信息不存在','',3);
        }
        $sql = 'delete from ' . config('DB_TABLE_PRE').'resume where resume_id = ' . $resume_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=other&a=list_resume&position_id=' . $info['position_id'],3);
        }else{
            message('操作失败','',3);
        }
    }
}
?>