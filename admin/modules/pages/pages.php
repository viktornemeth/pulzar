<?php
/*                                             pages.php
.------------------------------------------------------.
|  Software: Kaiten - Administrator contents module    |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
defined('_KAITEN') or die('Restricted access');

$core->lock('su#admin#dev');

switch ($cmd) {

case "edit":
   $page = $sql->select("pages", "*", ["AND" => [
   "language" => $actual_language,
   "url_id"=>$id
   ]]);
   $meta = $sql->select("meta", "*", ["AND" => [
      "language" => $actual_language,
      "url_module" => "page",
      "url_id" => $id  
   ]]);
   $tpl->assign('meta', $meta[0]);
   $tpl->assign('page', $page[0]);
break;

default:
   $pages = $sql->select("pages", "*", ["GROUP" => "url_id"]);
   $tpl->assign('pages', $pages);
break;
}

?>
