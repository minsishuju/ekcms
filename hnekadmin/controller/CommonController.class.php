<?php
class CommonController extends Controller {
    private $site_info,$db;
    
    public function __construct(){
        parent::__construct();
        $site_id = $_SESSION['site']['site_id'] ? $_SESSION['site']['site_id'] : getGpc('site_id','integer','P');
        if($site_id){
            $this->db = Mysql::connect();
            $this->site_info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
        }
    }
    
    public function checkcode(){
        require str_replace('controller','common',dirname(__FILE__)).'\Code.class.php';
        $code = new Code();
        $code->height = 27;
        $code->width = 90;
        $code->fontsize = 13;
        $code->charset = '123456789';
        $code->doimg();
        $_SESSION['checkcode'] = $code->getCode();
    }
    
    public function upload(){
        if(IS_POST){
            $data = array(
                'attachment_id'=>0,
                'status'=>0,
                'message'=>'',
                'path'=>'',
                'input_id'=>getGpc('input_id','string','P')
            );
            if (!empty($_FILES)) {
                $upload = new Upload();
                $upload->maxSize   = 3145728 ;
                $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath  = SITE_PATH . 'data/';
                $upload->savePath  = $this->site_info['site_dir'] .'Upload/' . date('Ym') . '/' . date('d') . '/';
                $info = $upload->upload($_FILES[$_POST['file']]);
                if(!$info) {
                    $data['message'] = $upload->getError();
                }else{
                    //watermark('../data/' . $info['savepath'] . $info['savename'],'../data/' . $this->site_info['site_dir'].'static/images/mark.png');
                    $save = array();
                    $save['add_time']   = time();
                    $save['catid']      = 0;
                    $save['name']       = $info['name'];
                    $save['path']       = 'data/' . $info['savepath'] . $info['savename'];
                    $sql = insertTable(config('DB_TABLE_PRE').'attachment',$save);
                    if($this->db->exec($sql)){
                        $data['attachment_id'] = $this->db->insertId();
                        $data['status'] = 1;
                        $data['path']   = '/data/' . $info['savepath'] . $info['savename'];
                    }else{
                        @unlink(SITE_PATH . 'data/' . $info['savepath'] . $info['savename']);
                        $data['message'] = '文件保存失败';
                    }
                }
            }
            $this->ajaxReturn($data);
        }else{
            $input_id = getGpc('input_id','string','G');
            $this->assign('input_id',$input_id);
            $this->assign('site_id',$this->site_info['site_id']);
            $this->display();
        }
    }
    
    public function uploads(){
        $input_id = getGpc('input_id','string','G');
        $this->assign('input_id',$input_id);
        $this->assign('site_id',$this->site_info['site_id']);
        $this->display();
    }
    
    public function editor(){
        if (!empty($_FILES)) {
            $upload = new Upload();
            $upload->maxSize   = 3145728 ;
            $upload->exts      = array('jpg', 'gif', 'png', 'jpeg', 'mp3', 'mp4', 'swf');
            $upload->rootPath  = SITE_PATH . 'data/';
            $upload->savePath  = $this->site_info['site_dir'] .'/Upload/' . date('Ym') . '/' . date('d') . '/';
            $info = $upload->upload($_FILES['imgFile']);
            if(!$info) {
                echo json_encode(array('error' => 1, 'message' => $upload->getError()));
                exit;
            }else{
                $save = array();
                $save['add_time']   = time();
                $save['catid']      = 0;
                $save['name']       = $info['name'];
                $save['path']       = 'data/' . $info['savepath'] . $info['savename'];
                $sql = insertTable(config('DB_TABLE_PRE').'attachment',$save);
                $this->db->exec($sql);
                echo json_encode(array('error' => 0, 'url' => '/data/' . $info['savepath'] . $info['savename']));
                exit;
            }
        }
    }
    
    public function manager(){
		$file_list = array();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'attachment order by add_time desc,attachment_id desc ');
        $i = 0;
        foreach($list as $file){
            $file_url = '/'.$file['path'];
            $filename = $file['name'];
            $file = SITE_PATH . $file['path'];
            $file_list[$i]['is_dir'] = false;
            $file_list[$i]['has_file'] = false;
            $file_list[$i]['filesize'] = filesize($file);
            $file_list[$i]['dir_path'] = '';
            $file_ext = strtolower(array_pop(explode('.', trim($file))));
            $file_list[$i]['is_photo'] = true;
            $file_list[$i]['filetype'] = $file_ext;
            $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
            $file_list[$i]['file_url'] = $file_url; //文件名，包含扩展名
            $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
            $i++;
        }
		$result = array();
        $result['moveup_dir_path'] = '';
		$result['current_dir_path'] = '';
		$result['current_url'] = '';
		$result['total_count'] = count($file_list);
		$result['file_list'] = $file_list;
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($result);
    }
    
    public function album(){
        $count_num = $this->db->getOne('select count(1) as count_num from '.config('DB_TABLE_PRE').'attachment ');
        $count = $count_num['count_num'];
        $Page  = new Page($count,8);
        $show  = $Page->show();
        $list  = $this->db->getAll('select * from '.config('DB_TABLE_PRE').'attachment order by add_time desc,attachment_id desc limit ' . $Page->firstRow . ',' . $Page->listRows);
        $return = array('list'=>$list,'page'=>$show);
        $this->ajaxReturn($return);
    }

    public function siteInfo()
    {
        return $this->site_info;
    }
}
?>