<?php
class WecharController extends Controller {
    private $_token;
    private $_post;
    
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
        $db = Sqlite::connect(config('__DB__'));
        $setting=$db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_config');
        $this->_token = $setting['token'];
        if(!$this->checkSignature()){
            echo 'illegal origin';
            exit;
        }
        $postStr = file_get_contents('php://input');
        $this->_post = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    }
    
    public function index(){
        $fromUsername = (string)$this->_post->FromUserName;
        $toUsername = (string)$this->_post->ToUserName;
        $CreateTime = (int)$this->_post->CreateTime;
        $db = Sqlite::connect(config('__DB__'));
        $this->update_mmeber();
        $save = array('openid'=>$fromUsername,'type'=>strtolower((string)$this->_post->MsgType));
        $data = array();
        switch(strtolower((string)$this->_post->MsgType)) {
            case 'text' :
                $msg_id = (string)$this->_post->MsgId;
                $content = (string)$this->_post->Content;
                $save_data = array('msg_id'=>$msg_id,'content'=>$content);
                $list = $db->getAll('select * from ' . config('DB_TABLE_PRE') . 'wechar_material where type = 2 and (keyword1 = "' . $content . '" or keyword2 = "' . $content . '" or keyword3 = "' . $content . '") ');
                if($list){
                    $data = array('type'=>'news','articlecount'=>count($list));
                    foreach($list as $vo){
                        $data['articles'][] = array(
                            'title'=>$vo['title'],
                            'description'=>$vo['description'],
                            'picurl'=>config('SITE_INFO.siteurl') . substr($vo['image'],1),
                            'url'=>config('SITE_INFO.siteurl') . 'index.php?c=weixin&a=show&id='.$vo['material_id']
                        );
                    }
                }else{
                    $list = $db->getOne('select * from ' . config('DB_TABLE_PRE') . 'wechar_material where type = 1 and (keyword1 = "' . $content . '" or keyword2 = "' . $content . '" or keyword3 = "' . $content . '") ');
                    if($list){
                        $data = array('type'=>'text','content'=>$list['description']);
                    }
                }
                break;
            case 'image' :
                $msg_id = (string)$this->_post->MsgId;
                $pic_url = (string)$this->_post->PicUrl;
                $media_id = (string)$this->_post->MediaId;
                $save_data = array('msg_id'=>$msg_id,'pic_url'=>$pic_url,'media_id'=>$media_id);
                break;
            case 'voice' :
                $msg_id = (string)$this->_post->MsgId;
                $media_id = (string)$this->_post->MediaId;
                $format = (string)$this->_post->Format;
                $recognition = (string)$this->_post->Recognition;
                $save_data = array('msg_id'=>$msg_id,'media_id'=>$media_id,'format'=>$format,'recognition'=>$recognition);
                break;
            case 'video' :
                $msg_id = (string)$this->_post->MsgId;
                $media_id = (string)$this->_post->MediaId;
                $thumbmedia_id = (string)$this->_post->ThumbMediaId;
                $save_data = array('msg_id'=>$msg_id,'media_id'=>$media_id,'thumbmedia_id'=>$thumbmedia_id);
                break;
            case 'shortvideo' :
                $msg_id = (string)$this->_post->MsgId;
                $media_id = (string)$this->_post->MediaId;
                $thumbmedia_id = (string)$this->_post->ThumbMediaId;
                $save_data = array('msg_id'=>$msg_id,'media_id'=>$media_id,'thumbmedia_id'=>$thumbmedia_id);
                break;
            case 'location' :
                $msg_id = (string)$this->_post->MsgId;
                $location_x = (float)$this->_post->Location_X;
                $location_y = (float)$this->_post->Location_Y;
                $scale = (int)$this->_post->Scale;
                $label = (string)$this->_post->Label;
                $save_data = array('msg_id'=>$msg_id,'location_x'=>$location_x,'location_y'=>$location_y,'scale'=>$scale,'label'=>$label);
                break;
            case 'link' :
                $msg_id = (string)$this->_post->MsgId;
                $title = (string)$this->_post->Title;
                $description = (string)$this->_post->Description;
                $url = (string)$this->_post->Url;
                $save_data = array('msg_id'=>$msg_id,'title'=>$title,'description'=>$description,'url'=>$url);
                break;
            case 'event' :
                switch(strtolower((string)$this->_post->Event)){
                    case 'subscribe':
                        $member = array('subscribe_time'=>$createtime,'subscribe'=>1);
                        $EventKey = (string)$this->_post->EventKey;
                        if($EventKey != ''){
                            $member['qrcode_id'] = substr($EventKey,8);
                        }
                        $sql = updateTable(config('DB_TABLE_PRE').'wechar_member' , $member , array('openid'=>$fromUsername));
                        $this->db->exec($sql);
                        $list = $db->getAll('select * from ' . config('DB_TABLE_PRE') . 'wechar_material where type = 2 and `subscribe` = 1');
                        if($list){
                            $data = array('type'=>'news','articlecount'=>count($list));
                            foreach($list as $vo){
                                $data['articles'][] = array(
                                    'title'=>$vo['title'],
                                    'description'=>$vo['description'],
                                    'picurl'=>config('SITE_INFO.siteurl') . substr($vo['image'],1),
                                    'url'=>config('SITE_INFO.siteurl') . 'index.php?c=weixin&a=show&id='.$vo['material_id']
                                );
                            }
                        }else{
                            $list = $db->getOne('select * from ' . config('DB_TABLE_PRE') . 'wechar_material where type = 1 and `subscribe` = 1');
                            if($list){
                                $data = array('type'=>'text','content'=>$list['description']);
                            }
                        }
                        break;
                    case 'unsubscribe':
                        $sql = updateTable(config('DB_TABLE_PRE').'wechar_member' , array('subscribe'=>0) , array('openid'=>$fromUsername));
                        $db->exec($sql);
                        break;
                    case 'location':
                        $latitude = (string)$this->_post->Latitude;
                        $longitude = (string)$this->_post->Longitude;
                        $precision = (string)$this->_post->Precision;
                        die();
                        break;
                    case 'click':
                        $event_key = (string)$this->_post->EventKey;
                        break;
                    case 'view':
                        $event_key = (string)$this->_post->EventKey;
                        break;
                }
                break;
        }
        if(isset($save_data)){
            $save['data'] = serialize($save_data);
            $save['add_time'] = (int)$this->_post->CreateTime;
            $sql = insertTable(config('DB_TABLE_PRE').'wechar_message' , $save);
            $db->exec($sql);
        }
        if(strtolower((string)$this->_post->MsgType) != 'event' && empty($data)){
            $list = $db->getAll('select * from ' . config('DB_TABLE_PRE') . 'wechar_material where type = 2 and `default` = 1');
            if($list){
                $data = array('type'=>'news','articlecount'=>count($list));
                foreach($list as $vo){
                    $data['articles'][] = array(
                        'title'=>$vo['title'],
                        'description'=>$vo['description'],
                        'picurl'=>config('SITE_INFO.siteurl') . substr($vo['image'],1),
                        'url'=>config('SITE_INFO.siteurl') . 'index.php?c=weixin&a=show&id='.$vo['material_id']
                    );
                }
            }else{
                $list = $db->getOne('select * from ' . config('DB_TABLE_PRE') . 'wechar_material where type = 1 and `default` = 1');
                if($list){
                    $data = array('type'=>'text','content'=>$list['description']);
                }else{
                    die();
                }
            }
        }
        if(!empty($data)){
            $this->responseMsg($data);
        }
    }
    
    private function update_mmeber(){
        $openid = (string)$this->_post->FromUserName;
        $createtime = (int)$this->_post->CreateTime;
        $db = Sqlite::connect(config('__DB__'));
        $info = $db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_member where openid = "' . $openid . '"');
        if($info){
            $sql = updateTable(config('DB_TABLE_PRE').'wechar_member' , array('end_time'=>$createtime,'subscribe'=>1) , array('openid'=>$openid));
        }else{
            $access_token = $this->get_token();
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
            $http = new Http;
            $data = $http->get($url);
            $info = json_decode($data,true);
            $info['nickname'] = escapeString($info['nickname']);
            $info['tagid_list'] = implode(',',$info['tagid_list']);
            $info['end_time'] = $createtime;
            $sql = insertTable(config('DB_TABLE_PRE').'wechar_member',$info);
        }
        if($db->exec($sql)){
            return true;
        }else{
            return false;
        }
    }
    
    private function responseMsg($data){
        $fromUsername = (string)$this->_post->FromUserName;
        $toUsername = (string)$this->_post->ToUserName;
        $time = time();
        if ($data['type'] == "text") {
            $tpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";             

            echo sprintf($tpl, $fromUsername, $toUsername, $time, $data['type'], $data['content']);
        } elseif ($data['type'] == "news") {
            $tpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>%d</ArticleCount>
                        <Articles>";
            foreach($data['articles'] AS $v) {
                $tpl .=    "<item>
                         <Title><![CDATA[".$v['title']."]]></Title>
                         <Description><![CDATA[".$v['description']."]]></Description>
                         <PicUrl><![CDATA[".$v['picurl']."]]></PicUrl>
                         <Url><![CDATA[".$v['url']."]]></Url>
                         </item>";    
            }
            $tpl .=        "<FuncFlag>0</FuncFlag>
                        </xml>";  
            echo sprintf($tpl, $fromUsername, $toUsername, $time, $data['type'], $data['articlecount']);
        }
    }
    
    private function get_token(){
        $db = Sqlite::connect(config('__DB__'));
        $setting=$db->getOne('select * from '.config('DB_TABLE_PRE').'wechar_config');
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
            $db->exec($sql);
            $access_token = $token['access_token'];
        }
        return $access_token;
    }
    
    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $echostr   = $_GET["echostr"];
        $nonce     = $_GET["nonce"];
        $token     = $this->_token;
        $tmpArr = array($nonce,$token,$timestamp);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode('',$tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature && $echostr != ""){
            echo $echostr;
            die();
        }elseif($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }
}
?>