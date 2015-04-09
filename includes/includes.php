<?php
// Debug
error_reporting($_C['debug']);
// Check configuration
if (!file_exists($_C['siteroot'])) {echo '<strong>Error:</strong> siteroot directory not exists or wrong. Check /config/config-public.php';}

// define CMS
define('_KAITEN', 1);

// Link structure http://www.siteurl.com / {$module} / {$id} / {$cmd}
if (!isset($_GET["q"])){ $q = "index"; } else { $q = $_GET["q"]; }
$var_array = explode("/",$q);
if (!isset($var_array[0]) or $var_array[0]==''){ $module = "index"; } else { $module=$var_array[0];}
if (!isset($var_array[1]) or $var_array[1]==''){ $id = "no-id"; } else { $id=$var_array[1];}
if (!isset($var_array[2]) or $var_array[2]==''){ $cmd = "index"; } else { $cmd=$var_array[2];}

// Medoo Database Class
// Documentation: http://medoo.in/doc
require_once $_C['siteroot'].'/includes/class.medoo.php';
$sql = new medoo([
	'database_type' => 'mysql',
	'database_name' => $db_name,
	'server' => $db_host,
	'username' => $db_username,
	'password' => $db_password,
    'charset' => 'utf8'
]);

// Core Class
require_once $_C['siteroot'].'/includes/class.core.php';
$core = new Core($sql, $_C['livesite'], $_C['siteroot'], $module, $id, $cmd, $is_admin);

// User Class
require_once $_C['siteroot'].'/includes/class.user.php';
$user = new User($sql, $_C['livesite']);

// Banner Class
require_once $_C['siteroot'].'/includes/class.banner.php';
$banner = new Banner($sql, $_C['livesite'], $_C['siteroot']);

// easyimageedit
require_once $_C['siteroot'].'/includes/class.easyimageedit.php';
$img = new EasyImageEdit();

// Url variables to _C
$_C['module'] = $module;
$_C['id'] = $id;
$_C['cmd'] = $cmd;

// AJAX security
$_C['secure'] = $core->setAjaxSecure($private_key);

// RainTPL 3.1
// Documentation: https://github.com/rainphp/raintpl3/wiki/Documentation
if ($is_admin==true) {
   $template_folder = $_C['siteroot'].'/admin';
} else {
   $template_folder = $_C['siteroot'];
}
include $_C['siteroot'].'/plugins/raintpl3-3.1.0/Rain/autoload.php';
include $_C['siteroot'].'/plugins/raintpl3-3.1.0/modifiers.php';
use Rain\Tpl;
$tpl_config = array(
   "tpl_dir"       => $template_folder."/modules/".$module."/view/",
   "cache_dir"     => $template_folder."/cache/"
);
Tpl::configure( $tpl_config );
$tpl = new Tpl;

// RainTPL config and URL variables
$tpl->assign("_C", $_C);
$tpl->assign("module", $module);
$tpl->assign("id", $id);
$tpl->assign("cmd", $cmd);

// Actual language
require_once $_C['siteroot'].'/includes/class.language.php';
$language = new Language($_C['siteroot'], $_C['language_dir'], $_C['default_language'], $module, $is_admin); 
$lang = $language->getLanguage(@$_GET["lang"]);
$actual_language = $_SESSION["language"];


// Email Class using PHPmailer
// Documentation: http://phpmailer.worxware.com/
require_once $_C['siteroot'].'/includes/class.phpmailer.php';
require_once $_C['siteroot'].'/includes/class.email.php';
$mail = new Email($_C['livesite'], $_C['sitename'], $site_email, $site_email_noreply, $smtp_host, $smtp_debug, $smtp_auth, $smtp_port, $smtp_username, $smtp_password, $smtp_charset, $sql);

// Language phrases to template variable
// Usage: ex: {$lang.login}
$tpl->assign('lang', $lang);

// Meta data
// Find meta data in meta table
$meta = $sql->select("meta", ["prefix", "keywords", "description"], ["AND" => ["url_module"=>$module, "url_id"=>$id] ]);
if (empty($meta)) {
    $sql->select("meta", ["prefix", "keywords", "description"], ["AND" => ["url_module"=>'index', "url_id"=>'no-id'] ]);
}

// Actual date / time
$actual_date = date('Y-m-d');
$actual_datetime = date('Y-m-d H:i:s');
?>