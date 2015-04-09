<?php
session_start();
//                                           AJAX Header
//------------------------------------------------------
$is_admin = true;
// Load configuration files /config
require_once "../../../config/config-autoload.php";

// Load includes
require_once "../../../includes/includes.php";

// Check Hash
$core->checkAjaxSecure($private_key);

// Get command
isset($_POST["command"]) ? $command = $_POST["command"] : $command = "";

//                                          /AJAX Header
//------------------------------------------------------

switch ($command) {

//                                                  Save
//------------------------------------------------------
case 'save':
   $submitdata = $core->serializedToArray($_POST['submitdata']);
   $banner_id = $_POST['id'];
   
   $ext = pathinfo($submitdata['banner_file'], PATHINFO_EXTENSION);
   if ($ext == 'swf') {
      $type = 'flash';
   } else {
      $type = 'image';
   }
   
   if ($banner_id != '~new~') {
      $sql->update("banners", [
      "title" => $submitdata['title'],
      "start_date" => $submitdata['start'],
      "end_date" => $submitdata['end'],
      "source" => $submitdata['source'],
      "target" => $submitdata['url'],
      "file" => $submitdata['banner_file'],
      "type" => $type
      ],
      ["id"=>$banner_id]
      );
   } else {
      $banner_id = $sql->insert("banners", [
      "unique_id" => uniqid(),
      "title" => $submitdata['title'],
      "zone" => $submitdata['zone'],
      "source" => $submitdata['source'],
      "start_date" => $submitdata['start'],
      "end_date" => $submitdata['end'],
      "target" => $submitdata['url'],
      "file" => $submitdata['banner_file'],
      "type" => $type,
      "line1" => '',
      "line2" => ''
      ]);
   }
 
   echo json_encode(array(
      "response" => 'true',
      "notify" => $lang['notify']['save_success'],
      "reload_url" => "/banners/".$banner_id."/edit"
    ));
break;

//                                                Upload
//------------------------------------------------------
case 'upload':
   $unique = uniqid();
   $id = $_POST['id'];
   
   $zone = $sql->select('banners_zones', '*', ['id'=>$_POST['zone']]);
   $zone_width = $zone[0]['width'];
   $zone_height = $zone[0]['height'];
   
   if(isset($_FILES["banner"])){ 
      $file = $_FILES["banner"]["name"];
      $ext = pathinfo($file, PATHINFO_EXTENSION);
      $newfile = $unique.'.'.$ext;
      $path = $_C['siteroot']."/uploads/banners/".$newfile;
      if (move_uploaded_file($_FILES["banner"]["tmp_name"], $path)){
         if ($ext=='swf') {
            $file_datas = getimagesize($path);
            $width = $file_datas[0];
            $height = $file_datas[1];
            $type = 'flash';      
         } else {
            $img->load($path);
            $width = $img->getWidth();
            $height = $img->getHeight();
            $type = 'image'; 
         }
         // Check Dimensions
         if ($zone_width!=$width or $zone_height!=$height) {
            echo 'error-dimension';
            unlink($path);
            exit;
         } else {
            $sql->update("banners", [
            "file" => "banners/".$newfile,
            "type" => $type,
            "unique" => $unique
            ],
            ["id"=>$id]
            );
            echo '';
         }
      }
    }
break;

//                                         Switch status
//------------------------------------------------------
case 'switch_status':
   $id = $_POST['id'];
   $status = $_POST['status'];
   $price = $sql->update("banners", ["status"=>$status], ["id"=>$id]);
   echo $price[0]['price'];
break;

//                                        Get zone price
//------------------------------------------------------
case 'get_zone_price':
   $id = $_POST['id'];
   $price = $sql->select("banners_zones", "*", ["id"=>$id]);
   echo $price[0]['price'];
break;

//                                     Update zone price
//------------------------------------------------------
case 'update_zone_price':
   $id = $_POST['id'];
   $price = $_POST['price'];
   $sql->update("banners_zones", ["price"=>$price], ["id"=>$id]);
   return false;
break;

//                                                Delete
//------------------------------------------------------
case 'delete':
   $id = $_POST['id'];
   $table = $_POST['table'];
   $sql->delete($table, ["id" => $id]);
   echo json_encode(array(
      "response" => 'true',
      "notify" => $lang['notify']['delete_success']
    ));
break;
}
?>