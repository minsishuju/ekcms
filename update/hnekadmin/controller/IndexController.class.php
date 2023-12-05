<?php
class IndexController extends Controller {
    public function __construct(){
        parent::__construct();
        if((!isset($_SESSION['admin']) || $_SESSION['admin'] == null ) && ACTION_NAME != 'login'){
            if(ACTION_NAME == 'index'){
                message('','index.php?c=index&a=login',0);
            }else{
                message('请先登录','index.php?c=index&a=login',3);
            }
        }
    }
    
    public function login(){
        if(isset($_SESSION['admin']) || $_SESSION['admin'] != null ){
            message('','index.php?c=index&a=index',0);
        }
        if(IS_POST){
            $username = getGpc('username','string','P');
            $password = getGpc('password','string','P');
            $checkcode = getGpc('checkcode','string','P');
            if($_SESSION['checkcode'] == '' || strtolower($checkcode) != strtolower($_SESSION['checkcode'])){
                message('验证码错误','index.php?c=index&a=login',3);
            }
            if($username == ''){
                message('请输入用户名','index.php?c=index&a=login',3);
            }
            if($password == ''){
                message('请输入密码','index.php?c=index&a=login',3);
            }
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin where user_name = "' . $username . '"');
            if($info){
                if($info['isvalid'] == 0){
                    message('该账号已被禁用','index.php?c=index&a=login',3);
                }
                if(md5($password) == $info['password']){
                    $_SESSION['checkcode'] = '';
                    if($info['is_master'] == 1){
                        $site = $db->getOne('select site_id,siteurl,name from '.config('DB_TABLE_PRE').'site where admin_id = "' . $info['admin_id'] . '"');
                    }else{
                        $site_id = $db->getOne('select site_id from '.config('DB_TABLE_PRE').'admin_site where admin_id = "' . $info['admin_id'] . '"');
                        $site = $db->getOne('select site_id,siteurl,name from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id['site_id'] . '"');
                    }
                    $ip = getIp();
                    $db->exec('update '.config('DB_TABLE_PRE').'admin set ip_address = "'. $ip .'",last_login_time = "'.date('Y-m-d H:i:s').'" where admin_id = "' . $info['admin_id'] . '"');
                    
                    $_SESSION['admin'] = 1;
                    $_SESSION['admin_id'] = $info['admin_id'];
                    $_SESSION['is_master'] = $info['is_master'];
                    $_SESSION['ip_address'] = $info['ip_address'];
                    $_SESSION['last_login_time'] = $info['last_login_time'];
                    $_SESSION['nickname'] = $info['nickname'];
                    $_SESSION['site'] = $site;
                    message('登陆成功','index.php?c=index&a=index',3);
                } else {
                    message('密码错误','index.php?c=index&a=login',3);
                }
            } else {
                message('用户不存在','index.php?c=index&a=login',3);
            }
        }else{
            $this->display();
        }
    }
    
    public function change(){
        $site_id = getGpc('site_id','integer','G');
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $_SESSION['admin_id'] . '"');
        if($info['is_master'] == 1){
            $site = $db->getOne('select site_id,siteurl,name from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '" and admin_id = "' . $info['admin_id'] . '"');
        }else{
            $site_id = $db->getOne('select site_id from '.config('DB_TABLE_PRE').'admin_site where admin_id = "' . $info['admin_id'] . '"');
            $site = $db->getOne('select site_id,siteurl,name from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id['site_id'] . '"');
        }
        $_SESSION['site'] = $site;
        message('','index.php?c=content',0);
    }
    
    public function logout(){
        $_SESSION = null;
        session_unset();
        session_destroy();
        header('Location: index.php?c=index&a=login');
    }
    
    public function info(){
        if(IS_POST){
            $nickname = getGpc('nickname','string','P');
            if($nickname == ''){
                message('请输入账号昵称','index.php?c=index&a=info',3);
            }
            $db = Mysql::connect();
            $info = $db->exec('update '.config('DB_TABLE_PRE').'admin set nickname = "'. $nickname .'" where admin_id = "' . $_SESSION['admin_id'] . '"');
            if($info){
                message('保存成功','index.php?c=index&a=info',3);
            } else {
                message('操作失败','index.php?c=index&a=info',3);
            }
        }else{
            $db = Mysql::connect();
            $info = $db->getOne('select admin_id,nickname,user_name,isvalid,ip_address from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $_SESSION['admin_id'] . '"');
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function resetpd(){
        if(IS_POST){
            $oldPw = getGpc('oldPw','string','P');
            $newPw = getGpc('newPw','string','P');
            $regPw = getGpc('regPw','string','P');
            if($newPw == ''){
                message('密码不能为空','index.php?c=index&a=resetpd',3);
            }
            if($newPw != $regPw){
                message('两次密码输入不一致','index.php?c=index&a=resetpd',3);
            }
            $db = Mysql::connect();
            $info = $db->getOne('select password from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $_SESSION['admin_id'] . '"');
            if(md5($oldPw) == $info['password']){
                $info = $db->exec('update '.config('DB_TABLE_PRE').'admin set password = "'. md5($newPw) .'" where admin_id = "' . $_SESSION['admin_id'] . '"');
                if($info){
                    message('修改成功','index.php?c=index&a=resetpd',3);
                } else {
                    message('修改失败','index.php?c=index&a=resetpd',3);
                }
            } else {
                message('密码输入错误','index.php?c=index&a=resetpd',3);
            }
        }else{
            $this->display();
        }
    }
    
    public function site(){
        $where = ' 1 = 1 ';
        $type = getGpc('type','integer','P');
        $name = getGpc('name','string','P');
        switch($type){
            case 1 :
                $where .= ' and site_id = ' . intval($name);
                break;
            case 2 :
                $where .= ' and name like "%' . $name . '%"';
                break;
            case 3 :
                $where .= ' and siteurl like "%' . $name . '%"';
                break;
        }
        $db = Mysql::connect();
		
        if($_SESSION['is_master'] == 1){
            $info  = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'site where ' . $where . ' and admin_id = ' . $_SESSION['admin_id']);
            $count = $info['count_num'];
            $Page  = new Page($count,15);
            $show  = $Page->show();
            $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'site where ' . $where . ' and admin_id = "' . $_SESSION['admin_id'] . '" order by site_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        }else{
            $r_site_id = $db->getOne('select site_id from '.config('DB_TABLE_PRE').'admin_site where admin_id = "' . $_SESSION['admin_id'] . '"');
            $site_id = $r_site_id['site_id'];
		
            $info  = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'site where ' . $where . ' and site_id = ' . $site_id);
            $count = $info['count_num'];
            $Page  = new Page($count,15);
            $show  = $Page->show();
            $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'site where ' . $where . ' and site_id = "' . $site_id . '" order by site_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        }
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function site_edit(){
        if(IS_POST){
            $site_id = getGpc('site_id','integer','P');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
            if($info){
                $data['name'] = escapeString(getGpc('name','string','P'));
                $data['site_title'] = escapeString(getGpc('site_title','string','P'));
                $data['phone'] = escapeString(getGpc('phone','string','P'));
                $data['contacts'] = escapeString(getGpc('contacts','string','P'));
                $data['keywords'] = escapeString(getGpc('keywords','string','P'));
                $data['hotwords'] = escapeString(getGpc('hotwords','string','P'));
                $data['description'] = escapeString(getGpc('description','string','P'));
                $data['status'] = getGpc('status','integer','P');
                $data['site_code'] = escapeString(getGpc('site_code','string','P'));
                $data['mb_site_code'] = escapeString(getGpc('mb_site_code','string','P'));
                $data['telphone'] = escapeString(getGpc('telphone','string','P'));
                $data['qq'] = escapeString(getGpc('qq','string','P'));
                $data['address'] = escapeString(getGpc('address','string','P'));
                $data['icp'] = escapeString(getGpc('icp','string','P'));
                $data['fax'] = escapeString(getGpc('fax','string','P'));
                $data['email'] = escapeString(getGpc('email','string','P'));
                $data['mb_address'] = escapeString(getGpc('mb_address','string','P'));
                $data['guard'] = getGpc('guard','integer','P');
                $data['white_list'] =str_replace('，',',',escapeString(getGpc('white_list','string','P')));
                $where = array('site_id'=>$site_id);
                $sql = updateTable(config('DB_TABLE_PRE').'site',$data,$where);
                $info = $db->exec($sql);
                if($info){
                    $guard['white_list']=explode(',',$data['white_list']);
                    $guard['guard']=$data['guard'];
                    writeFile(FW_PATH.'/common/safeguard.php',"<?php\nreturn ".var_export($guard,true)."\n?>");

                    message('修改成功','index.php?c=index&a=site',3);
                } else {
                    message('修改失败','index.php?c=index&a=site',3);
                }
            } else {
                message('站点不存在','index.php?c=index&a=site',3);
            }
        }else{
            $site_id = getGpc('id','integer','G');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
            if ($info) {
                $this->assign('info',$info);
                $this->display();
            } else {
                message('站点不存在','index.php?c=index&a=site',3);
            }
        }
    }
	/*2017/9/8 批量上传信息到数据中心*/
    public function update_ad(){
        
            $site_id = getGpc('id','integer','G');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
            if($info){
                $Content  = new ContentController();
				$rows=$Content->select_ad();
				$res['cont']=json_encode($rows);
				$data=$Content->send_cont_index('ad',$res,'upinsert',$site_id);
				$data = json_decode($data,true);
				
				if($data['result']==true)
				{
					message('小程序广告更新成功','index.php?c=index&a=site',3);
				}
				else
				{
					
					message('更新失败','index.php?c=index&a=site',3);
				}
            } else {
                message('站点不存在','index.php?c=index&a=site',3);
            }
        
    }
	public function update_page(){
        
            $site_id = getGpc('id','integer','G');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
            if($info){
                $Content  = new ContentController();
				$rows=$Content->select_page();
				$res['cont']=json_encode($rows);
				$data=$Content->send_cont_index('page',$res,'upinsert',$site_id);
				$data = json_decode($data,true);
				if($data['result']=='true')
				{
					
					message('小程序单页更新成功','index.php?c=index&a=site',3);
				}
				else
				{
					
					message('更新失败','index.php?c=index&a=site',3);
				}
            } else {
                message('站点不存在','index.php?c=index&a=site',3);
            }
        
    }
	public function update_category(){
        
            $site_id = getGpc('id','integer','G');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
            if($info){
                $Content  = new ContentController();
				$rows=$Content->select_category();
				$res['cont']=json_encode($rows);
				$data=$Content->send_cont_index('category',$res,'upinsert',$site_id);
				$data = json_decode($data,true);
				
				if($data['result']=='true')
				{
					message('小程序分类更新成功','index.php?c=index&a=site',3);
				}
				else
				{
					message('更新失败','index.php?c=index&a=site',3);
				}
            } else {
                message('站点不存在','index.php?c=index&a=site',3);
            }
        
    }
	public function update_content(){
        
            $site_id = getGpc('id','integer','G');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
            if($info){
                $Content  = new ContentController();
				$rows=$Content->select_content();
				$res['cont']=json_encode($rows);
				$data=$Content->send_cont_index('content',$res,'upinsert',$site_id);
				$data = json_decode($data,true);
				
				if($data['result']=='true')
				{
					message('小程序文章更新成功','index.php?c=index&a=site',3);
				}
				else
				{
					message('更新失败','index.php?c=index&a=site',3);
				}
            } else {
                message('站点不存在','index.php?c=index&a=site',3);
            }
        
    }
	/*2017/9/8 批量上传信息到数据中心*/
    public function site_open(){
        $site_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
        if ($info) {
            $where = array('site_id'=>$site_id);
            $data = array('status'=>1);
            $sql = updateTable(config('DB_TABLE_PRE').'site',$data,$where);
            $info = $db->exec($sql);
            if($info){
                message('操作成功','index.php?c=index&a=site',3);
            } else {
                message('操作失败','index.php?c=index&a=site',3);
            }
        } else {
            message('站点不存在','index.php?c=index&a=site',3);
        }
    }
    
    public function site_close(){
        $site_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
        if ($info) {
            $where = array('site_id'=>$site_id);
            $data = array('status'=>0);
            $sql = updateTable(config('DB_TABLE_PRE').'site',$data,$where);
            $info = $db->exec($sql);
            if($info){
                message('操作成功','index.php?c=index&a=site',3);
            } else {
                message('操作失败','index.php?c=index&a=site',3);
            }
        } else {
            message('站点不存在','index.php?c=index&a=site',3);
        }
    }
    
    public function admin(){
        if($_SESSION['is_master'] != 1){
            message('没有权限','index.php?c=index&a=default',3);
        }
        $db = Mysql::connect();
        $sites  = $db->getAll('select * from '.config('DB_TABLE_PRE').'site where admin_id = "' . $_SESSION['admin_id'] . '"');
        $site_ids = array();
        foreach($sites as $site){
            $site_ids[] = $site['site_id'];
        }
        $admin = $db->getAll('select * from '.config('DB_TABLE_PRE').'admin_site where site_id in (' . implode(',',$site_ids) . ') ');
        $admin_ids = array();
        foreach($admin as $a){
            $admin_ids[] = $a['admin_id'];
        }
        $admin_ids[] = $_SESSION['admin_id'];
        $admin_ids = array_filter($admin_ids);
        $admin_ids = array_unique($admin_ids);
        $info  = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'admin where admin_id in (' . implode(',',$admin_ids) . ')');
        $count = $info['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'admin where admin_id in (' . implode(',',$admin_ids) . ') order by admin_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function admin_add(){
        if($_SESSION['is_master'] != 1){
            message('没有权限','index.php?c=index&a=default',3);
        }
        if(IS_POST){
            $db = Mysql::connect();
            $data = array();
            $data['user_name'] = getGpc('user_name','string','P');
            if($data['user_name'] == ''){
                message('账号不能为空','index.php?c=index&a=admin',3);
            }
            $data['nickname'] = getGpc('nickname','string','P');
            $newPw = getGpc('newPw','string','P');
            $regPw = getGpc('regPw','string','P');
            if($newPw == ''){
                message('密码不能为空','index.php?c=index&a=admin',3);
            }else{
                if($newPw != $regPw){
                    message('两次密码输入不一致','index.php?c=index&a=admin',3);
                }
                $data['password'] = md5($newPw);
            }
            $data['isvalid'] = getGpc('isvalid','integer','P');
            $data['add_time'] = date('Y-m-d H:i:s');
            $data['last_login_time'] = date('Y-m-d H:i:s');
            $data['ip_address'] = getIp();
            $data['is_master'] = 0;
            $sql = insertTable(config('DB_TABLE_PRE').'admin',$data);
            if($db->exec($sql)){
                $admin_id = $db->insertId();
                $site_id = getGpc('site_id','integer','P');
                $sql = insertTable(config('DB_TABLE_PRE').'admin_site',array('admin_id'=>$admin_id,'site_id'=>$site_id));
                $db->exec($sql);
                message('操作成功','index.php?c=index&a=admin',3);
            } else {
                message('操作失败','index.php?c=index&a=admin',3);
            }

        }else{
            $db = Mysql::connect();
            $sites  = $db->getAll('select * from '.config('DB_TABLE_PRE').'site where admin_id = "' . $_SESSION['admin_id'] . '"');
            $this->assign('sites',$sites);
            $this->display();
        }
    }
    
    public function admin_edit(){
        if($_SESSION['is_master'] != 1){
            message('没有权限','index.php?c=index&a=default',3);
        }
        if(IS_POST){
            $admin_id = getGpc('admin_id','integer','P');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $admin_id . '"');
            if (!$info) {
                message('账号不存在','index.php?c=index&a=admin',3);
            }
            $data = array();
            $data['user_name'] = getGpc('user_name','string','P');
            if($data['user_name'] == ''){
                message('账号不能为空','index.php?c=index&a=admin',3);
            }
            $data['nickname'] = getGpc('nickname','string','P');
            $newPw = getGpc('newPw','string','P');
            $regPw = getGpc('regPw','string','P');
            if($newPw != ''){
                if($newPw != $regPw){
                    message('两次密码输入不一致','index.php?c=index&a=admin',3);
                }
                $data['password'] = md5($newPw);
            }
            if($info['is_master'] != 1){
                $data['isvalid'] = getGpc('isvalid','integer','P');
            }
            $sql = updateTable(config('DB_TABLE_PRE').'admin',$data,array('admin_id'=>$admin_id));
            if($db->exec($sql)){
                if($info['is_master'] != 1){
                    $site_id = getGpc('site_id','integer','P');
                    $site = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin_site where admin_id = "' . $admin_id . '"');
                    if($site_id != $site['site_id']){
                        $sql = updateTable(config('DB_TABLE_PRE').'admin_site',array('site_id'=>$site_id),array('rele_id'=>$site['rele_id']));
                        $db->exec($sql);
                    }
                }
                message('操作成功','index.php?c=index&a=admin',3);
            } else {
                message('操作失败','index.php?c=index&a=admin',3);
            }
        }else{
            $admin_id = getGpc('id','integer','G');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $admin_id . '"');
            if ($info) {
                $site = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin_site where admin_id = "' . $admin_id . '"');
                $info['site_id'] = $site['site_id'];
                $this->assign('info',$info);
            } else {
                message('账号不存在','index.php?c=index&a=admin',3);
            }
            $sites  = $db->getAll('select * from '.config('DB_TABLE_PRE').'site where admin_id = "' . $_SESSION['admin_id'] . '"');
            $this->assign('sites',$sites);
            $this->display();
        }
    }
    
    public function admin_open(){
        if($_SESSION['is_master'] != 1){
            message('没有权限','index.php?c=index&a=default',3);
        }
        $admin_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $admin_id . '"');
        if ($info) {
            $where = array('admin_id'=>$admin_id);
            $data = array('isvalid'=>1);
            $sql = updateTable(config('DB_TABLE_PRE').'admin',$data,$where);
            $info = $db->exec($sql);
            if($info){
                message('操作成功','index.php?c=index&a=admin',3);
            } else {
                message('操作失败','index.php?c=index&a=admin',3);
            }
        } else {
            message('账号不存在','index.php?c=index&a=admin',3);
        }
    }
    
    public function admin_close(){
        if($_SESSION['is_master'] != 1){
            message('没有权限','index.php?c=index&a=default',3);
        }
        $admin_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $admin_id . '"');
        if ($info) {
            if($info['is_master'] == 1){
                message('创始人账号不能禁用','index.php?c=index&a=admin',3);
            }
            $where = array('admin_id'=>$admin_id);
            $data = array('isvalid'=>0);
            $sql = updateTable(config('DB_TABLE_PRE').'admin',$data,$where);
            $info = $db->exec($sql);
            if($info){
                message('操作成功','index.php?c=index&a=admin',3);
            } else {
                message('操作失败','index.php?c=index&a=admin',3);
            }
        } else {
            message('账号不存在','index.php?c=index&a=admin',3);
        }
    }
    
    public function admin_delete(){
        if($_SESSION['is_master'] != 1){
            message('没有权限','index.php?c=index&a=default',3);
        }
        $admin_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $admin_id . '"');
        if ($info) {
            if($info['is_master'] == 1){
                message('创始人账号禁止删除','index.php?c=index&a=admin',3);
            }
            
            $sql = 'delete from ' . config('DB_TABLE_PRE').'admin where admin_id = "' . $admin_id . '"';
            $info = $db->exec($sql);
            if($info){
                $sql = 'delete from ' . config('DB_TABLE_PRE').'admin_site where admin_id = "' . $admin_id . '"';
                $db->exec($sql);
                message('操作成功','index.php?c=index&a=admin',3);
            } else {
                message('操作失败','index.php?c=index&a=admin',3);
            }
        } else {
            message('账号不存在','index.php?c=index&a=admin',3);
        }
    }
    
    public function keywords(){
        $db = Mysql::connect();
        $categorys = $db->getAll('select * from '.config('DB_TABLE_PRE').'keywords_category order by listorder asc,category_id desc ');
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'keywords order by keywords_id asc ');
        foreach($categorys as $category){
            $keywords[$category['category_id']] = $category;
        }
        foreach($list as $val){
            $keywords[$val['category_id']]['keywords'][] = $val;
        }
        $this->assign('keywords',$keywords);
        $this->display();
    }
    
    public function add_keywords_category(){
        if(IS_POST){
            $db = Mysql::connect();
            $data['name']       = sqliteEscapeString(getGpc('name','string','P'));
            $data['need']       = escapeString(getGpc('need','integer','P'));
            $data['listorder']  = 99;
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'keywords_category where name = "' . $data['name'] . '"');
            if($info){
                message('关键词分类已存在','',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'keywords_category',$data);
            if($db->exec($sql)){
                message('操作成功','index.php?c=index&a=keywords',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $this->display();
        }
    }
    
    public function edit_keywords_category(){
        if(IS_POST){
            $category_id  = getGpc('category_id','integer','P');
            $data['name'] = sqliteEscapeString(getGpc('name','string','P'));
            $data['need'] = escapeString(getGpc('need','integer','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'keywords_category where category_id != ' . $category_id . ' and name = "' . $data['name'] . '"');
            if($info){
                message('关键词分类已存在','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'keywords_category',$data,array('category_id'=>$category_id));
            if($db->exec($sql)){
                message('操作成功','index.php?c=index&a=keywords',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $category_id  = getGpc('category_id','integer','G');
            $db = Mysql::connect();
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'keywords_category where category_id = ' . $category_id );
            if(!$info){
                message('关键词标签不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function delete_keywords_category(){
        $category_id = getGpc('id','integer','G');
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'keywords_category where category_id = "' . $category_id . '"');
        if(!$info){
            message('关键词不存在','index.php?c=index&a=keywords',3);
        }
        $sql = 'delete from '.config('DB_TABLE_PRE').'keywords_category where category_id = '.$category_id;
        if($db->exec($sql)){
            $db->exec('delete from '.config('DB_TABLE_PRE').'keywords where category_id = '.$category_id);
            message('操作成功','index.php?c=index&a=keywords',3);
        }else{
            message('操作失败，请稍后再试','index.php?c=index&a=keywords',3);
        }
    }
    
    public function keywords_listorder(){
        $category_id = getGpc('category_id','integer','P');
        $listorder   = getGpc('listorder','integer','P');
        $db = Mysql::connect();
        $sql = updateTable(config('DB_TABLE_PRE').'keywords_category',array('listorder'=>$listorder),array('category_id'=>$category_id));
        if($db->exec($sql)){
            $this->ajaxReturn(array('status'=>1,'category_id'=>$category_id));
        }else{
            $this->ajaxReturn(array('status'=>0,'category_id'=>$category_id));
        }
    }
    
    public function add_keywords(){
        $data['name']        = escapeString(getGpc('name','string','P'));
        $data['category_id'] = getGpc('category_id','integer','P');
        $return = array('status'=>0,'keywords'=>iStripslashes($data['name']));
        if(trim($data['name']) == ''){
            $return['msg'] = '关键词不能为空';
            $this->ajaxReturn($return);
        }
        $db = Mysql::connect();
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'keywords_category where category_id = "' . $data['category_id'] . '"');
        if(!$info){
            $return['msg'] = '关键词分类不存在';
            $this->ajaxReturn($return);
        }
        $sql = insertTable(config('DB_TABLE_PRE').'keywords',$data);
        if($db->exec($sql)){
            $return['keywords_id'] = $db->insertId();
            $return['status'] = 1;
            $return['msg']    = '操作成功';
            $this->ajaxReturn($return);
        }else{
            $return['msg']    = '操作失败，请稍后再试';
            $this->ajaxReturn($return);
        }
    }
    
    public function edit_keywords(){
        if(IS_POST){
            $db = Mysql::connect();
            $keywords_id  = getGpc('keywords_id','integer','P');
            $data['name'] = escapeString(getGpc('name','string','P'));
            if(trim($data['name']) == ''){
                message('名称不能为空','',3);
            }
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'keywords where keywords_id != ' . $keywords_id . ' and name = "' . $data['name'] . '"');
            if($info){
                message('关键词已存在','',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'keywords',$data,array('keywords_id'=>$keywords_id));
            if($db->exec($sql)){
                message('操作成功','index.php?c=index&a=keywords',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $db = Mysql::connect();
            $keywords_id  = getGpc('keywords_id','integer','G');
            $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'keywords where keywords_id = ' . $keywords_id );
            if(!$info){
                message('关键词不存在','',3);
            }
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function delete_keywords(){
        $keywords_id = getGpc('keywords_id','integer','G');
        $return = array('status'=>0);
        $db = Mysql::connect();
        $sql = 'delete from '.config('DB_TABLE_PRE').'keywords where keywords_id = '.$keywords_id;
        if($db->exec($sql)){
            $return['status'] = 1;
            $return['msg']    = '操作成功';
            $this->ajaxReturn($return);
        }else{
            $return['msg'] = '操作失败，请稍后再试';
            $this->ajaxReturn($return);
        }
    }
    
    public function bdsort(){
        $db = Mysql::connect();
        $categorys = $db->getAll('select * from '.config('DB_TABLE_PRE').'keywords_category order by listorder asc,category_id desc ');
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'keywords order by keywords_id asc ');
        foreach($categorys as $category){
            $keywords[$category['category_id']] = $category;
        }
        foreach($list as $val){
            $keywords[$val['category_id']]['keywords'][] = $val;
        }
        $num = 1;
        foreach($keywords as $key=>$keyword){
            $c_key_num = count($keyword['keywords']);
            if($c_key_num == 0){
                continue;
            }
            
            if($keyword['need'] == 1){
                $num = $num * $c_key_num;
            }else{
                $num = $num * ($c_key_num + 1);
                array_unshift($keyword['keywords'],array('name'=>''));
            }
            $keyword_array[] = $keyword;
        }
        $keywords = array();
        $this->counter = array();
        $this->counterIndex = count($keyword_array) - 1;
        for($i = 0;$i < $num;$i++){
            $name = '';
            foreach($keyword_array as $k=>$keyword){
                $key = intval($this->counter[$k]);
                $name .= $keyword['keywords'][$key]['name'];
            }
            $keywords[] = $name;
            $this->handle($keyword_array);
        }
        $bdsortnum = 0;
        $mbdsortnum = 0;
        $lmsortnum = 0;
        $sgsortnum = 0;
        $true_num = 0;
        $dir = ROOT_PATH . 'cache/keywords/';
        makeDir($dir);
        foreach($keywords as &$keyword){
            $fliename = md5($keyword);
            if(is_file($dir.$fliename)){
                $info = unserialize(iReadFile($dir.$fliename));
                $info['new'] = json_decode($info['new'],true);
                $info['old'] = json_decode($info['old'],true);
                $true_num ++ ;
                $bdsortnum += ($info['new']['bd'] < 20);
                if($info['new']['bd'] && $info['new']['bd'] !='重试' && $info['old']['bd'] && $info['old']['bd'] !='重试'){
                    $info['new']['bd_sort'] = $info['new']['bd'] <= $info['old']['bd'] ? 'up' : 'down';
                }
                $mbdsortnum += ($info['new']['mbd'] < 20);
                if($info['new']['mbd'] && $info['new']['mbd'] !='重试' && $info['old']['mbd'] && $info['old']['mbd'] !='重试'){
                    $info['new']['mbd_sort'] = $info['new']['mbd'] <= $info['old']['mbd'] ? 'up' : 'down';
                }
                $lmsortnum += ($info['new']['lm'] < 20);
                if($info['new']['lm'] && $info['new']['lm'] !='重试' && $info['old']['lm'] && $info['old']['lm'] !='重试'){
                    $info['new']['lm_sort'] = $info['new']['lm'] <= $info['old']['lm'] ? 'up' : 'down';
                }
                $sgsortnum += ($info['new']['sg'] < 20);
                if($info['new']['sg'] && $info['new']['sg'] !='重试' && $info['old']['sg'] && $info['old']['sg'] !='重试'){
                    $info['new']['sg_sort'] = $info['new']['sg'] <= $info['old']['sg'] ? 'up' : 'down';
                }
            }else{
                $info = array('old'=>'','new'=>'');
            }
            $new_file[] = $fliename;
            $keywords_array[] = array('name'=>$keyword,'info'=>$info['new']);
        }
        foreach(feadDir($dir) as $file){
            if(!in_array($file,$new_file)){
                @unlink($dir.$file);
            }
        }
        $this->assign('keywords',$keywords_array);
        $this->assign('true_num',$true_num);
        $this->assign('bdsortnum',$bdsortnum);
        $this->assign('mbdsortnum',$mbdsortnum);
        $this->assign('lmsortnum',$lmsortnum);
        $this->assign('sgsortnum',$sgsortnum);
        $this->display();
    }
    
    public function getsort(){
        header('Content-Type:application/json; charset=utf-8');
        $num    = getGpc('num','integer','G');
        $name   = trim(getGpc('name','string','G'));
        $return = array('num'=>$num,'bd'=>'重试','mbd'=>'重试','lm'=>'重试','sg'=>'重试');
        $dir = ROOT_PATH . 'cache/keywords/';
        $fliename = md5($name);
        $url = substr($_SERVER['HTTP_HOST'],0,20);
        if(is_file($dir.$url.'/'.$fliename) && ((@filemtime($dir.$url.'/'.$fliename) + 7*24*60*60) > time())){
            $info = unserialize(iReadFile($dir.$url.'/'.$fliename));
            $info['new'] = json_decode($info['new'],true);
            $info['old'] = json_decode($info['old'],true);
            if($info['new']['bd'] && $info['new']['bd'] !='重试' && $info['old']['bd'] && $info['old']['bd'] !='重试'){
                $info['new']['bd_sort'] = $info['new']['bd'] <= $info['old']['bd'] ? 'up' : 'down';
            }
            if($info['new']['mbd'] && $info['new']['mbd'] !='重试' && $info['old']['mbd'] && $info['old']['mbd'] !='重试'){
                $info['new']['mbd_sort'] = $info['new']['mbd'] <= $info['old']['mbd'] ? 'up' : 'down';
            }
            if($info['new']['lm'] && $info['new']['lm'] !='重试' && $info['old']['lm'] && $info['old']['lm'] !='重试'){
                $info['new']['lm_sort'] = $info['new']['lm'] <= $info['old']['lm'] ? 'up' : 'down';
            }
            if($info['new']['sg'] && $info['new']['sg'] !='重试' && $info['old']['sg'] && $info['old']['sg'] !='重试'){
                $info['new']['sg_sort'] = $info['new']['sg'] <= $info['old']['sg'] ? 'up' : 'down';
            }
            $return['bd'] = $info['new']['bd'];
            $return['bd_sort'] = $info['new']['bd_sort'];
            $return['mbd'] = $info['new']['mbd'];
            $return['mbd_sort'] = $info['new']['mbd_sort'];
            $return['lm'] = $info['new']['lm'];
            $return['lm_sort'] = $info['new']['lm_sort'];
            $return['sg'] = $info['new']['sg'];
            $return['sg_sort'] = $info['new']['sg_sort'];
            exit(json_encode($return));
        }else{
            $http = new Http;
            $new_return = $http->get('http://youhua.ekew.net/index.php?num='.$num . '&name='.urlencode($name) . '&url=' . urlencode($url));
            if($new_return){
                $info = is_file($dir.$url.'/'.$fliename) ? unserialize(iReadFile($dir.$url.'/'.$fliename)) :array('old'=>'','new'=>'');
                $info['old'] = $info['new'];
                $info['new'] = $new_return;
                makeDir($dir.$url.'/');
                writeFile($dir.$url.'/'.$fliename,serialize($info));
                exit($new_return);
            }else{
                exit(json_encode($return));
            }
        }
        
        /*
        $url_s = array(
            'bd'=>'https://www.baidu.com/s?wd=' . $name . '&pn=[page]0',
            'mbd'=>'https://m.baidu.com/s?word=' . $name . '&pn=[page]0',
            'lm'=>'https://www.so.com/s?q=' . $name . '&pn=[page]',
            'sg'=>'http://www.sogou.com/web?query=' . $name . '&page=[page]'
        );
        for($i = 0;$i < 10;$i++){
            $urls = array();
            foreach($url_s as $key=>$url){
                $urls[$key] = str_replace('[page]',$i,$url);
            }
            if(empty($urls)) break;
            $data = $http->multi_get($urls,true);
            foreach($data as $key=>$html){
                $function = 'get'.$key.'sort';
                if($sort = $this->$function($html,$i)){
                    $return[$key] = $sort;
                    unset($url_s[$key]);
                }
            }
        }
        $this->ajaxReturn($return);
        */
    }
    
    private function getbdsort($html,$i){
        $string = '/<div class="result c-container.*?id="([0-9]+)".*?class="c-showurl.*?>(.*?)<\/a>/s';
        preg_match_all($string,$html,$rs);
        $url = substr($_SERVER['HTTP_HOST'],0,20);
        if(count($rs[0]) == 0){
            return '重试';
        }
        foreach($rs[2] as $key=>$val){
            $val = strip_tags($val);
            if(stripos($val,$url) !== false && $i != 0 && $key != 0){
                return $i*10 + $key + 1;
            }
        }
        return 0;
    }
    
    private function getmbdsort($html,$i){
        $string = '/<div class="result c-result.*?\'order\':\'([0-9]+)\'.*?class="c-showurl.*?<span>(.*?)<\/span>/s';
        preg_match_all($string,$html,$rs);
        $url = substr($_SERVER['HTTP_HOST'],0,20);
        if(count($rs[0]) == 0){
            return '重试';
        }
        foreach($rs[2] as $key=>$val){
            $val = strip_tags($val);
            if(stripos($val,$url) !== false && $i != 0 && $key != 0){
                return $i*10 + $key + 1;
            }
        }
        return $sort;
    }
    
    private function getlmsort($html,$i){
        $string = '/<li .*?class="res-list">.*?"pos":([0-9]+),.*?<cite>(.*?)<\/cite>/s';
        preg_match_all($string,$html,$rs);
        $url = substr($_SERVER['HTTP_HOST'],0,20);
        if(count($rs[0]) == 0){
            return '重试';
        }
        foreach($rs[2] as $key=>$val){
            $val = strip_tags($val);
            if(stripos($val,$url) !== false && $i != 0 && $key != 0){
                return $i*10 + $key + 1;
            }
        }
        return 0;
    }
    
    private function getsgsort($html,$i){
        $string = '/<cite id="cacheresult_info_([0-9]+)">(.*?)<\/cite>/s';
        preg_match_all($string,$html,$rs);
        $url = substr($_SERVER['HTTP_HOST'],0,20);
        if(count($rs[0]) == 0){
            return '重试';
        }
        foreach($rs[2] as $key=>$val){
            $val = strip_tags($val);
            if(stripos($val,$url) !== false && $i != 0 && $key != 0){
                return $i*10 + $key + 1;
            }
        }
        return 0;
    }
    
    private function handle($keyword_array){
        $this->counter[$this->counterIndex]++;
        if ($this->counter[$this->counterIndex] >= count($keyword_array[$this->counterIndex]['keywords'])){
            $this->counter[$this->counterIndex] = 0;  
            $this->counterIndex--;  
            if ($this->counterIndex >= 0) {  
                $this->handle($keyword_array);  
            }  
            $this->counterIndex = count($keyword_array) - 1;  
        }
    }
    
    public function preview(){
        $url = getGpc('url','string','G');
        $this->assign('url',$url);
        $this->display();
    }
    
    public function phone_preview(){
        $url = getGpc('url','string','G');
        $http = new Http;
        echo $http->get($url,true);
    }
    
    public function tips(){
        $this->ajaxReturn(array());
    }
}
?>