<?php
class MemberController extends Controller {
    private $db;
    
    public function __construct(){
        parent::__construct();
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] == null ){
            message('请先登录','index.php?c=index&a=login',3);
        }
        $site_id = $_SESSION['site']['site_id'];
        $this->db = Mysql::connect();
        $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
        $this->site_info = $info;
    }
    
    public function lists(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'member');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'member order by member_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function edit(){
        if(IS_POST){
            $member_id      = getGpc('member_id','integer','P');
            $data['name']   = escapeString(getGpc('name','string','P'));
            $data['email']  = escapeString(getGpc('email','string','P'));
            $data['phone']  = escapeString(getGpc('phone','string','P'));
            $data['status'] = getGpc('status','integer','P');
            $point  = getGpc('point','integer','P');
            $description  = getGpc('description','string','P');
            
            $info  = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $member_id);
            if(!$info){
                message('操作会员不存在','',3);
            }
            $password = getGpc('password','string','P');
            if($password != ''){
                $data['safe_code'] = substr(md5(time()),12,8);
                $data['password'] = md5(md5($password) . $data['safe_code']);
            }
            //数据校验
            $where = array('member_id'=>$member_id);
            $sql = updateTable(config('DB_TABLE_PRE').'member',$data,$where);
            if($this->db->exec($sql) !== false){
                if($point != 0){
                    $sql = 'update '.config('DB_TABLE_PRE').'member set point = point + ' . $point . ' where member_id = ' . $member_id;
                    if($this->db->exec($sql)){
                        $point_data = array();
                        $point_data['member_id'] = $member_id;
                        $point_data['point'] = $point;
                        $point_data['description'] = '系统管理员修改积分（'.$description.'）';
                        $point_data['add_time'] = time();
                        $sql = insertTable(config('DB_TABLE_PRE').'member_point_log',$point_data);
                        $this->db->exec($sql);
                    }
                }
                message('操作成功','index.php?c=member&a=lists',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $member_id = getGpc('id','integer','G');
            $info  = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $member_id);
            if(!$info){
                message('操作会员不存在','',3);
            }
            $address = $this->db->getAll('select a.*,p.region_name as province_name,c.region_name as city_name,d.region_name as district_name from '.config('DB_TABLE_PRE').'member_address a left join '.config('DB_TABLE_PRE').'region p on a.province = p.region_id left join '.config('DB_TABLE_PRE').'region c on a.city = c.region_id left join '.config('DB_TABLE_PRE').'region d on a.district = d.region_id where a.member_id = ' . $member_id);
            $point_log = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'member_point_log where member_id = ' . $member_id . ' order by add_time desc');
            $this->assign('address',$address);
            $this->assign('point_log',$point_log);
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function delete(){
        $member_id = getGpc('id','integer','G');
        $info  = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'member where member_id = ' . $member_id);
        if(!$info){
            message('操作会员不存在','',3);
        }
        if($this->db->exec('delete from ' . config('DB_TABLE_PRE') . 'member where member_id = ' .$member_id)){
            message('操作成功','index.php?c=member&a=lists',3);
        }else{
            message('操作失败','',3);
        }
    }
}
?>