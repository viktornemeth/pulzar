<?php
if ($is_admin==false) {$admin_dir = '';} else {$admin_dir = '/admin';}
// Load module from /module
if (!isset($module) or $module == "index"){
	require_once $_C['siteroot'].$admin_dir.'/modules/index/index.php';
}
else {
    $routing_file = $_C['siteroot'].$admin_dir.'/modules/'.$module.'/'.$module.'.php';
    if (file_exists($routing_file)) {
        require $routing_file;   
    }
    else {
       header("HTTP/1.0 404 Not Found");
       require_once $_C['siteroot'].$admin_dir.'/modules/error/error-404.html';
    }
}
// Draw module
$tpl->draw($module.'-'.$cmd);
?>