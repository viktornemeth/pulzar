<?php
$clicked_banner = $sql->select("banners", "*", ["unique_id"=>$id]);
$sql->update("banners", ["clicks[+]"=>1], ["unique_id"=>$id]);

header("Location:".$clicked_banner[0]['target']); 
exit();