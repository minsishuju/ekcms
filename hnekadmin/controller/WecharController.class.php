<?php
class WecharController extends Controller {
    private $db;
    private $site_info;
    
    public function __construct(){
        parent::__construct();
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] == null ){
            message('请先登录','index.php?c=index&a=login',3);
        }
        $site_id = $_SESSION['site']['site_id'];
        $this->db = Mysql::connect();
        $this->site_info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
        $weixin_config = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_config');
        if(!$weixin_config && ACTION_NAME != 'index'){
            $this->api();
            die;
        }
    }
    
    public function index(){
        $spread = file_get_contents('http://www.ekweixin.cn/spread/cmsx/index.html');
        $this->assign('spread',$spread);
        $this->display();
    }
    
    public function api(){
        if(IS_POST){
            $data = array();
            $config_id = getGpc('config_id','integer','P');
            $data['token'] = getGpc('token','string','P');
            $data['aeskey'] = getGpc('aeskey','string','P');
            $data['appid'] = getGpc('appid','string','P');
            $data['appsecret'] = getGpc('appsecret','string','P');
            if($config_id == 0){
                $sql = insertTable(config('DB_TABLE_PRE').'wechar_config',$data);
            }else{
                $sql = updateTable(config('DB_TABLE_PRE').'wechar_config',$data,array('config_id'=>$config_id));
            }
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=wechar&a=api',3);
            }else{
                message('操作失败','',3);
            }
        }else{
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_config');
            $this->assign('info',$info);
            $this->assign('site_info',$this->site_info);
            $this->display('api');
        }
    }
    
    public function member(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_member');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_member order by member_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function view_member(){
        $member_id = getGpc('id','integer','G');
        $info  = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_member where member_id =' . $member_id);
        $this->assign('info',$info);
        $this->display();
    }
    
    public function view_content(){
        //查看用户收藏
    }
    
    public function reply_message(){
        if(IS_POST){
            $access_token = $this->get_token();
            $http = new Http;
            $info = array();
            $info['type'] = getGpc('type','integer','P');
            $openid = getGpc('openid','string','P');
            if($info['type'] == 1){
                $info['content'] = getGpc('content','string','P');
                if(trim($info['content']) == ''){
                    message('发送内容不能为空',$_SERVER['HTTP_REFERER'],3);
                }
                $data = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $info['content'] . '"}}';
            }else{
                $ids = getGpc('ids','array','P');
                if(empty($ids)){
                    message('群发内容不能为空',$_SERVER['HTTP_REFERER'],3);
                }
                $ids = implode(',', $ids);
                $infos = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_material where material_id in (' . $ids . ') order by listorder asc');
                
                if(empty($infos)){
                    message('群发内容不能为空',$_SERVER['HTTP_REFERER'],3);
                }
                $data = '{"articles": [';
                foreach($infos as $k=>$v){
                    if($v['image'] != ''){
                        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $access_token . '&type=image';
                        $thumbdata = array('media'=>'@'.SITE_PATH.substr($v['image'],1));
                        $return = $http->post($url,$thumbdata);
                        $return = json_decode($return,true);
                        if(isset($return['errcode']) && $return['errcode'] != 0){
                            message('{"errcode":' . $return['errcode'] . ',"errmsg":"' . $return['errmsg'] . '"}','',3);
                        }
                        $show_cover_pic = $k == 0 ? 1 : 0;
                        $data .= '{
                            "thumb_media_id":"'.$return['media_id'].'",
                            "author":"",
                            "title":"'. $v['title'] .'",
                            "content_source_url":"",
                            "content":"'. $v['content'] .'",
                            "digest":"'. $v['description'] .'",
                            "show_cover_pic":' . $show_cover_pic.
                        '},';
                     }else{
                        $data .= '{
                            "thumb_media_id":"",
                            "author":"",
                            "title":"'. $v['title'] .'",
                            "content_source_url":"",
                            "content":"'. $v['content'] .'",
                            "digest":"'. $v['description'] .'",
                            "show_cover_pic":' . $show_cover_pic.
                        '},';
                     }
                }
                $data = substr($data,0,-1);
                $data .= ']}';
                $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=' . $access_token;
                $return = $http->post($url,$data);
                $return = json_decode($return,true);
                if(isset($return['errcode']) && $return['errcode'] != 0){
                    message('{"errcode":' . $return['errcode'] . ',"errmsg":"' . $return['errmsg'] . '"}','',3);
                }
                $data = '{"touser":"' . $openid . '","msgtype":"mpnews","mpnews":{"media_id":"' . $return['media_id'] . '"}}';
            }
            $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $access_token;
            $return = $http->post($url,$data);
            if($return['errcode']==0){
                message('操作成功','index.php?c=wechar&a=member',3);
            }else{
                message('{"errcode":' . $return['errcode'] . ',"errmsg":"' . $return['errmsg'] . '"}',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $member_id = getGpc('id','integer','G');
            $info  = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_member where member_id =' . $member_id);
            $message  = $this->db->getAll('select m.*,u.nickname,u.member_id from '.config('DB_TABLE_PRE').'wechar_message m left join '.config('DB_TABLE_PRE').'wechar_member u on m.openid = u.openid where m.openid ="' . $info['openid'] . '" order by m.add_time desc limit 10');
            foreach($message as &$val){
                $data = unserialize($val['data']);
                switch($val['type']){
                    case 'text' :
                        $val['type'] = '文字';
                        $val['content'] = $data['content'];
                        break;
                    case 'image' :
                        $val['type'] = '图片';
                        $val['content'] = '请到微信管理后台查看';
                        break;
                    case 'voice' :
                        $val['type'] = '语音';
                        $val['content'] = '请到微信管理后台查看';
                        break;
                    case 'video' :
                        $val['type'] = '视频';
                        $val['content'] = '请到微信管理后台查看';
                        break;
                    case 'shortvideo' :
                        $val['type'] = '小视频';
                        $val['content'] = '请到微信管理后台查看';
                        break;
                    case 'location' :
                        $val['type'] = '位置';
                        $val['content'] = $data['label'] . ' 坐标：' . $data['location_x'] . ',' . $data['location_y'];
                        break;
                    case 'link' :
                        $val['type'] = '链接';
                        $val['content'] = '<a target="_blank" href="'.$data['url'].'">'.$data['title'].'</a>';
                        break;
                }
            }
            $this->assign('message',$message);
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function groups(){
        $user_num = $this->get_all_openid();
        if(is_array($user_num)){
            message('{"errcode":' . $user_num['errcode'] . ',"errmsg":"' . $user_num['errmsg'] . '"}','',3);
        }
        $this->assign('user_num',$user_num);
        $this->display();
    }
    
    public function get_member(){
        $access_token = $this->get_token();
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_member');
        $count = $count_num['count_num'];
        $Page  = new Page($count,100);
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_member order by member_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        if(!$list){
            $this->ajaxReturn(array('status'=>2,'msg'=>'同步用户信息完成'));
        }
        $urls = array();
        foreach($list as $vo){
            $urls[] = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$vo['openid'].'&lang=zh_CN';
        }
        $http = new Http;
        $data = $http->multi_get($urls);
        foreach($data as $info){
            $info = json_decode($info,true);
            $info['tagid_list'] = implode(',',$info['tagid_list']);
            $info['nickname'] = escapeString($info['nickname']);
            $sql = updateTable(config('DB_TABLE_PRE').'wechar_member',$info,array('openid'=>$info['openid']));
            if(!$this->db->exec($sql)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'保存数据失败'));
            }
        }
        if(count($data) == $count){
            $this->ajaxReturn(array('status'=>2,'msg'=>'同步用户信息完成'));
        }else{
            $this->ajaxReturn(array('status'=>1));
        }
    }
    
    public function material(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_material');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_material order by listorder asc ,material_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function add_material(){
        if(IS_POST){
            $data['type']           = getGpc('type','integer','P');
            $data['title']          = $data['type'] == 1 ? '' : escapeString(getGpc('title','string','P'));
            $data['image']          = $data['type'] == 1 ? '' : escapeString(getGpc('image','string','P'));
            $data['description']    = escapeString(getGpc('description','string','P'));
            $data['content']        = $data['type'] == 1 ? '' : escapeString(getGpc('content','string','P'));
            $data['link']           = $data['type'] == 1 ? '' : escapeString(getGpc('link','string','P'));
            $data['keyword1']       = escapeString(getGpc('keyword1','string','P'));
            $data['keyword2']       = escapeString(getGpc('keyword2','string','P'));
            $data['keyword3']       = escapeString(getGpc('keyword3','string','P'));
            $data['subscribe']      = escapeString(getGpc('subscribe','integer','P'));
            $data['default']        = escapeString(getGpc('default','integer','P'));
            $data['add_time']       = time();
            $data['listorder']      = 99;
            $sql = insertTable(config('DB_TABLE_PRE').'wechar_material',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=wechar&a=material',3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $this->display();
        }
    }
    
    public function edit_material(){
        if(IS_POST){
            $material_id            = getGpc('material_id','integer','P');
            $data['type']           = getGpc('type','integer','P');
            $data['title']          = $data['type'] == 1 ? '' : escapeString(getGpc('title','string','P'));
            $data['image']          = $data['type'] == 1 ? '' : escapeString(getGpc('image','string','P'));
            $data['description']    = escapeString(getGpc('description','string','P'));
            $data['content']        = $data['type'] == 1 ? '' : escapeString(getGpc('content','string','P'));
            $data['link']           = $data['type'] == 1 ? '' : escapeString(getGpc('link','string','P'));
            $data['keyword1']       = escapeString(getGpc('keyword1','string','P'));
            $data['keyword2']       = escapeString(getGpc('keyword2','string','P'));
            $data['keyword3']       = escapeString(getGpc('keyword3','string','P'));
            $data['subscribe']      = escapeString(getGpc('subscribe','integer','P'));
            $data['default']        = escapeString(getGpc('default','integer','P'));
            $sql = updateTable(config('DB_TABLE_PRE').'wechar_material',$data,array('material_id'=>$material_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=wechar&a=material',3);
            }else{
                message('操作失败',$_SERVER['HTTP_REFERER'],3);
            }
        }else{
            $material_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_material where material_id = ' . $material_id);
            $this->assign('info',$info);
            $this->display();
        }
    }
    
    public function delete_material(){
        $material_id = getGpc('id','integer','G');
        $sql = 'delete from '.config('DB_TABLE_PRE').'wechar_material where material_id = ' . $material_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=wechar&a=material',3);
        }else{
            message('操作失败',$_SERVER['HTTP_REFERER'],3);
        }
    }
    
    public function material_listorder(){
        $material_id = getGpc('material_id','integer','P');
        $listorder   = getGpc('listorder','integer','P');
        $sql = updateTable(config('DB_TABLE_PRE').'wechar_material',array('listorder'=>$listorder),array('material_id'=>$material_id));
        if($this->db->exec($sql)){
            $this->ajaxReturn(array('status'=>1,'material_id'=>$material_id));
        }else{
            $this->ajaxReturn(array('status'=>0,'material_id'=>$material_id));
        }
    }
    
    public function sendall(){
        if(IS_POST){
            $access_token = $this->get_token();
            $http = new Http;
            $info = array();
            $info['type'] = getGpc('type','integer','P');
            $info['group'] = getGpc('group','integer','P');
            if($info['type'] == 1){
                $info['content'] = getGpc('content','string','P');
                if(trim($info['content']) == ''){
                    message('群发内容不能为空',$_SERVER['HTTP_REFERER'],3);
                }
                if($info['group'] == -1){
                    $data = '{"filter":{"is_to_all":true},"text":{"content":"' . $info['content'] . '"},"msgtype":"text"}';
                }else{
                    $data = '{"filter":{"is_to_all":false,"group_id":'.$info['group'].'},"text":{"content":"' . $info['content'] . '"},"msgtype":"text"}';
                }
            }else{
                $ids = getGpc('ids','array','P');
                if(empty($ids)){
                    message('群发内容不能为空',$_SERVER['HTTP_REFERER'],3);
                }
                $ids = implode(',', $ids);
                $infos = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_material where material_id in (' . $ids . ') order by listorder asc');
                
                if(empty($infos)){
                    message('群发内容不能为空',$_SERVER['HTTP_REFERER'],3);
                }
                $data = '{"articles": [';
                foreach($infos as $k=>$v){
                    if($v['image'] != ''){
                        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $access_token . '&type=image';
                        $thumbdata = array('media'=>'@'.SITE_PATH.substr($v['image'],1));
                        $return = $http->post($url,$thumbdata);
                        $return = json_decode($return,true);
                        if(isset($return['errcode']) && $return['errcode'] != 0){
                            message('{"errcode":' . $return['errcode'] . ',"errmsg":"' . $return['errmsg'] . '"}','',3);
                        }
                        $show_cover_pic = $k == 0 ? 1 : 0;
                        $data .= '{
                            "thumb_media_id":"'.$return['media_id'].'",
                            "author":"",
                            "title":"'. $v['title'] .'",
                            "content_source_url":"",
                            "content":"'. $v['content'] .'",
                            "digest":"'. $v['description'] .'",
                            "show_cover_pic":' . $show_cover_pic.
                        '},';
                     }else{
                        $data .= '{
                            "thumb_media_id":"",
                            "author":"",
                            "title":"'. $v['title'] .'",
                            "content_source_url":"",
                            "content":"'. $v['content'] .'",
                            "digest":"'. $v['description'] .'",
                            "show_cover_pic":' . $show_cover_pic.
                        '},';
                     }
                }
                
                $data = substr($data,0,-1);
                $data .= ']}';
                $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=' . $access_token;
                $return = $http->post($url,$data);
                $return = json_decode($return,true);
                if(isset($return['errcode']) && $return['errcode'] != 0){
                    message('{"errcode":' . $return['errcode'] . ',"errmsg":"' . $return['errmsg'] . '"}','',3);
                }
                var_dump($return);
                die();
                if($info['group'] == -1){
                    $data = '{"filter":{"is_to_all":true},"mpnews":{"media_id":"'.$return['media_id'].'"},"msgtype":"mpnews"}';
                }else{
                    $data = '{"filter":{"is_to_all":false,"group_id":'.$info['group'].'},"mpnews":{"media_id":"'.$return['media_id'].'"},"msgtype":"mpnews"}';
                }
            }
            $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=' . $access_token;
            $return = $http->post($url,$data);;
            if($return['errcode']==0){
                message('操作成功','index.php?c=wechar&a=member',3);
            }else{
                message('{"errcode":' . $return['errcode'] . ',"errmsg":"' . $return['errmsg'] . '"}','index.php?c=wechar&a=member',3);
            }
        }else{
            $access_token = $this->get_token();
            $url = 'https://api.weixin.qq.com/cgi-bin/groups/get?access_token=' . $access_token;
            $http = new Http;
            $data = $http->get($url);
            $groups =  json_decode($data,true);
            if(!isset($groups['errcode']) || $groups['errcode'] == 0){
                $groups = $groups['groups'];
                $this->assign('groups',$groups);
                $this->display();
            }else{
                message('{"errcode":' . $groups['errcode'] . ',"errmsg":"' . $groups['errmsg'] . '"}','index.php?c=wechar&a=member',3);
            }
        }
    }
    
    public function menu(){
        $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_menu order by listorder asc, menu_id asc ');
        $this->assign('list',$list);
        $this->display();
    }
    
    public function add_menu(){
        if(IS_POST){
            $data['parent_id']      = getGpc('parent_id','integer','P');
            $data['name']           = getGpc('name','string','P');
            $data['data_type']      = getGpc('data_type','integer','P');
            $data['data']           = getGpc('data','string','P');
            $data['listorder']      = 99;
            if($data['name'] == ''){
                message('菜单名称不能为空','index.php?c=wechar&a=menu',3);
            }
            if($data['parent_id'] != 0 && $data['data_type'] == 0){
                message('请选择菜单类型','index.php?c=wechar&a=menu',3);
            }
            if($data['data_type'] != 0 && $data['data'] == ''){
                switch($data['data_type']){
                    case 1 : 
                        $message = '关键字不能为空';
                        break;
                    case 2 : 
                        $message = '链接地址不能为空';
                        break;
                }
                message($message,'index.php?c=wechar&a=menu',3);
            }
            $menu_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_menu where parent_id = ' . $data['parent_id']);
            $menu_num = $menu_num['count_num'];
            if(($data['parent_id'] == 0 && $menu_num >= 3) || ($data['parent_id'] != 0 && $menu_num >= 5)){
                message('已达到菜单最大数量限制','index.php?c=wechar&a=menu',3);
            }
            $sql = insertTable(config('DB_TABLE_PRE').'wechar_menu',$data);
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=wechar&a=menu',3);
            }else{
                message('操作失败','index.php?c=wechar&a=menu',3);
            }
        }else{
            $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_menu where parent_id = 0 order by menu_id asc ');
            $this->assign('list',$list);
            $this->display();
        }
    }
    
    public function edit_menu(){
        if(IS_POST){
            $menu_id = getGpc('menu_id','integer','P');
            $data['parent_id']      = getGpc('parent_id','integer','P');
            $data['name']           = getGpc('name','string','P');
            $data['data_type']      = getGpc('data_type','integer','P');
            $data['data']           = getGpc('data','string','P');
            $data['listorder']      = 99;
            if($data['name'] == ''){
                message('菜单名称不能为空','index.php?c=wechar&a=menu',3);
            }
            if($data['parent_id'] != 0 && $data['data_type'] == 0){
                message('请选择菜单类型','index.php?c=wechar&a=menu',3);
            }
            if($data['data_type'] != 0 && $data['data'] == ''){
                switch($data['data_type']){
                    case 1 : 
                        $message = '关键字不能为空';
                        break;
                    case 2 : 
                        $message = '链接地址不能为空';
                        break;
                }
                message($message,'index.php?c=wechar&a=menu',3);
            }
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_menu where menu_id = ' .$menu_id);
            if($data['parent_id'] == $info['menu_id']){
                message('不能选择自己作为上级菜单','index.php?c=wechar&a=menu',3);
            }
            if($info['parent_id'] != $data['parent_id']){
                $menu_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_menu where parent_id = ' . $data['parent_id']);
                $menu_num = $menu_num['count_num'];
                if(($data['parent_id'] == 0 && $menu_num >= 2) || ($data['parent_id'] != 0 && $menu_num >= 5)){
                    message('已达到菜单最大数量限制','index.php?c=wechar&a=menu',3);
                }
            }
            $sql = updateTable(config('DB_TABLE_PRE').'wechar_menu',$data,array('menu_id'=>$menu_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=wechar&a=menu',3);
            }else{
                message('操作失败','index.php?c=wechar&a=menu',3);
            }
        }else{
            $menu_id = getGpc('id','integer','G');
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_menu where menu_id = ' .$menu_id);
            $this->assign('info',$info);
            $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_menu where parent_id = 0 order by menu_id asc ');
            $this->assign('list',$list);
            $this->display();
        }
    }
    
    public function delete_menu(){
        $menu_id = getGpc('id','integer','G');
        $menu_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_menu where parent_id = ' . $parent_id);
        $menu_num = $menu_num['count_num'];
        if($menu_num > 0){
            message('请先删除子菜单','index.php?c=wechar&a=menu',3);
        }
        $sql = 'delete from '.config('DB_TABLE_PRE').'wechar_menu where menu_id = ' .$menu_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=wechar&a=menu',3);
        }else{
            message('操作失败','index.php?c=wechar&a=menu',3);
        }
    }
    
    public function menu_listorder(){
        $menu_id = getGpc('menu_id','integer','P');
        $listorder   = getGpc('listorder','integer','P');
        $sql = updateTable(config('DB_TABLE_PRE').'wechar_menu',array('listorder'=>$listorder),array('menu_id'=>$menu_id));
        if($this->db->exec($sql)){
            $this->ajaxReturn(array('status'=>1,'menu_id'=>$menu_id));
        }else{
            $this->ajaxReturn(array('status'=>0,'menu_id'=>$menu_id));
        }
    }
    
    public function menu_create(){
        $list = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_menu order by menu_id asc ');
        $data = '{"button": [';
        foreach($list as $v){
            if($v['parent_id'] == 0){
                $data .= '{"name": "'.$v['name'].'", ';
                $sub_data = '';
                foreach($list as $val){
                    if($val['parent_id'] == $v['menu_id']){
                        $sub_data .= '{';
                        switch($val['data_type']){
                            case 1 : 
                                $sub_data .= '"type":"click",';
                                $sub_data .= '"name":"' . $val['name'] . '",';
                                $sub_data .= '"key":"' . $val['data'] . '"';
                                break;
                            case 2 : 
                                $sub_data .= '"type":"view",';
                                $sub_data .= '"name":"' . $val['name'] . '",';
                                $sub_data .= '"url":"' . $val['data'] . '"';
                                break;
                        }
                        $sub_data .= '},';
                    }
                }
                $sub_data = substr($sub_data,0,-1);
                if($sub_data != ''){
                    $data .= '"sub_button":[' . $sub_data . ']},';
                }else{
                    switch($v['data_type']){
                        case 1 : 
                            $data .= '"type":"click",';
                            $data .= '"key":"' . $v['data'] . '"';
                            break;
                        case 2 : 
                            $data .= '"type":"view",';
                            $data .= '"url":"' . $v['data'] . '"';
                            break;
                    }
                    $data .= '},';
                }
            }
        }
        $data = substr($data,0,-1);
        $data .= ']}';
        $access_token = $this->get_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $access_token;
        $http = new Http;
        $return = $http->post($url,$data);
        $return = json_decode($return,true);
        if($return['errcode']==0){
            message('操作成功','index.php?c=wechar&a=menu',3);
        }else{
            message('{"errcode":' . $return['errcode'] . ',"errmsg":"' . $return['errmsg'] . '"}','index.php?c=wechar&a=menu',3);
        }
    }
    
    public function message(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_message');
        $count = $count_num['count_num'];
        $Page  = new Page($count,15);
        $show  = $Page->show();
        $list  = $this->db->getAll('select m.*,u.nickname,u.member_id from '.config('DB_TABLE_PRE').'wechar_message m left join '.config('DB_TABLE_PRE').'wechar_member u on m.openid = u.openid order by m.message_id asc limit ' . $Page->firstRow . ',' . $Page->listRows);
        foreach($list as &$val){
            $data = unserialize($val['data']);
            switch($val['type']){
                case 'text' :
                    $val['type'] = '文字';
                    $val['content'] = $data['content'];
                    break;
                case 'image' :
                    $val['type'] = '图片';
                    $val['content'] = '请到微信管理后台查看';
                    break;
                case 'voice' :
                    $val['type'] = '语音';
                    $val['content'] = '请到微信管理后台查看';
                    break;
                case 'video' :
                    $val['type'] = '视频';
                    $val['content'] = '请到微信管理后台查看';
                    break;
                case 'shortvideo' :
                    $val['type'] = '小视频';
                    $val['content'] = '请到微信管理后台查看';
                    break;
                case 'location' :
                    $val['type'] = '位置';
                    $val['content'] = $data['label'] . ' 坐标：' . $data['location_x'] . ',' . $data['location_y'];
                    break;
                case 'link' :
                    $val['type'] = '链接';
                    $val['content'] = '<a target="_blank" href="'.$data['url'].'">'.$data['title'].'</a>';
                    break;
            }
        }
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function message_delete(){
        $message_id = getGpc('id','integer','G');
        $sql = 'delete from '.config('DB_TABLE_PRE').'wechar_message where message_id = ' .$message_id;
        if($this->db->exec($sql)){
            message('操作成功','index.php?c=wechar&a=message',3);
        }else{
            message('操作失败','index.php?c=wechar&a=message',3);
        }
    }
    
    public function select_material(){
        $name = escapeString(getGpc('name','string','G'));
        $where = 'where 1=1 ';
        if($name != ''){
            $where .= ' and title like "%' . $name . '%" ';
        }
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_material ' . $where);
        $count = $count_num['count_num'];
        $Page  = new Page($count,5);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_material ' . $where . ' order by listorder asc, material_id DESC limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function qrcode(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'wechar_qrcode');
        $count = $count_num['count_num'];
        $Page  = new Page($count,5);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'wechar_qrcode order by qrcode_id DESC limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    
    public function add_qrcode(){
        if(IS_POST){
            $name = escapeString(getGpc('name','string','P'));
            $data = array(
                'name'=>$name,
                'ticket'=>'',
                'add_time'=>time()
            );
            $sql = insertTable(config('DB_TABLE_PRE').'wechar_qrcode',$data);
            if($this->db->exec($sql)){
                $qrcode_id = $this->db->insertId();
            }else{
                message('添加失败','index.php?c=wechar&a=qrcode',3);
            }
            $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": ' . $qrcode_id . '}}}';
            $access_token = $this->get_token();
            $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
            $http = new Http;
            $return = $http->post($url,$data);
            $return = json_decode($return,true);
            if($return['ticket']!=''){
                $sql = updateTable(config('DB_TABLE_PRE').'wechar_qrcode',array('ticket'=>$return['ticket']),array('qrcode_id'=>$qrcode_id));
                if($this->db->exec($sql)){
                    message('操作成功','index.php?c=wechar&a=qrcode',3);
                }else{
                    $sql = 'delete from '.config('DB_TABLE_PRE').'wechar_qrcode where qrcode_id = '.$qrcode_id;
                    $this->db->exec($sql);
                    message('添加失败','index.php?c=wechar&a=qrcode',3);
                }
            }else{
                message('{"errcode":' . $return['errcode'] . ',"errmsg":"' . $return['errmsg'] . '"}','index.php?c=wechar&a=qrcode',3);
            }
        }else{
            $this->display();
        }
    }
    
    public function edit_qrcode(){
        if(IS_POST){
            $name = escapeString(getGpc('name','string','P'));
            $qrcode_id = getGpc('qrcode_id','integer','P');
            $qrcode = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'wechar_qrcode where qrcode_id = ' . $qrcode_id);
            if(!$qrcode){
                message('找不到该参数二维码','index.php?c=wechar&a=qrcode',3);
            }
            $sql = updateTable(config('DB_TABLE_PRE').'wechar_qrcode',array('name'=>$name),array('qrcode_id'=>$qrcode_id));
            if($this->db->exec($sql)){
                message('操作成功','index.php?c=wechar&a=qrcode',3);
            }else{
                message('操作失败','index.php?c=wechar&a=qrcode',3);
            }
        }else{
            $qrcode_id = getGpc('id','integer','G');
            $qrcode = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'wechar_qrcode where qrcode_id = ' . $qrcode_id);
            if(!$qrcode){
                message('找不到该参数二维码','index.php?c=wechar&a=qrcode',3);
            }
            $this->assign('qrcode',$qrcode);
            $this->display();
        }
    }
    
    public function download_qrcode(){
        $qrcode_id = getGpc('id','integer','G');
        $qrcode = $this->db->getOne('select * from ' . config('DB_TABLE_PRE').'wechar_qrcode where qrcode_id = ' . $qrcode_id);
        if($qrcode){
            $mime = 'application/force-download';
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename="'.$qrcode_id.'.jpg"');
            $http = new Http;
            echo $http->get('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($qrcode['ticket']));
        }else{
            message('找不到该参数二维码','index.php?c=wechar&a=qrcode',3);
        }
    }
    
    public function member_count(){
        $list  = $this->db->getAll('select count(1) as count_num ,qrcode_id from '.config('DB_TABLE_PRE').'wechar_member where subscribe = 1 group by qrcode_id ');
        $qrcode  = $this->db->getAll('select name,qrcode_id from '.config('DB_TABLE_PRE').'wechar_qrcode order by qrcode_id DESC');
        foreach($qrcode as $key => $val){
            foreach($list as $v){
                if($v['qrcode_id'] == 0){
                    $qrcode[] = array('name'=>'未知来源','num'=>$v['count_num']);
                }
                if($v['qrcode_id'] == $val['qrcode_id']){
                    $qrcode[$key]['num'] = $v['count_num'];
                }
            }
        }
        $this->assign('qrcode',$qrcode);
        $this->display();
    }
    
    public function origin(){
        $category_id = getGpc('category_id','intager','G');
        $name = escapeString(getGpc('name','string','G'));
        $where = 'where 1=1 ';
        $category_ids = $this->get_children_category($category_id);
        $where .= ' and category_id in (' . implode(',',$category_ids) . ')';
        if($name != ''){
            $where .= ' and title like "%' . $name . '%" ';
        }
        $db = Sqlite::connect(SITE_PATH . 'data/' . $this->site_info['site_dir'] . 'db');
        $count_num = $db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'content ' . $where);
        $count = $count_num['count_num'];
        $Page  = new Page($count,5);
        $show  = $Page->show();
        $list  = $db->getAll('select * from '.config('DB_TABLE_PRE').'content ' . $where . ' order by listorder asc, content_id DESC limit ' . $Page->firstRow . ',' . $Page->listRows);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $categoryobj = new ContentController;
        $categorys = $categoryobj->category_lists();
        $this->assign('categorys',$categorys);
        $this->display();
    }
    
    public function get_content(){
        $content_id = getGpc('content_id','intager','G');
        $db = Sqlite::connect(SITE_PATH . 'data/' . $this->site_info['site_dir'] . 'db');
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'content where content_id = ' . $content_id);
        $this->ajaxReturn($info);
    }
    
    private function get_children_category($category_id){
        $db = Sqlite::connect(SITE_PATH . 'data/' . $this->site_info['site_dir'] . 'db');
        $info = $db->getAll('select category_id from ' . config('DB_TABLE_PRE') . 'category where parent_id = '.$category_id);
        foreach($info as $val){
            $category_ids[] = $val['category_id'];
        }
        unset($info);
        $category_ids = $category_ids ? $category_ids : array();
        $temp = array();
        foreach($category_ids as $child_category_id){
            $temp = $this->get_children_category($child_category_id);
        }
        $category_ids[] = $category_id;
        $category_ids = array_merge($category_ids,$temp);
        unset($temp);
        $category_ids = array_filter($category_ids);
        $category_ids = array_unique($category_ids);
        return $category_ids;
    }
    
    private function get_all_openid($next_openid = '',$num = 0){
        $access_token = $this->get_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=' . $access_token . '&next_openid=' . $next_openid;
        $http = new Http;
        $token = json_decode($http->get($url),true);
        if(isset($token['errcode'])){
            return $token;
        }
        $num += $token['count'];
        foreach($token['data']['openid'] as $openid){
            $info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_member where openid = "' . $openid . '" limit 1');
            if(!$info){
                $sql = insertTable(config('DB_TABLE_PRE').'wechar_member',array('openid'=>$openid));
                $this->db->exec($sql);
            }
        }
        if($token['total'] != $num){
            $this->get_all_openid($token['next_openid'],$num);
        }
        return $token['total'];
    }
    
    private function get_token(){
        $setting=$this->db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_config');
        $appid =$setting['appid'];
        $secret =$setting['appsecret'];
        $time = time();
        $access_token = $setting['access_token'];
        if(!$access_token || $setting['expires_time']<=$time){
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
            $http = new Http;
            $token = json_decode($http->get($url),true);
            $data=array();
            $data['access_token']=$token['access_token'];
            $data['expires_time']=$time+$token['expires_in'];
            $sql = updateTable(config('DB_TABLE_PRE').'wechar_config',$data,array('config_id'=>$setting['config_id']));
            $this->db->exec($sql);
            $access_token = $token['access_token'];
        }
        return $access_token;
    }
}
?>