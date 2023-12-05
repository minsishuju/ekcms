<?php
/**
 * @param int $catid
 * @param string $title
 * @param string $description
 * @param string $keywords
 * @return array
 */
function seo($catid = 0, $title = '', $description = '', $keywords = '') {
	if (!empty($title))$title = strip_tags($title);
	if (!empty($description)) $description = strip_tags($description);
	if (!empty($keywords)) $keywords = str_replace(' ', ',', strip_tags($keywords));
    $cat = array();
	if ($catid != 0) {
		$categorys = Content::get_category_cache();
		$cat = $categorys[$catid];
	}
	$seo['site_title'] = config('SITE_INFO.site_title') ? config('SITE_INFO.site_title') : str_replace(',','|',config('SITE_INFO.keywords')) . '|' . config('SITE_INFO.name');
	$seo['name'] = config('SITE_INFO.name');
	$site_keywords = config('SITE_INFO.keywords');
    $site_description = config('SITE_INFO.description');
	$seo['keyword'] = !empty($keywords) ? $keywords : 
                            (isset($cat['keywords']) && !empty($cat['keywords']) ? $cat['keywords'] : 
                                (!empty($site_keywords) ? $site_keywords : ''));
	$seo['description'] = !empty($description) ? $description : 
                            (isset($cat['description']) && !empty($cat['description']) ? $cat['description'] : 
                                (!empty($site_description) ? $site_description : ''));
    if($cat['type_id'] == 3){
        $cat_title = $cat['title'] ? $cat['title'] : $cat['name'];
        $seo['title'] =  !empty($title) ? $title.' - ' : 
                        (isset($cat_title) && !empty($cat_title) ? $cat_title.' - ' : '');
    }else{
        $seo['title'] =  (!empty($title) ? $title.' - ' : '').
                        (isset($cat['name']) && !empty($cat['name']) ? $cat['name'].' - ' : '');
    }
	foreach ($seo as $k=>$v) {
		$seo[$k] = str_replace(array("\n","\r"),	'', $v);
	}
	return $seo;
}

/**
 * 返回指定栏目路径层级
 * @param int $catid  栏目id
 * @param string $symbol default ''  栏目间隔符
 * @return string
 */
function catpos($catid, $symbol=' > '){
	$category_arr = Content::get_category_cache();
	if(!isset($category_arr[$catid])) return '';
	$pos = '';
    $db = Sqlite::connect(config('__DB__'));
	$arrparentid = array_filter(explode(',', $category_arr[$catid]['parent_ids'].','.$catid));
    $city_id = trim(getGpc('city_id','string','G'));
    $city = array();
    if($city_id != ''){
        $city = $db->getOne('select * from '.config('DB_TABLE_PRE').'region where mark = "' . $city_id . '"');
    }
    foreach($arrparentid as $cat) {
        if($cat != 0){
            switch ($category_arr[$cat]['type_id']){
                case 1:
                case 2:
                    $category_arr[$cat]['url'] = config('SITE_INFO.siteurl');
                    $parent_ids = explode(',',$category_arr[$cat]['parent_ids']);
                    foreach($parent_ids as $parent_id){
                        if($parent_id != 0){
                            $category_arr[$cat]['url'] .= $category_arr[$parent_id]['url_name'].'/';
                        }
                    }
                    $category_arr[$cat]['url'] .= $category_arr[$cat]['url_name'].'/';
                    break;
                case 3:
                    $category_arr[$cat]['url'] = config('SITE_INFO.siteurl') .$category_arr[$cat]['url_name'].'.html';
                    break;
                case 4:
                    $category_arr[$cat]['url'] = $category_arr['url'];
                    break;
            }

            if($city && $category_arr[$cat]['type_id'] == 2){
                $category_arr[$cat]['url'] .= '?city_id='.$city_id;
                $pos .= $symbol . '<a href="'.$category_arr[$cat]['url'].'">'.$city['name'].$category_arr[$cat]['name'].'</a>';
            }else{
                $pos .= $symbol . '<a href="'.$category_arr[$cat]['url'].'">'.$category_arr[$cat]['name'].'</a>';
            }
        }
    }
    $tags = trim(getGpc('tags','integer','G'));
    if($tags != 0){
        $sql = 'select * from ' . config('DB_TABLE_PRE') . 'tags where tags_id= ' . $tags;
        $tags_info = $db->getOne($sql);
        if($tags_info){
            $pos .= $symbol . '<a href="javascript:void(0);">'.$tags_info['name'].'</a>';
        }
    }
	return $pos;
}

function SafeTesting()
{
    $QUERY_STRING = $_SERVER["QUERY_STRING"];

    if(!empty($QUERY_STRING) && substr($_SERVER["QUERY_STRING"],0,2)!="a=")
    {
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        $exceptionFile =  FW_PATH.'template/intercept.html';
        include $exceptionFile;
        exit;
    }

    if(strpos(urldecode($QUERY_STRING),'：')!== false )
    {
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        $exceptionFile =  FW_PATH.'template/intercept.html';
        include $exceptionFile;
        exit;
    }

    if(substr($QUERY_STRING,0,8)=="a=search" && strlen(urldecode($QUERY_STRING)) > 30)
    {
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        echo "查询关键词过长了，请精简下，不要包含特殊字符。。。";
        exit;
    }
}
?>