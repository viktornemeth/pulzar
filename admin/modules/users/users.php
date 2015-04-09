<?php
/*                                             users.php
.------------------------------------------------------.
|  Software: Kaiten - Administrator users module       |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
defined('_KAITEN') or die('Restricted access');

$core->lock('su#dev');


switch ($cmd) {

case "edit":
   $u = $sql->select("users", "*", ["id"=>$id]);
   $access_array = explode('#', $u[0]['access']);
   $access_types = array();
   if (in_array("admin", $access_array)) { $access_types['admin']=1; }
   if (in_array("su", $access_array)) { $access_types['su']=1; }
   if (in_array("dev", $access_array)) { $access_types['dev']=1; }
   $tpl->assign('u', $u[0]);
   $tpl->assign('access_types', $access_types);
break;

default:
   $users_query = $sql->query("SELECT * FROM users ORDER BY id DESC");
   $users = array();
   while ($users_array = $users_query->fetch(PDO::FETCH_ASSOC)) {
      $access_array = explode('#', $users_array['access']);
      if (in_array("admin", $access_array)) { $users_array['type']='admin'; }
      if (in_array("su", $access_array)) { $users_array['type']='su'; }
      if (in_array("dev", $access_array)) { $users_array['type']='dev'; }
      array_push($users, $users_array);
   }
   $tpl->assign('users', $users);
break;
}

?>