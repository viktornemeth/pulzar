<?php
defined('_KAITEN') or die('Restricted access');

$page = $sql->select("pages", "*", ["AND"=>["url_id"=>$id, "language"=>$actual_language]]);

// BANNEREK BETÖLTÉSE
$banner_8 = $banner->render($banner->get(8), '9241712592');
$banner_9 = $banner->render($banner->get(9), '1718445794');
$banner_10 = $banner->render($banner->get(10), '3195178999');
$tpl->assign("banner_8", $banner_8);
$tpl->assign("banner_9", $banner_9);
$tpl->assign("banner_10", $banner_10);

$tpl->assign('page', $page[0]);
?>