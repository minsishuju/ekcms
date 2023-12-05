<?php
function getAllSite($admin_id){
    $db = mysql::connect();
    $admin = $db->getOne('select * from '.config('DB_TABLE_PRE').'admin where admin_id = "' . $admin_id . '"');
    if($admin['is_master'] ==1){
        $list = $db->getAll('select site_id,name from '.config('DB_TABLE_PRE').'site where admin_id = "' . $admin_id . '"');
    }else{
        $list = $db->getAll('select s.site_id,s.name from '.config('DB_TABLE_PRE').'site s left join '.config('DB_TABLE_PRE').'admin_site r on s.site_id = r.site_id where r.admin_id = "' . $admin_id . '"');
    }
    return $list;
}

?>