<?php
/*                                           banners.php
.------------------------------------------------------.
|  Software: Kaiten - Site Banners                     |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
defined('_KAITEN') or die('Restricted access');

$core -> lock('su#admin#dev');

switch ($cmd) {

case "edit":
   $banner = $sql->select("banners", "*", ["id"=>$id]);
   $banner[0]['ctr'] = round($banner[0]['clicks'] / $banner[0]['appearance'], 3);
   $zones = $sql->select("banners_zones", "*");
   if ($id!='~new~') {
      $zone = $sql->select("banners_zones", "*", ["id"=>$banner[0]['zone']]);
      $tpl->assign('zone', $zone[0]);
   }
   $tpl->assign('zones', $zones);
   $tpl->assign('banner', $banner[0]);
break;

case "zones":
   $zones = $sql->select("banners_zones", "*");
   $tpl->assign('zones', $zones);
break;

default:
   $banners_query = $sql->query("SELECT * FROM banners ORDER BY end_date DESC");
   $banners = array();
   while ($banners_array = $banners_query->fetch(PDO::FETCH_ASSOC)) {
      $banners_array['ctr'] = round($banners_array['clicks'] / $banners_array['appearance'], 3); 
      $zone = $sql->select("banners_zones", "*", ["id" => $banners_array['zone']]);
      $banners_array['zone_title'] = $zone[0]["title"];
      $banners_array['zone_width'] = $zone[0]["width"];
      $banners_array['zone_height'] = $zone[0]["height"];
      array_push($banners, $banners_array);
   }
   $tpl->assign('banners', $banners);
break;
}
