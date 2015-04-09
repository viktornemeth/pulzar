<?php 
// configuration
$_C['sitename']         = "Pulzar"; 
$_C['robots']           = "index, follow, all";
$_C['analytics']        = ""; 
$_C['debug']            = NULL;

// default language
$_C['default_language'] = "hu"; 

// default template
$_C['default_site_template']  = "default";
$_C['default_admin_template'] = "default";

// URLs and folders
$_C['livesite']             = "http://127.0.0.1:8888/pulzar"; 
$_C['liveadmin']            = $_C['livesite']."/pulzar"; 
//$_C['siteroot']             = "D:/websites/www/pulzar"; 
$_C['siteroot']             = "/Applications/MAMP/htdocs/pulzar";
$_C['language_dir']         = $_C['siteroot']."/languages"; 
$_C['site_template_url']    = $_C['livesite']."/templates/".$_C['default_site_template'];
$_C['admin_template_url']   = $_C['liveadmin']."/templates/".$_C['default_admin_template'];
$_C['site_template_dir']    = $_C['siteroot']."/templates/".$_C['default_site_template'];
$_C['admin_template_dir']   = $_C['siteroot']."/admin/templates/".$_C['default_admin_template'];
$_C['upload_dir']           = $_C['siteroot']."/uploads/files"; 
?>