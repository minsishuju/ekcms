<?php
/**********************************
*   内容类
* @file            /class/Content.class.php
* @package
* @author       xhg
* @version       1.0.2
* @date         2012-03-01 10:28:48
* @link
**********************************/
class Content {
    public static function parse(){
        $args = func_get_args();
        $args = stripslashes($args[0]);
        preg_match_all('/[a-zA-Z_]\w+=".*?"/is',$args,$arr);
        $arr = $arr[0];
        $arr = array_map('trim',$arr);
        foreach($arr as $k=>$v){
            $pos = strpos($v, "=");
            $name = substr($v, 0, $pos);
            $data[$name] = substr($v, $pos+2,-1);
        }
        try{
            $reflectionMethod = new ReflectionMethod('Content', $data['action']);
            return $reflectionMethod->invokeArgs(new Content, array($data));
        } catch (ReflectionException $e) {
            return false;
        }
    }
    public static function category($data){
        $categorys = Content::get_category_cache();
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'category where 1=1 ';
        if(!isset($data['is_show']) || $data['is_show'] != 0){
            $sql .= ' and is_show = 1 ';
        }
        $data['category_id'] = intval($data['category_id']);
        $sql .= ' and parent_id = '.$data['category_id'];
        if(isset($data['order'])){
            $sql .= ' order by ' . $data['order'];
            $sql .= strpos($data['order'],'listorder') !== false ? '' : ' listorder asc ';
            $sql .= strpos($data['order'],'category_id') !== false ? '' : ' ,category_id asc ';
        }
        if(isset($data['num'])){
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        $city_id = trim(getGpc('city_id','string','G'));
        if($city_id != '' ){
            $city = $db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $city_id . '"');
        }
        foreach($info as $category){
            $_data[$category['category_id']] = $category;
        }
        foreach($_data as $category){
            switch ($category['type_id']){
                case 1:
                case 2:
                    $category['url'] = config('SITE_INFO.siteurl');
                    $parent_ids = explode(',',$category['parent_ids']);
                    foreach($parent_ids as $parent_id){
                        if($parent_id != 0){
                            $category['url'] .= $categorys[$parent_id]['url_name'].'/';
                        }
                    }
                    $category['url'] .= $category['url_name'].'/';
                    break;
                case 3:
                    $category['url'] = config('SITE_INFO.siteurl') .$category['url_name'].'.html';
                    break;
                case 4:
                    $category['url'] = $category['url'];
                    break;
            }
            if($city && $category['type_id'] ==2){
                $category['url'] .= '?city_id='.$city['mark'];
            }
            $_data[$category['category_id']] = $category;
        }
        return $_data;
    }
    public static function lists($data){
        $data['category_id'] = intval($data['category_id']);
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'content where 1=1 ';
        $categorys = Content::get_category_cache();
        $category = $categorys[$data['category_id']];
        $category_id = self::get_children_category($data['category_id']);
        $sql .= ' and category_id in (' . implode(',',$category_id) . ') ';
        if(isset($data['where'])){
            $sql .= ' and ' . $data['where'] . ' ';
        }
        $tags = trim(getGpc('tags','integer','G'));
        if($tags != 0){
            $sql .= ' and tags like "%,' . $tags . ',%"';
        }
        if(isset($data['order'])){
            $sql .= ' order by ' . $data['order'];
            $sql .= strpos($data['order'],'listorder') !== false ? '' : ' ,listorder ASC ';
            $sql .= strpos($data['order'],'content_id') !== false ? '' : ' ,content_id DESC ';
        }else{
            $sql .= ' order by listorder ASC,content_id DESC ';
        }
        $data['num'] = intval($data['num']) ? intval($data['num']) : 25;
        if(isset($data['page'])){
            $page_sql = 'select count(1) as count_num from ' . config('DB_TABLE_PRE') . 'content where 1=1 ';
            $page_sql .= ' and category_id in (' . implode(',',$category_id) . ')';
            if(isset($data['where'])){
                $page_sql .= ' and ' . $data['where'] . ' ';
            }
            if($tags != 0){
                $page_sql .= ' and tags like "%,' . $tags . ',%"';
            }
            $info = $db->getOne($page_sql);
            $Page  = new Page($info['count_num'],$data['num']);
            $sql .= ' limit '. $Page->firstRow .',' . intval($data['num']);
        }else{
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        $city_id = trim(getGpc('city_id','string','G'));
        if($city_id != ''){
            $city = $db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $city_id . '"');
        }
        foreach($info as $key => $val){
            if(trim($val['tags'],',') != ''){
                $val['tags'] = $db->getAll('select * from '.config('DB_TABLE_PRE').'tags where tags_id in (' . trim($val['tags'],',') . ')');
            }
            $_category = $categorys[$val['category_id']];
            $parent_ids = explode(',',$_category['parent_ids']);
            $url_role = $parent_ids[1] == 0 ? $categorys[$val['category_id']]['url_name'].'/' : $categorys[$parent_ids[1]]['url_name'].'/';
            if($city && $categorys[$val['category_id']]['type_id'] == 2){
                $info[$key]['title'] = $city['name'].$val['title'];
                $info[$key]['url'] = $val['url']? $val['url'] : config('SITE_INFO.siteurl') .$url_role.$val['content_id'].'.html?city_id='.$city['mark'];
            }else{
                $info[$key]['url'] = $val['url']? $val['url'] : config('SITE_INFO.siteurl') .$url_role.$val['content_id'].'.html';
            }
        }
        if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1 && $category['model_id'] != 0) {
			$ids = array();
			foreach ($info as $v) {
				if (isset($v['content_id']) && !empty($v['content_id'])) {
					$ids[] = $v['content_id'];
				} else {
					continue;
				}
			}
			if (!empty($ids)) {
				$ids = implode(',', $ids);
				$r = $db->getAll('select * from '.config('DB_TABLE_PRE').'model_data'.$category['model_id'] . ' where content_id in (' . $ids . ')');
				if (!empty($r)) {
                    foreach($info as $key => $vo){
                        foreach ($r as $v) {
                            if ($vo['content_id'] == $v['content_id']){
                                $info[$key] = array_merge($v, $vo);
                                continue;
                            }
                        }
					}
				}
			}
		}
        return $info;
    }
    public static function relation($data){
        $data['content_id'] = intval($data['content_id']);
        if($data['content_id'] == 0){
            return false;
        }
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'content where content_id=' . $data['content_id'];
        $info = $db->getOne($sql);
        $data['category_id'] = intval($data['category_id']);
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'content where 1=1 ';
        $sql .= ' and content_id in (' . $info['relation'] . ') ';
        $categorys = Content::get_category_cache();
        $data['type_id'] = intval($data['type_id']);
        if($data['type_id'] != 0){
            foreach($categorys as $category){
                if($category['type_id'] == $data['type_id']){
                    $category_ids[] = $category['category_id'];
                }
            }
        }
        $category = $categorys[$data['category_id']];
        if($data['category_id'] != 0){
            $category_id = self::get_children_category($data['category_id']);
        }
        if($category_ids && $category_id){
            $category_id = array_intersect($category_id,$category_ids);
        }else{
            $category_id = $category_id ? $category_id :$category_ids;
        }
        
        $sql .= ' and category_id in (' . implode(',',$category_id) . ') ';
        if(isset($data['where'])){
            $sql .= ' and ' . $data['where'] . ' ';
        }
        if(isset($data['tags'])){
            $sql .= ' and tags like "%,' . $data['tags'] . ',%"';
        }
        if(isset($data['order'])){
            $sql .= ' order by ' . $data['order'];
            $sql .= strpos($data['order'],'listorder') !== false ? '' : ' ,listorder ASC ';
            $sql .= strpos($data['order'],'content_id') !== false ? '' : ' ,content_id DESC ';
        }else{
            $sql .= ' order by listorder ASC,content_id DESC ';
        }
        $data['num'] = intval($data['num']) ? intval($data['num']) : 25;
        $sql .= ' limit ' . intval($data['num']);
        $list = $db->getAll($sql);
        $city_id = trim(getGpc('city_id','string','G'));
        if($city_id != ''){
            $city = $db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $city_id . '"');
        }
        foreach($list as &$val){
            if(trim($val['tags'],',') != ''){
                $val['tags'] = $db->getAll('select * from '.config('DB_TABLE_PRE').'tags where tags_id in (' . trim($val['tags'],',') . ')');
            }
            $_category = $categorys[$val['category_id']];
            $parent_ids = explode(',',$_category['parent_ids']);
            $url_role = $parent_ids[1] == 0 ? $categorys[$val['category_id']]['url_name'].'/' : $categorys[$parent_ids[1]]['url_name'].'/';
            if($city && $categorys[$val['category_id']]['type_id'] == 2){
                $val['title'] = $city['name'].$val['title'];
                $val['url'] = $val['url']? $val['url'] : config('SITE_INFO.siteurl') .$url_role.$val['content_id'].'.html?city_id='.$city['mark'];
            }else{
                $val['url'] = $val['url']? $val['url'] : config('SITE_INFO.siteurl') .$url_role.$val['content_id'].'.html';
            }
        }
        if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1 && $category['model_id'] != 0) {
			$ids = array();
			foreach ($info as $v) {
				if (isset($v['content_id']) && !empty($v['content_id'])) {
					$ids[] = $v['content_id'];
				} else {
					continue;
				}
			}
			if (!empty($ids)) {
				$ids = implode(',', $ids);
				$r = $db->getAll('select * from '.config('DB_TABLE_PRE').'model_data'.$category['model_id'] . ' where content_id in (' . $ids . ')');
				if (!empty($r)) {
                    foreach($info as $key => $vo){
                        foreach ($r as $v) {
                            if ($vo['content_id'] == $v['content_id']){
                                $info[$key] = array_merge($v, $vo);
                                continue;
                            }
                        }
					}
				}
			}
		}
        return $list;
    }
    public static function page(){
        $args = func_get_args();
        $args = stripslashes($args[0]);
        preg_match_all('/[a-zA-Z_]\w+=".*?"/is',$args,$arr);
        $arr = $arr[0];
        $arr = array_map('trim',$arr);
        foreach($arr as $k=>$v){
            $pos = strpos($v, "=");
            $name = substr($v, 0, $pos);
            $data[$name] = substr($v, $pos+2,-1);
        }
        if($data['action'] != 'lists') return false;
        $data['category_id'] = intval($data['category_id']);
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select count(1) as count_num from ' . config('DB_TABLE_PRE') . 'content where 1=1 ';
        $category_id = self::get_children_category($data['category_id']);
        $sql .= ' and category_id in (' . implode(',',$category_id) . ')';
        if(isset($data['where'])){
            $sql .= ' and ' . $data['where'] . ' ';
        }
        $tags = trim(getGpc('tags','integer','G'));
        if($tags != 0){
            $sql .= ' and tags like "%,' . $tags . ',%"';
        }
        $data['num'] = intval($data['num']) ? intval($data['num']) : 25;
        $info = $db->getOne($sql);
        $Page  = new Page($info['count_num'],$data['num']);
        $show  = $Page->show();
        $show = preg_replace_callback("/\"http(.*?)index\.php\?a=lists&id=([0-9]+)(.*?)&page=([0-9]+)(.*?)\"/is", array(self,'url_rule'), $show);
        $show = preg_replace_callback("/\"http(.*?)index\.php\?a=lists&othername=([a-z]+)(.*?)&page=([0-9]+)(.*?)\"/is", array(self,'url_rule'), $show);
        return $show;
    }
    public static function position($data){
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'content where 1=1 ';
        $data['category_id'] = intval($data['category_id']);
        if($data['category_id'] == 0) return false;
        $categorys = Content::get_category_cache();
        $category = $categorys[$data['category_id']];
        $category_id = self::get_children_category($data['category_id']);
        $sql .= ' and category_id in (' . implode(',',$category_id) . ')';
        $sql .= ' and posids like "%,'.$data['posid'] . ',%" ';
        
        if(isset($data['order'])){
            $sql .= ' order by ' . $data['order'];
            $sql .= strpos($data['order'],'listorder') !== false ? '' : ' listorder ASC ';
            $sql .= strpos($data['order'],'content_id') !== false ? '' : ' ,content_id DESC ';
        }
        if(isset($data['num'])){
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        $city_id = trim(getGpc('city_id','string','G'));
        if($city_id != ''){
            $city = $db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $city_id . '"');
        }
        foreach($info as &$val){
            if(trim($val['tags'],',') != ''){
                $val['tags'] = $db->getAll('select * from '.config('DB_TABLE_PRE').'tags where tags_id in (' . trim($val['tags'],',') . ')');
            }
            $_category = $categorys[$val['category_id']];
            $parent_ids = explode(',',$_category['parent_ids']);
            $url_role = $parent_ids[1] == 0 ? $categorys[$val['category_id']]['url_name'].'/' : $categorys[$parent_ids[1]]['url_name'].'/';
            if($city && $categorys[$val['category_id']]['type_id'] == 2){
                $val['title'] = $city['name'].$val['title'];
                $val['url'] = $val['url']? $val['url'] : config('SITE_INFO.siteurl') .$url_role.$val['content_id'].'.html?city_id='.$city['mark'];
            }else{
                $val['url'] = $val['url']? $val['url'] : config('SITE_INFO.siteurl') .$url_role.$val['content_id'].'.html';
            }
        }
        if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1 && $category['model_id'] != 0) {
			$ids = array();
			foreach ($info as $v) {
				if (isset($v['content_id']) && !empty($v['content_id'])) {
					$ids[] = $v['content_id'];
				} else {
					continue;
				}
			}
			if (!empty($ids)) {
				$ids = implode(',', $ids);
				$r = $db->getAll('select * from '.config('DB_TABLE_PRE').'model_data'.$category['model_id'] . ' where content_id in (' . $ids . ')');
				if (!empty($r)) {
                    foreach($info as $key => $vo){
                        foreach ($r as $v) {
                            if ($vo['content_id'] == $v['content_id']){
                                $info[$key] = array_merge($v, $vo);
                                continue;
                            }
                        }
					}
				}
			}
		}
        return $info;
    }
    public static function link($data){
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'links ';
        if(isset($data['order'])){
            $sql .= ' order by ' . $data['order'];
            $sql .= strpos($data['order'],'links_id') !== false ? '' : ' links_id DESC ';
        }else{
            $sql .= ' order by links_id DESC ';
        }
        if(isset($data['num'])){
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        return $info;
    }
    public static function region($data){
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'region ';
        if(isset($data['num'])){
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        $joiner = strpos(REQUEST_URI,'?') !== false ? (strpos(REQUEST_URI,'?city_id') !== false ? '?' : '&') : '?';
        $url = strpos(REQUEST_URI,$joiner.'city_id') ? substr(REQUEST_URI,0,strpos(REQUEST_URI,$joiner.'city_id')) : REQUEST_URI;
        $tags = trim(getGpc('tags','integer','G'));
        foreach($info as &$val){
            $val['url'] = $url.$joiner.'city_id='.$val['mark'];
        }
        array_unshift($info,array('name'=>'总站','url'=>$url));
        return $info;
    }
    public static function site($data){
        $db = Mysql::connect();
        $admin_id = config('SITE_INFO.admin_id');
        $sql = 'select * from '.config('DB_TABLE_PRE').'site where status = 1 and admin_id = '.$admin_id . ' ';
        if(isset($data['num'])){
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        return $info;
    }
    public static function tags_category($data){
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'tags_category ';
        if(isset($data['num'])){
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        return $info;
    }
    public static function tags($data){
        $db = Sqlite::connect(config('__DB__'));
        $data['category_id'] = intval($data['category_id']);
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'tags where 1=1 ';
        if($data['tags_category'] == 0) return false;
        $sql .= ' and category_id = ' . $data['tags_category'] ;
        if(isset($data['num'])){
            $sql .= ' limit ' . intval($data['num']);
        }
        if($data['category_id'] == 0) return false;
        $categorys = Content::get_category_cache();
        $category = $categorys[$data['category_id']];
        $info = $db->getAll($sql);
        foreach($info as &$val){
            switch ($category['type_id']){
                case 1:
                case 2:
                $val['url'] = config('SITE_INFO.siteurl');
                    $parent_ids = explode(',',$category['parent_ids']);
                    foreach($parent_ids as $parent_id){
                        if($parent_id != 0){
                            $val['url'] .= $categorys[$parent_id]['url_name'].'/';
                        }
                    }
                $val['url'] .= $category['url_name'].'/';
                    break;
                case 3:
                    $val['url'] = config('SITE_INFO.siteurl') .$category['url_name'].'.html';
                    break;
                case 4:
                    $val['url'] = $category['url'];
                    break;
            }
            $city_id = trim(getGpc('city_id','string','G'));
            if($city_id != ''){
                $city = $db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $city_id . '"');
                $val['url'] .= '?city_id='.$city['mark'].'&tags='.$val['tags_id'];
            }else{
                $val['url'] .= '?tags='.$val['tags_id'];
            }
        }
        return $info;
    }
    public static function ad($data){
        if($data['space_id'] == 0) return false;
        $db = Sqlite::connect(config('__DB__'));
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'ad where space_id = ' . $data['space_id'] .' ';
        if(isset($data['order'])){
            $sql .= ' order by ' . $data['order'];
            $sql .= strpos($data['order'],'listorder') !== false ? '' : ' ,listorder ASC ';
            $sql .= strpos($data['order'],'ad_id') !== false ? '' : ' ,ad_id DESC ';
        }else{
            $sql .= ' order by listorder ASC,ad_id DESC ';
        }
        if(isset($data['num'])){
            $sql .= ' limit ' . intval($data['num']);
        }
        $info = $db->getAll($sql);
        return $info;
    }
    public static function get_category_cache(){
        $data = iReadFile(SITE_PATH .'data/'. config('SITE_INFO.site_dir') . 'cache/cache_categorys.txt');
        return json_decode($data,true);
    }
    public static function get_children_category($category_id){
        $db = Sqlite::connect(config('__DB__'));
        $info = $db->getAll('select category_id from ' . config('DB_TABLE_PRE') . 'category where parent_id = '.$category_id);
        foreach($info as $val){
            $category_ids[] = $val['category_id'];
        }
        unset($info);
        $category_ids = $category_ids ? $category_ids : array();
        $temp = array();
        foreach($category_ids as $child_category_id){
            $temp = self::get_children_category($child_category_id);
            $category_ids = array_merge($category_ids,$temp);
            unset($temp);
        }
        $category_ids[] = $category_id;
        $category_ids = array_filter($category_ids);
        $category_ids = array_unique($category_ids);
        return $category_ids;
    }
    public static function url_rule($matches){
        $categorys = Content::get_category_cache();
        if(is_numeric($matches[2])){
            $category = $categorys[$matches[2]];
        }else{
            $db = Sqlite::connect(config('__DB__'));
            $category = $db->getOne('select * from ' . config('DB_TABLE_PRE') . 'category where url_name = "'.$matches[2].'"');
        }
        switch ($category['type_id']){
            case 1:
            case 2:
                $category['url'] = config('SITE_INFO.siteurl');
                $parent_ids = explode(',',$category['parent_ids']);
                foreach($parent_ids as $parent_id){
                    if($parent_id != 0){
                        $category['url'] .= $categorys[$parent_id]['url_name'].'/';
                    }
                }
                $category['url'] .= $category['url_name'].'/';
                break;
            case 3:
                $category['url'] = config('SITE_INFO.siteurl') .$category['url_name'].'.html';
                break;
            case 4:
                $category['url'] = $category['url'];
                break;
        }
        $url = $category['url'];
        $url .= 'p'.$matches[4] . '.html';
        if($matches[3]){
            $url .= '?' . substr($matches[3],1);
        }
        if($matches[5]){
            if($matches[3] !=''){
                $url .= $matches[3].$matches[5];
            }else{
                $url .= '?' . substr($matches[5],1);
            }
        }
        return $url;
    }
}
/**********************************
*
**********************************/